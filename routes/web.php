<?php

use App\Booking;
use App\Http\Controllers\FuncController;
use App\Money;
use App\Payment;
use App\Photo;
use App\hall;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', [
    'as' => 'homeLogin',
    function(){
        return view('rootLogin');
    }
]);

Route::get('/signup', [
    'as' => 'homeSignUp',
    function(){
        return view('signup');
    }
]);

Route::get('logout', [
    'as' => 'logout',
    function(){
        Auth::logout();
        return redirect()->route('clientHome')->with([
            'title' => "Goodbye",
            'message' => "",
            'status' => 'info'
        ]);
    }
])->middleware('auth');

Route::get('loginn', [
    'as' => 'login',
    function(){
        $func = new FuncController();
        return $func->toRouteWithMessage('homeLogin', 'Logged Out', '', 'info');
    }
]);

Route::post('postSignUp', [
    'as' => 'postSignUp',
    function(Request $request){
        $func = new FuncController();
        $client = new User();
        $client->name = $request['name'];
        $client->phone = $request['phone'];
        $client->usertype = "client";
        $client->status = "active";

        if($request['pass'] != $request['conpass']){
            return $func->backWithMessage("Sorry", "Your Passwords do Not matech", "error");
        }

        $client->password = bcrypt($request['pass']);

        if(User::where('phone', $request['phone'])->count() > 0){
            return $func->backWithMessage("Sorry", "Phone Number Exists in system", "error");
        }

        if($client->save()){
            if($request->hasFile('file')){
                if($func->uploadImage($request->file('file'), "user", "512x512", $client->id)){
                    return $func->backWithMessage("Success", "Sign Up Successful, You may Login now", "success");
                }else{
                    $client->delete();
                    return $func->backWithUnknownError();
                }
            }else{
                $client->delete();
                return $func->backWithMessage("Failed", "Image Upload Failed", "error");
            }
        }else{
            return $func->backWithUnknownError();
        }

    }
]);

Route::post('postSignIn', [
    'as' => 'postSignIn',
    function(Request $request){
        $func = new FuncController();
        if(Auth::attempt(['phone' => $request['phone'], 'password' => $request['password'],  'status' => 'active'])){
            $user = User::where('phone', $request['phone'])->first();
            if($user->usertype == "client"){
                // Login client
                return $func->toRouteWithMessage("clientHome", "", "Welcome Back", "info");
            }else if ($user->usertype == "admin"){
                // Login Admin
                return $func->toRouteWithMessage("adminHome", "", "Welcome Back Admin", "info");
            }
        }else{
            return $func->backWithMessage("Failed", "Login Failed, Please Check Your Phone and Password", "error");
        }
    }
]);

Route::get('admin/home', [
    'as' => "adminHome",
    function(){
        return view("admin.adminHome");
    }
])->middleware('auth')->middleware('ca');

