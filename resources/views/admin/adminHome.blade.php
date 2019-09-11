@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | Add hall</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('admin.includes.navbar')




    <div class="container">
        <div class="py-5 text-center">

            <h2>Add A hall</h2>
        </div>
        <div class="row">
            <div class="col-md-12 order-md-1">
                <h4 class="mb-3">Please fill all relevant Details</h4>
                <form class="needs-validation" action="{{ route('adminAddhall') }}" method="post">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name">Name </label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter Name to Display to Client" value="" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="location">Location</label>
                            <input type="text" name="location" class="form-control" id="location" placeholder="Enter Location (Will be used in searches)" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="charges">Charges </label>
                            <input type="number" min="0" name="charges" class="form-control" id="charges" placeholder="Charges per Day for hall" value="" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="capacity">Capacity </label>
                            <input type="number" min="0" name="capacity" class="form-control" id="capacity" placeholder="Amount of persons the hall can hold" value="" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="theme">Theme</label>
                            <input type="text" name="theme" class="form-control" id="location" placeholder="e.g Maasai, Blue, Bright, Dark, etc" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="size">Size </label>
                            <input type="text" name="size" class="form-control" id="size" placeholder="e.g Large, Medium, Small, Extra Large" value="" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="info">Additional Information</label>
                            <textarea name="info" id="info" cols="30" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <hr class="mb-4">
                    {{ csrf_field() }}
                    <button class="btn btn-success btn-lg" type="submit">Add hall</button>
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
    <script src="{{ asset('js/jquery-3.3.1.slim.min.js') }}"></script>
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/assets/js/vendor/popper.min.js') }}"></script>
@endsection