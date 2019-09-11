@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
   
    <title>Admin | Add Photos</title>
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
                <form class="needs-validation" action="{{ route('adminPostAddhallPhotos') }}" method="post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-12 mb-3 align-content-center">
                            <label for="name">Select Image </label>
                            <input type="file" name="file" class="form-control" id="name" placeholder="Enter Name to Display to Client" value="" required>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <input type="hidden" name="hallid" value="{{ $hallid }}">
                    <button class="btn btn-success btn-lg" type="submit">Add Photo</button>
                </form>
            </div>
        </div>

        <footer class="my-5 pt-5 text-muted text-center text-small">
            <p class="mb-1">&copy; {{ date("Y") }}</p>
        </footer>
    </div>




@endsection

@section('scripts')
    <script src="{{ asset('bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('bootstrap/assets/js/vendor/popper.min.js') }}"></script>
@endsection