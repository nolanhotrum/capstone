@extends("layout")

@section("content")
    <p>Register page.</p>
    <form method="POST" action="/attempt_register">
        @csrf
        <label for="name">Name: </label>
        <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />
        <br /> <br />
        <label for="email">Email: </label>
        <input id="email" type="email" name="email" value="{{ old('email') }}" required />
        <br /> <br />
        <label for="password">Password: </label>
        <input id="password" type="password" name="password" required />
        <br /> <br />
        <label for="password-confirm">Confirm Password: </label>
        <input id="password-confirm" type="password" name="password-confirm" required />
        <br /> <br />
        <input type="submit" value="Register" />

    </form>
@endsection