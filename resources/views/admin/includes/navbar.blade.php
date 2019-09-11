<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Confy Conference</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto"></ul>
        <div class="form-inline mt-2 mt-md-0">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('adminHome') }}">Home</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('adminAddCredits') }}">MPESA</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('adminViewBookings') }}">Bookings</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('adminViewPayments') }}">Payments</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('adminViewClients') }}">Clients</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('adminViewhalls') }}">halls</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>