Route::post('admin/postAddhall', [
    'as' => 'adminAddhall',
    function(Request $request){
        $func = new FuncController();
        $hall = new Hall();
        $hall->name = $request['name'];
        $hall->ppn = $request['charges'];
        $hall->status = "active";
        $hall->location = $request['location'];
        $hall->theme = $request['theme'];
        $hall->capacity = $request['capacity'];
        $hall->size = $request['size'];
        $hall->info = $request['info'];
        if($hall->save()){
            return redirect()->route("adminAddhallPhotosPage", [
                "hallId" => $hall->id
            ])->with([
                "title" => "Add Some Photos Now",
                "message" => "",
                "status" => "info"
            ]);
        }else{
            return $func->backWithUnknownError();
        }
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/addphotos/{hallId}', [
    'as' => 'adminAddhallPhotosPage',
    function($hallId){
        $func = new FuncController();
        $hallRaw = Hall::where('id', $hallId);
        if($hallRaw->count() != 1){
            return $func->backWithMessage("Sorry", "Hall not Found", "error");
        }else{
            return view('admin.addImagesTohall', [
                "hallid" => $hallId
            ]);
        }
    }
])->middleware('auth')->middleware('ca');

Route::post('admin/postAddPhotos', [
    'as' => 'adminPostAddhallPhotos',
    function(Request $request){
        $func = new FuncController();
        $hallRaw = Hall::where('id', $request['hallid']);
        if(Photo::where('native', 'hall')->where('nativeid', $request['hallid'])->count() >= 10){
            return $func->backWithMessage("Sorry", "Maximum Images for hall reached", "warning");
        }
        if($hallRaw->count() != 1){
            return $func->backWithMessage("Not Found", "Hall Not Found", "warning");
        }else{
            if($request->hasFile("file")){
                if($func->uploadImage($request->file('file'), "hall", "512x512", $request['hallid'])){
                    return $func->backWithMessage("Uploaded", "You can upload another image", "success");
                }else{
                    return $func->backWithUnknownError();
                }
            }else{
                return $func->backWithMessage("No Image", "", "info");
            }
        }
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/addcredits', [
    'as' => 'adminAddCredits',
    function(){
        $func = new FuncController();
        return view('admin.adminAddCredits');
    }
])->middleware('auth')->middleware('ca');

Route::post('admin/postAddCredits', [
    'as' => 'adminPostAddCredits',
    function(Request $request){
        $func = new FuncController();
        $money = new Money();
        $money->code = $request['code'];
        $money->value = $request['amount'];
        $money->status = "active";
        if($money->save()){
            return $func->backWithMessage("Added", "Saved", "success");
        }else{
            return $func->backWithUnknownError();
        }
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/halls', [
    'as' => 'adminViewhalls',
    function(){
        $func = new FuncController();
        $halls = Hall::where('status', 'active')->orderby('id', 'desc')->paginate(5);
        return view('admin.adminViewhalls', [
            'halls' => $halls
        ]);
    }
])->middleware('auth')->middleware('ca');

Route::get('/', [
    'as' => "clientHome",
    function(){
        $halls = Hall::where('status', 'active')->orderby('id', 'desc')->paginate(5);
        return view("client.clientHome", [
            'halls' => $halls
        ]);
    }
]);

Route::get('client/halls/{hallid}', [
    'as' => 'clientViewhall',
    function($hallid){
        $func = new FuncController();
        $hallRaw = Hall::where('id', $hallid);
        if($hallRaw->count() != 1){
            return $func->backWithMessage("Hall not found", "", "error");
        }else{
            $hall = $hallRaw->first();
            return view('client.viewSinglehall', [
                'hall' => $hall
            ]);
        };
    }
]);

Route::post('client/postBookhall', [
    'as' => 'clientPostBookhall',
    function(Request $request){
        $func = new FuncController();
        $hallRaw = Hall::where('id', $request['hallid']);
        if($hallRaw->count() != 1){
            return $func->backWithMessage("Hall not found", "", "error");
        }else{
            $hall = $hallRaw->first();
        }
        $checkin = Carbon::parse($request['checkindate'] ." ".$request['checkintime']);
        $checkout = Carbon::parse($request['checkoutdate'] ." ".$request['checkouttime']);
        if($checkin >= $checkout){
            return $func->backWithMessage("Failed", "The Check out Date must be greater that Check in date", "error");
        }

        if($checkin->diffInHours($checkout) == 0){
            return $func->backWithMessage("Failed", "The time is too short", "error");
        }

        if($hall->capacity < $request['capacity']){
            return $func->backWithMessage("Failed", "The hall you requested cannot hold that capacity", "error");
        }

        $booking = new Booking();
        $booking->user = Auth::user()->getAuthIdentifier();
        $booking->checkin = $checkin;
        $booking->checkout = $checkout;
        $booking->capacity = $request['capacity'];
        $booking->hall = $request['hallid'];
        $booking->status = "pending";
        $receiptno = "";

        if(Booking::where('hall', $hall->id)->where('status', 'pending')->orWhere('status', 'complete')->count() > 0){
            return $func->backWithMessage("Sorry", "You have already booked this hall", "error");
        }
        if(Booking::where('hall', $hall->id)->where('checkin', '>=', Carbon::parse($booking->checkin))->where('checkout', '<=', Carbon::parse($booking->checkout))->count() > 0){
            return $func->backWithMessage("Sorry", "THis hall is not available at that time", "error");
        }

        do{
            $receiptno = $func->generateRandomString(10);
        }while($receiptno == "" || Payment::where('receiptno', $receiptno)->count() == 1 );
        $booking->receipt = $receiptno;

        $diffHours = $checkin->diffInHours($checkout);
        $chargePerHour = $hall->ppn;
        $charges = $chargePerHour * $diffHours;

        if($charges > $func->getClientBalance(Auth::user()->getAuthIdentifier())){
            return $func->backWithMessage("Not Enough Balance", "Your Balance is Ksh. ". $func->getClientBalance(Auth::user()->getAuthIdentifier()). "while the required balnce is Ksh. ".$charges, "error");
        }

        $payment = new Payment();
        $payment->user = Auth::user()->getAuthIdentifier();
        $payment->receiptNo = $receiptno;
        $payment->credit = $charges;
        $payment->debit = 0;
        $payment->description = "Booking for hall ".$hall->name. " on ". Carbon::now();
        $payment->paidfor = "Hall Booking";

        if($booking->save()){
            if($payment->save()){
                return redirect()->back()->with([
                    "title" => $payment->receiptno,
                    "message" => "You have successfully booked a hall",
                    "status" => "success",
                    "booking" => $booking,
                    "payment" => $payment
                ]);
//                    return $func->backWithMessage($payment->receiptno, "You have booked a hall and your receipt number is: ". $payment->receiptno, "success");
            }else{
                $booking->delete();
                return $func->backWithMessage("Error perfoming transaction", "", "error");
            }
        }else{
            return $func->backWithMessage("Could not save booking", "", "warning");
        }
    }
])->middleware('auth')->middleware('cc');

Route::get('client/topup', [
    'as' => 'clientTopUpBalance',
    function(){
        return view('client.topUpBalance');
    }
])->middleware('auth')->middleware('cc');

Route::post('client/posttopup', [
    'as' => 'clientPostTopUp',
    function(Request $request){
        $func = new FuncController();
        $moneyRaw = Money::where('code', $request['code'])->where('status', 'active');
        if($moneyRaw->count() != 1){
            return $func->backWithMessage("Wrong MPESA Code", "", "error");
        }else{
            $money = $moneyRaw->first();
            $payment = new Payment();
            $payment->user = Auth::user()->getAuthIdentifier();
            $receiptno = "";
            do{
                $receiptno = $func->generateRandomString(10);
            }while($receiptno == "" || Payment::where('receiptno', $receiptno)->count() == 1 );
            $payment->receiptno = $receiptno;
            $payment->credit = 0;
            $payment->debit = $money->value;
            $payment->description = "Topped Up MPESA code: ".$request['code'];
            $payment->paidfor = "Loaded credit";

            $money->status = "used";
            if($payment->save()){
                $money->save();
                return $func->backWithMessage("Topped Up", "", "success");
            }else{
                return $func->backWithMessage("Failed", "", "error");
            }

        }
    }
])->middleware('auth')->middleware('cc');

Route::get('client/payments', [
    'as' => 'clientViewPayments',
    function(){
        $payments = Payment::where('user', Auth::user()->getAuthIdentifier())->orderby('id', 'desc')->paginate(10);
        return view('client.clientPayment', [
            "payments" => $payments
        ]);
    }
])->middleware('auth')->middleware('cc');

Route::get('client/bookings', [
    'as' => 'clientViewBookings',
    function(){
        $bookings = Booking::where('user', Auth::user()->getAuthIdentifier())->orderby('id', 'desc')->paginate(10);
        return view('client.clientBookings', [
            "bookings" => $bookings
        ]);
    }
])->middleware('auth')->middleware('cc');

Route::get('client/cancelbooking/{booking}', [
    'as' => 'clientCancelBooking',
    function($bookId){
        $func = new FuncController();
        $bookRaw = Booking::where('id', $bookId)->where('status', 'pending')->where('user', Auth::user()->getAuthIdentifier());
        if($bookRaw->count() != 1){
            return $func->backWithMessage("Sorry", "Booking not found", "error");
        }
        $booking = $bookRaw->first();
        $booking->status = "canceled";
        if($booking->save()){
            $payment = Payment::where('receiptno', $booking->receipt)->first();
            $payDeb = new Payment();
            do{
                $payDeb->receiptno = $func->generateRandomString(10);
            }while($payDeb->receiptno == "" || Payment::where('receiptno', $payDeb->receiptno)->count() == 1 );
            $payDeb->user = Auth::user()->getAuthIdentifier();
            $payDeb->credit = 0;
            $payDeb->debit = $payment->credit;
            $payDeb->description = "Refund for canceled booking of hall ".Hall::where('id', $booking->hall)->first()->name.", ".Hall::where('id', $booking->hall)->first()->location;
            $payDeb->paidfor = "Refunding";
            if($payDeb->save()){
                return $func->backWithMessage("Canceled", "Your Booking has been Canceled and money has been debited back to your account", "info");
            }else{
                return $func->backWithMessage("Canceled", "But refund could not not be accomplished", "warning");
            }
        }else{
            return $func->backWithMessage("Failed", "System Failure", "error");
        }
    }
])->middleware('auth')->middleware('cc');

Route::get('admin/bookings', [
    'as' => 'adminViewBookings',
    function(){
        $bookings = Booking::orderby('id', 'desc')->paginate(10);
        return view('admin.adminViewBookings', [
            'bookings' => $bookings
        ]);
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/confirmbooking/{booking}', [
    'as' => 'adminConfirmBooking',
    function($bookId){
        $func = new FuncController();
        $bookRaw = Booking::where('id', $bookId)->where('status', 'pending');
        if($bookRaw->count() != 1){
            return $func->backWithMessage("Sorry", "Booking not found", "error");
        }
        $booking = $bookRaw->first();
        $booking->status = "active";
        if($booking->save()){
            return $func->backWithMessage("Confirmed", "Booking has been Confirmed and money has been debited back to user account", "success");
        }else{
            return $func->backWithMessage("Failed", "System Failure", "error");
        }
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/cancelbooking/{booking}', [
    'as' => 'adminCancelBooking',
    function($bookId){
        $func = new FuncController();
        $bookRaw = Booking::where('id', $bookId)->where('status', 'pending');
        if($bookRaw->count() != 1){
            return $func->backWithMessage("Sorry", "Booking not found", "error");
        }
        $booking = $bookRaw->first();
        $booking->status = "canceled";
        if($booking->save()){
            $payment = Payment::where('receiptno', $booking->receipt)->first();
            $payDeb = new Payment();
            do{
                $payDeb->receiptno = $func->generateRandomString(10);
            }while($payDeb->receiptno == "" || Payment::where('receiptno', $payDeb->receiptno)->count() == 1 );
            $payDeb->user = $booking->user;
            $payDeb->credit = 0;
            $payDeb->debit = $payment->credit;
            $payDeb->description = "Refund for canceled booking of hall ".Hall::where('id', $booking->hall)->first()->name.", ".Hall::where('id', $booking->hall)->first()->location;
            $payDeb->paidfor = "Refunding";
            if($payDeb->save()){
                return $func->backWithMessage("Canceled", "Booking has been Canceled and money has been debited back to Clients account", "info");
            }else{
                return $func->backWithMessage("Canceled", "But refund could not not be accomplished", "warning");
            }
        }else{
            return $func->backWithMessage("Failed", "System Failure", "error");
        }
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/viewpayments', [
    'as' => 'adminViewPayments',
    function(){
        $payments = Payment::orderBy('id', 'desc')->paginate(10);
        return view('admin.adminPayments', [
            'payments' => $payments
        ]);
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/deletehall/{hallid}', [
    'as' => 'adminDeletehall',
    function($hallid){
        $func = new FuncController();
        $bookings = Booking::where('hall', $hallid)->get();
        foreach($bookings as $booking){
            $booking->delete();
        }
        $hall = Hall::where('id', $hallid)->first();
        $hall->delete();

        return $func->backWithMessage("Delete", "Hall and all its data tree have been deleted", "info");
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/updatehall/{hallid}', [
    'as' => 'adminViewUpdatehall',
    function($hallid){
        $func = new FuncController();
        $hallRaw = Hall::where('id', $hallid);
        if($hallRaw->count() != 1){
            return $func->backWithMessage("Hall Not found", "", "error");
        }
        $hall = $hallRaw->first();
        return view('admin.adminUpdatehall', [
            'hall' => $hall
        ]);
    }
])->middleware('auth')->middleware('ca');

Route::post('admin/postupdatehall', [
    'as' => 'postUpdatehall',
    function(Request $request){
        $func = new FuncController();
        $hall = Hall::where('id', $request['hallid'])->first();
        $hall->name = $request['name'];
        $hall->location = $request['location'];
        $hall->ppn = $request['charges'];
        $hall->capacity = $request['capacity'];
        $hall->theme = $request['theme'];
        $hall->size = $request['size'];
        $hall->info = $request['info'];
        if($hall->update()){
            return $func->backWithMessage("Updated", "", "success");
        }else{
            return $func->backWithMessage("Sorry, and error occurred", "", "error");
        }
    }
])->middleware('auth')->middleware('ca');

Route::get('client/updatepassword', [
    'as' => 'clientUpdatePassword',
    function(){
        return view('client.clientUpdatePassword');
    }
])->middleware('auth')->middleware('cc');

Route::post('client/postUpdatePassword', [
    'as' => 'clientPostUpdatePassword',
    function(Request $request){
        $func = new FuncController();
        $user = Auth::user();

        if($request['newpass'] != $request['conpass']){
            return $func->backWithMessage("Sorry", "Your Password don't match", "error");
        }else{
            if(!Hash::check($request['password'], $user->getAuthPassword())){
                return $func->backWithMessage("Your Password is incorrect", "", "error");
            }else{
                $user->password = bcrypt($request['password']);
                if($user->update()){
                    return $func->backWithMessage("Updated", "Password has been updated", "success");
                }else{
                    return $func->backWithMessage("Sorry", "We could not update your password", "error");
                }
            }
        }
    }
])->middleware('auth')->middleware('cc');

Route::get('admin/hallandhistory/{hallid}', [
    'as' => 'adminViewhallAndHistory',
    function($hallid){
        $func = new FuncController();
        $hallRaw = Hall::where('id', $hallid);
        if($hallRaw->count() == 0){
            return $func->backWithMessage("Sorry", "Hall not found", "error");
        }
        $hall = $hallRaw->first();
        return view('admin.adminViewhallData', [
            'hall' => $hall,
            'bookings' => Booking::where('hall', $hall->id)->paginate(10)
        ]);
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/viewclients', [
    'as' => 'adminViewClients',
    function(){
        $clients = User::where('usertype', 'client')->paginate(10);
        return view('admin.adminViewClients', [
            'clients' => $clients
        ]);
    }
])->middleware('auth')->middleware('ca');

Route::get('admin/resetclientpassword/{client}', [
    'as' => 'resetClientPassword',
    function($client){
        $func = new FuncController();
        $userRaw = User::where('usertype', 'client')->where('id', $client);
        if($userRaw->count() != 1){
            return $func->backWithMessage("Client not found", "", "error");
        }else{
            $user = $userRaw->first();
            $user->password = bcrypt($user->phone);
            if($user->update()){
                return $func->backWithMessage("Updated", "Password has been reset to users phone number", "success");
            }else{
                return $func->backWithMessage("An error occurred while resetting password", "", "error");
            }
        }
    }
])->middleware('auth')->middleware('ca');

