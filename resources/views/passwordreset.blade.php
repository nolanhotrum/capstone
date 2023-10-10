@extends("layout")

@section("content")

<div class="main-content">
    <h1>Password Reset</h1>
    <form method="POST" class="my-login-validation" novalidate="" action="{{ route('password.email') }}">
        @csrf

        @if (session('status'))
            <div class="alert alert-ssuccess">
                {{ session('status') }}
            </div>
        @endif
			<div class="form-group">
				<label for="email">E-Mail Address</label>
				<input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter your email">
                <span class="text-danger">@error('email'){{ $message }} @enderror</span>
			</div>

			<div class="form-group m-0">
				<button type="submit" class="btn btn-primary btn-block">
					Send Password Link
				</button>
			</div>
	</form>
</div>

@endsection