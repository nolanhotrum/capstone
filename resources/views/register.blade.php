@extends("layout")

@section("content")
<h1 class="login-page-title">Register Page</h1>
<form method="POST" action="/attempt_register" class="login-container">
    @csrf
    <label for="name">Name: </label>
    <input id="name" type="text" name="name" value="{{ old('name') }}" class="login-input" required />
    @error('name')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <label for="email">Email: </label>
    <input id="email" type="email" name="email" value="{{ old('email') }}" class="login-input" required />
    @error('email')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <label for="password">Password: </label>
    <input id="password" type="password" name="password" class="login-input" required />
    @error('password')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <label for="password_confirmation">Confirm Password: </label>
    <input id="password_confirmation" type="password" name="password_confirmation" class="login-input" required />
    @error('password_confirmation')
    <p>{{ $message }}</p>
    @enderror
    <br /> <br />

    <input type="submit" value="Register" class="login-submit" />
</form>
@endsection