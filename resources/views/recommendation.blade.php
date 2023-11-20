@extends("layout")

@section("content")

<div class="main-content">
    <h1>Recommendation Page</h1>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="post" action="{{ route('recommendation.store') }}">
        @csrf

        <label for="park_name">Park Name</label>
        <input type="text" name="park_name" required>

        <label for="type">Park Type</label>
        <select name="type" required>
            <option value="Park">Park</option>
            <option value="Trail">Trail</option>
        </select>

        <label for="address">Address</label>
        <input type="text" name="address" required>

        <label for="add_info">Additional Info</label>
        <textarea name="add_info"></textarea>

        <button type="submit">Submit Recommendation</button>
    </form>

</div>

@endsection