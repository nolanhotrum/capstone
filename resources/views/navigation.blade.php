<body>
<header class="header">
    <!-- Logo -->
    <a href="{{url('/')}}" class="logo">Dog's Way</a>
    <!-- Hamburger icon -->
    <input class="side-menu" type="checkbox" id="side-menu"/>
    <label class="hamb" for="side-menu"><span class="hamb-line"></span></label>
    <!-- Menu -->
    <nav class="nav">
        <ul class="menu">
            <li><a href="#">Gallery</a></li>
            <li><a href="#">Blog</a> </li>
            <li><a href="#">About</a></li>
            <li><a href="{{url('/login')}}">Login</a></li>
            <li><a href="{{url('/signup')}}">Signup</a></li>
        </ul>
    </nav>
</header>