@extends("layout")

@section("content")

<div class="main-content" id="recommendation-content">
    <h1>Recommendation Page</h1>

    @if(session('success'))
    <div id="recommendation-success" class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div id="recommendation-error" class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <form method="post" action="{{ route('recommendation.store') }}" id="recommendation-form">
        @csrf

        <label for="park_name" id="recommendation-label">Park Name</label>
        <input type="text" name="park_name" id="recommendation-input" required>

        <label for="type" id="recommendation-label">Park Type</label>
        <select name="type" id="recommendation-select" required>
            <option value="Park">Park</option>
            <option value="Trail">Trail</option>
        </select>

        <label for="address" id="recommendation-label">Address</label>
        <input type="text" name="address" id="recommendation-input" required>

        <label for="add_info" id="recommendation-label">Additional Info</label>
        <textarea name="add_info" id="recommendation-textarea"></textarea>

        <button type="submit" id="recommendation-submit">Submit Recommendation</button>
    </form>

</div>

@endsection