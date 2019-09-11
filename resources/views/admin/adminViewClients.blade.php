@extends('theLayouts.mainLayout')

@section('head')
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Admin | View Clients</title>
    <link href="{{ asset('bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/navbar-top-fixed.css') }}" rel="stylesheet">
@endsection

@section('body')
    @include('admin.includes.navbar')
    <div class="container">
        <div class="py-5 text-center">

            <h2>Clients</h2>
        </div>
        <table class="table table-hover table-striped table-bordered table-responsive-lg">
            <thead class="thead-dark">
            <tr>

                <th scope="col">Name</th>
                <th scope="col">Phone</th>
                <th scope="col">Status</th>
                <th scope="col">Signed Up</th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($clients as $client)
                <tr>

                    <th>{{ $client->name }}</th>
                    <th>{{ $client->phone }}</th>
                    <th>{{ $client->status }}</th>
                    <th>{{ \Carbon\Carbon::parse($client->created_at)->diffForHumans() }}</th>
                    <th>
                        <a href="{{ route('resetClientPassword', ['client' => $client->id]) }}" class="btn btn-primary">Reset Password</a>
                    </th>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $clients->links() }}
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