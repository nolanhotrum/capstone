@extends("layout")

@section("content")
<p>Register page.</p>
<form method="POST" action="/attempt_register">
    @csrf
    <label for="name">Name: </label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus />
    @error('name')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <label for="email">Email: </label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" required />
    @error('email')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <label for="password">Password: </label>
    <input id="password" type="password" name="password" required />
    @error('password')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <label for="password_confirmation">Confirm Password: </label>
    <input id="password_confirmation" type="password" name="password_confirmation" required />
    @error('password_confirmation')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <input type="submit" value="Register" />
</form>
@endsection