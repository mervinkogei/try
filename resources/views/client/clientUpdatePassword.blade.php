@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Client | Update Password</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('client.includes.navbar')

    <div class="container">
        <div class="py-5 text-center">

            <h2>Update Password</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">All fields are required</h4>
                <form class="needs-validation" action="{{ route('clientPostUpdatePassword') }}" method="post">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="password">Your Password</label>
                            <input type="password" name="password" class="form-control" id="code" placeholder="Your Current Password" value="" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="code">New Password</label>
                            <input type="password" name="newpass" class="form-control" id="code" placeholder="Your Password" value="" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="code">Confirm Password</label>
                            <input type="password" name="conpass" class="form-control" id="code" placeholder="Confirm your new Password" value="" required>
                        </div>

                    </div>
                    <hr class="mb-4">
                    {{ csrf_field() }}
                    <button class="btn btn-primary btn-lg" type="submit">Update Password</button>
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