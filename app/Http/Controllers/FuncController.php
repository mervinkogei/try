<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Photo;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class FuncController extends Controller{
    public function uploadImage($photo, $model, $dimensions, $nativeid){
        $ext = $photo->getClientOriginalExtension();
        if(
            $ext!='jpg'
            && $ext!='JPG'
            && $ext != 'PNG'
            && $ext != 'png'
            && $ext != 'JPEG'
            && $ext != 'jpeg'
            && $ext != 'bmp'
            && $ext != 'BMP'
            && $ext != 'gif'
            && $ext != 'GIF'
            && $ext != 'svg'
            && $ext != 'SVG'
        ){
            return false;
        }
        ini_set("gd.jpeg_ignore_warning", 1);
        do{
            $name = $this->generateRandomString(50).'.'.$ext;
        }while(Photo::where('name', $name)->count() > 0 );
        $dimens = explode("x", $dimensions);

        if(Image::make($photo)->fit($dimens[0], $dimens[1], function ($contraint){})->save('storage/images/'.$name)){
            $img = new Photo();
            $img->name = $name;
            $img->native = $model;
            $img->dimension = $dimensions;
            $img->nativeid = $nativeid;
            if($img->save()){
                return true;
            }
        }

        return false;
    }

    public function generateRandomString($length = 4) {
        $characters = '23456789ABCEFGHJKMNPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function pmPostUploadProfilePic(Request $request){
        $func = new FuncController();
        $user = Auth::user();
        if($request->hasFile('file')){
            //delete existing image:
            if(Photo::where('native', 'user')->where('nativeid', $user->id)->count() > 0){
                $photo = Photo::where('native', 'user')->where('nativeid', $user->id)->first();
                $photo->delete();
            }

            $uploaded = $func->uploadImage($request->file('file'), "user", "200x200", $user->id);
            if($uploaded){
                return http_response_code(200);
            }else{
                return http_response_code(401);
            }
        }else{
            return http_response_code(401);
        }
    }

    public function backWithMessage($title, $message, $status){
        return redirect()->back()->with([
            'title' => $title,
            'message' => $message,
            'status' => $status
        ]);
    }

    public function justBack(){
        return redirect()->back();
    }

    public function toRouteWithMessage($route, $title, $message, $status){
        return redirect()->route($route)->with([
            'title' => $title,
            'message' => $message,
            'status' => $status
        ]);
    }

    public function backWithUnknownError(){
        return redirect()->back()->with([
            'title' => 'Sorry!!',
            'message' => 'A Fatal Error Occurred, We are however working on it',
            'status' => 'error'
        ]);
    }

    public static function getClientBalance($userId){
        $credit = Payment::where('user', $userId)->sum('credit');
        $debit = Payment::where('user', $userId)->sum('debit');
        return $debit-$credit;
    }


}
