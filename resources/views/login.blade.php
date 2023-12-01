@extends("layout")

@section("content")

<h1 class="login-page-title">Login Page</h1>
<form method="POST" action="/attempt_login" class="login-container">
    @csrf
    <label for="email">Email: </label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" class="login-input" required />
    <br /> <br />
    <label for="password">Password: </label>
    <input id="password" type="password" name="password" class="login-input" required />
    <br /> <br />
    <a href="{{route('reset_password')}}" class="login-link">Forgot your password?</a>
    <input type="submit" value="Login" class="login-submit" />

</form>

@endsection