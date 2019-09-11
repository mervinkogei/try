<!doctype html>
<html lang="en">
<head>
    @yield('head')
    <link rel="stylesheet" href="{{ asset('css/toastr.min.css') }}">
</head>

<body class="text-center">
    @yield('body')
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    @yield('scripts')
    <script src="{{ asset('js/toastr.min.js') }}"></script>
    <script type="text/javascript">
        @if(Session::has('message'))
        toastr.{{ Session::get('status') }}('{{ Session::get('message') }}', '{{ Session::get('title') }}');
        @endif
    </script>
</body>
</html>
