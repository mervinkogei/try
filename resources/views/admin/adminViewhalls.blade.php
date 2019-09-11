@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | View halls</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
    <link href="{{ asset('css/blog.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('admin.includes.navbar')




    <div class="container">
        <div class="py-5 text-center">

            <h2>View halls</h2>
        </div>

        @foreach($halls as $hall)
            <div class="row mb-2">
                <div class="col-md-12">
                    <div class="card flex-md-row mb-4 box-shadow">
                        <div class="card-body d-flex flex-column align-items-start">
                            <strong class="d-inline-block mb-2 text-primary">Ksh {{ $hall->ppn }}</strong>
                            <h3 class="mb-0">
                                <a class="text-dark" href="#">{{ $hall->name }}</a>
                            </h3>
                            <span>
                            <a href="{{ route('adminViewUpdatehall', ['hallid' => $hall->id]) }}" class="btn btn-primary btn-sm">Update</a>
                            <a href="{{ route('adminDeletehall', ['hallid' => $hall->id]) }}" class="btn btn-danger btn-sm">Delete</a>
                        </span>

                            <div class="mb-1 text-muted">Capacity - {{ $hall->capacity }}</div>
                            <div class="mb-1 text-muted">Theme - {{ $hall->theme }}</div>
                            <p class="card-text mb-auto">{{ $hall->info }}</p>
                            <a href="{{ route('adminViewhallAndHistory', ['hallid' => $hall->id]) }}">View Images and History</a>
                        </div>
                        <img class="card-img-right flex-auto d-none d-lg-block" src="{{ asset('storage/images/'.\App\Photo::where('native', 'hall')->where('nativeid', $hall->id)->inRandomOrder()->first()->name) }}" alt="No Images">
                    </div>
                </div>
            </div>
        @endforeach
        {{ $halls->links() }}
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