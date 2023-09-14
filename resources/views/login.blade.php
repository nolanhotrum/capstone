@extends("layout")

@section("content")

<h1>Login page</h1>
    <form method="POST" action="/attempt_login">
        @csrf
        <label for="email">Email: </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required />
        <br /> <br />
        <label for="password">Password: </label>
        <input id="password" type="password" name="password" required />
        <br /> <br />
        <input type="submit" value="Login" />

    </form>

@endsection