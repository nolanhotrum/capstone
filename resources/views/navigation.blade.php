<body>
<header class="header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="longName">Dog's Way</a>
    <a href="{{url('/')}}" class="shortName">DW</a>
    <!-- Hamburger icon -->
    <input class="side-menu" type="checkbox" id="side-menu"/>
    <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
    <!-- Menu -->
    <nav class="nav">
        <ul class="menu">
            <li><a href="{{url('/trails')}}">Trails</a></li>
            <li><a href="{{url('/parks')}}">Parks</a></li>
            @if (auth()->check())
            <li><a href="{{url('/recommendation')}}">Recommendation</a></li>
            <li><a href="{{url('/feedback')}}">Feedback</a></li>
            <li><a href="{{url('/logout')}}" >Logout</a></li>
            @else
            <li><a href="{{url('/login')}}">Login</a></li>
            <li><a href="{{url('/register')}}">Register</a></li>
            @endif
        </ul>
    </nav>
</header>