<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Confy Conference</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto"></ul>
        <div class="form-inline mt-2 mt-md-0">
            <ul class="navbar-nav mr-auto">
                @if(\Illuminate\Support\Facades\Auth::check() == true)
                    <li class="nav-item active">
                        <h6>
                            <a class="nav-link" style="color: #ff4500;font-weight: bolder" href="{{ route('clientViewPayments') }}">Bal - {{ \App\Http\Controllers\FuncController::getCLientBalance(\Illuminate\Support\Facades\Auth::user()->getAuthIdentifier()) }} Ksh</a>
                        </h6>
                    </li>
                @endif
                <li class="nav-item active">
                    <a class="nav-link" href="{{ route('clientHome') }}">Home</a>
                </li>
                @if(\Illuminate\Support\Facades\Auth::check())
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('clientViewBookings') }}">Bookings</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('clientTopUpBalance') }}">Top up</a>
                    </li>
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('clientUpdatePassword') }}">Change Password</a>
                    </li>

                @endif
                @if(\Illuminate\Support\Facades\Auth::check() == false)
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('homeLogin') }}">Login</a>
                    </li>
                @else
                    <li class="nav-item active">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                @endif


            </ul>
        </div>
    </div>
</nav>