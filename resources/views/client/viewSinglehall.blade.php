@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
  
    <title>Client | View hall</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
    <link href="{{ asset('css/album.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('client.includes.navbar')



    <div class="container">
        <div class="py-5 text-center">

            <h2>{{ $hall->name }} - Ksh {{ $hall->ppn }} per Day</h2>
        </div>
    </div>

    @if(Session::has('booking'))
    <div class="container">
        <div class="py-5 text-center">
            <h2>You have booked this hall Details: </h2>
            <h3>Receipt Number: </h3>
            <h4>{{ (Session::get('booking'))->receipt }}</h4>
            <h3>From : {{ (Session::get('booking'))->checkin }}</h3>
            <h3>To: {{ (Session::get('booking'))->checkout }}</h3>
            <h3 style="color: #0023ff"> Total Days {{ \Carbon\Carbon::parse(Session::get('booking')->checkin)->diffInDays(Session::get('booking')->checkout) }}  </h3>
            <h3 style="color: #00cc00"> Amount Per day = {{ \App\hall::where('id', Session::get('booking')->hall)->first()->ppn }}</h3>
            <h3 style="color: #ff0d00"> Total Amount = {{ \Carbon\Carbon::parse(Session::get('booking')->checkin)->diffInDays(Session::get('booking')->checkout) * \App\hall::where('id', Session::get('booking')->hall)->first()->ppn }} </h3>
            <h3>Status: {{ (Session::get('booking'))->status }}</h3>

        </div>
    </div>
    @endif



    <main role="main">

        <section class="jumbotron text-center">
            <div class="container">
                <h2 class="jumbotron-heading"><u>Book hall</u></h2>
                @if(\Illuminate\Support\Facades\Auth::check() == true)
                <form action="{{ route('clientPostBookhall') }}" method="post" >
                    <div class="row">
                        <div class="col-md-6">
                            <h3>Check In Date</h3>
                            <input type="date" name="checkindate" class="form-control" value="" required>
                            <input type="time" name="checkintime" class="form-control" value="" required>
                        </div>
                        <div class="col-md-6">
                            <h3>Check Out Date</h3>
                            <input type="date" name="checkoutdate" class="form-control" value="" required>
                            <input type="time" name="checkouttime" class="form-control" value="" required>
                        </div>
                        <br>
                        <div class="col-md-12">
                            <h5>Capacity</h5>
                            <input type="number" name="capacity" class="form-control" value="" required>
                        </div>
                    </div>
                    <p>
                        <input type="hidden" value="{{ $hall->id }}" name="hallid">
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-success btn-block my-2" value="Book">
                    </p>
                </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-info btn-md">Login to book a hall</a>
                @endif

            </div>
        </section>

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
            </div>
        </div>

    </main>


    <footer class="my-5 pt-5 text-muted text-center text-small">
        <p class="mb-1">&copy; {{ date("Y") }}</p>
    </footer>





@endsection

@section('scripts')
    <script>window.jQuery || document.write('<script src="{{ asset('bootstrap/assets/js/vendor/jquery-slim.min.js') }}"><\/script>')</script>
    {{--<script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>--}}
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/assets/js/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('css/holder.min.js') }}"></script>
    <script>
        Holder.addTheme('thumb', {
            bg: '#55595c',
            fg: '#eceeef',
            text: 'Thumbnail'
        });
    </script>
@endsection