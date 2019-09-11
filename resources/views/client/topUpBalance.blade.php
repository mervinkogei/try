@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client | Top Up</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('client.includes.navbar')




    <div class="container">
        <div class="py-5 text-center">

            <h2>Pay into Account</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Enter MPESA Confirmation code below</h4>
                <form class="needs-validation" action="{{ route('clientPostTopUp') }}" method="post">
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="code">Credit Code</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="Enter Code and submit" value="" required>
                        </div>
                    </div>
                    <hr class="mb-4">
                    {{ csrf_field() }}
                    <button class="btn btn-success btn-lg btn-block" type="submit">Top Up</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; {{ date("Y") }}</p>
        </footer>
    </div>




@endsection

@section('scripts')
    <script>window.jQuery || document.write('<script src="{{ asset('bootstrap/assets/js/vendor/jquery-slim.min.js') }}"><\/script>')</script>
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/assets/js/vendor/popper.min.js') }}"></script>
@endsection