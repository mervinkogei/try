@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>Admin | View hall Data</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('admin.includes.navbar')



    <div class="container">
        <div class="py-5 text-center">

            <h2>{{ $hall->name }} - Ksh {{ $hall->ppn }} per Night!!</h2>
        </div>
    </div>

    <main role="main">
        <div class="album py-5 bg-light">
            <div class="container">

                <div class="row">
                    @foreach(\App\Photo::where('native', 'hall')->where('nativeid', $hall->id)->get() as $hallPhoto)
                        <div class="col-md-4">
                            <div class="card mb-4 box-shadow">
                                <img class="card-img-top" src="{{ asset('storage/images/'.$hallPhoto->name) }}" alt="hall Image">
                            </div>
                        </div>
                    @endforeach

                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card flex-md-row mb-4 box-shadow">
                            <div class="card-body d-flex flex-column align-items-start">
                                <strong class="d-inline-block mb-2 text-primary">Ksh {{ $hall->ppn }}</strong>
                                <h3 class="mb-0">
                                    <a class="text-dark" href="#">{{ $hall->name }} - {{ $hall->location }}</a>
                                </h3>
                                <div class="mb-1 text-muted">Capacity - {{ $hall->capacity }}</div>
                                <div class="mb-1 text-muted">Theme - {{ $hall->theme }}</div>
                                <p class="card-text mb-auto">{{ $hall->info }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="container">
                    <div class="py-5 text-center">
                        <u>
                            <h2>Bookings</h2>
                        </u>
                    </div>
                    <table class="table table-hover table-striped table-bordered table-responsive-lg">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Charges</th>
                            <th scope="col">Capacity</th>
                            <th scope="col">hall</th>
                            <th scope="col">Checkin</th>
                            <th scope="col">Check Out</th>
                            <th scope="col">Status</th>
                            <th scope="col">Confirm</th>
                            <th scope="col">Cancel</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($bookings as $booking)
                            <tr class="
                    @if($booking->status == "pending")
                                    bg-warning
@endif
                            @if($booking->status == "active")
                                    bg-success
@endif
                            @if($booking->status == "done")
                                    bg-info
@endif
                            @if($booking->status == "canceled")
                                    bg-danger
@endif ">
                                <th>{{ $booking->receipt }}</th>
                                <th>{{ \App\Payment::where('receiptno', $booking->receipt)->first()->credit }}</th>
                                <th>{{ $booking->capacity }}</th>

                                <th>{{ \App\Hall::where('id', $booking->hall)->first()->name }}, {{ \App\Hall::where('id', $booking->hall)->first()->location }}</th>
                                <th>{{ \Carbon\Carbon::parse($booking->checkin)->format("d F, Y") }}</th>
                                <th>{{ \Carbon\Carbon::parse($booking->checkout)->format("d F, Y") }}</th>
                                <th>{{ $booking->status }}</th>

                                <th>
                                    <a href="{{ route('adminConfirmBooking', ['booking' => $booking->id]) }}" class="btn btn-success btn-sm
                            @if($booking->status != "pending" || \Carbon\Carbon::now() >= \Carbon\Carbon::parse($booking->checkin) )
                                            disabled
@endif ">
                                        Confirm
                                    </a>
                                </th>
                                <th>
                                    <a href="{{ route('adminCancelBooking', ['booking' => $booking->id]) }}" class="btn btn-danger btn-sm
                            @if($booking->status != "pending" ||  \Carbon\Carbon::now() >= \Carbon\Carbon::parse($booking->checkin) )
                                            disabled
@endif ">
                                        Cancel
                                    </a>
                                </th>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{ $bookings->links() }}
                    <footer class="my-5 pt-5 text-muted text-center text-small">
                        <p class="mb-1">&copy; {{ date("Y") }}</p>
                    </footer>
                </div>
            </div>
        </div>
    </main>

    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; {{ date("Y") }}</p>
    </footer>
@endsection

@section('scripts')
    <script>window.jQuery || document.write('<script src="{{ asset('bootstrap/assets/js/vendor/jquery-slim.min.js') }}"><\/script>')</script>
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/assets/js/vendor/popper.min.js') }}"></script>
@endsection