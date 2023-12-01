<body>
    <header class="header">
        <div class="header-content">
            <!-- Logo Container -->
            <div class="logo-container">
                <a href="{{ url('/') }}" class="logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Dog's Way Logo">
                </a>
            </div>

            <!-- Title Container -->
            <div class="title-container">
                <a href="{{ url('/') }}" class="longName">Dog's Way</a>
                <a href="{{ url('/') }}" class="shortName">DW</a>
            </div>

            <!-- Navigation Container -->
            <div class="nav-container">
                <input class="side-menu" type="checkbox" id="side-menu" style="display:none;" />
                <label class="hamburger" for="side-menu">
                    <div class="hamburger-line"></div>
                </label>
                <nav class="nav">
                    <ul class="menu">
                        <li><a href="{{ url('/trails') }}">Trails</a></li>
                        <li><a href="{{ url('/parks') }}">Parks</a></li>
                        @if (auth()->check())
                        @if (auth()->user()->role === 1)
                        <li><a href="{{ url('/admin') }}">Admin</a></li>
                        @endif
                        <li><a href="{{ url('/recommendation') }}">Recommendation</a></li>
                        <li><a href="{{ url('/logout') }}">Logout</a></li>
                        @else
                        <li><a href="{{ url('/login') }}">Login</a></li>
                        <li><a href="{{ url('/register') }}">Register</a></li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>
    </header>