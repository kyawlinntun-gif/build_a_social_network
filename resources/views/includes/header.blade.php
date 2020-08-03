<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}">Home</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item {{ Request::is('account*') ? 'active' : '' }}">
                    <a class="nav-link" href="{{ route('account.index') }}">Account</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ Auth::user() ? Auth::user()->name : 'Login User' }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @auth
                            <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout').submit();">Logout</a>
                            {{ Form::open(['route' => 'logout', 'method' => 'post', 'id' => 'logout']) }}
                            {{ Form::close() }}
                        @else
                            <a class="dropdown-item" href="{{ route('dashboard') }}">Login</a>
                            <a class="dropdown-item" href="{{ route('dashboard') }}">Register</a>
                        @endauth
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>