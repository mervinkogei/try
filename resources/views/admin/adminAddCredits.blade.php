@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Confirm MPESA codes</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('admin.includes.navbar')




    <div class="container">
        <div class="py-5 text-center">

            <h2>MPESA Codes</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">This will be used as payment in the system</h4>
                <form class="needs-validation" action="{{ route('adminPostAddCredits') }}" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="code">Mpesa Codes</label>
                            <input type="text" name="code" class="form-control" id="code" placeholder="Clients will use this to top up account" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="value">Value</label>
                            <input type="number" name="amount" class="form-control" id="value" placeholder="Value of this credit code" value="" required>
                        </div>
                    </div>
                    <hr class="mb-4">
                    {{ csrf_field() }}
                    <button class="btn btn-success btn-lg " type="submit">Add MPESA Code</button>
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