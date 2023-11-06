@extends("layout")

@section('content')
@if ($location)
<h1>{{ $location->park_name }} ({{ $type }})</h1>

<p><strong>Address:</strong> {{ $location->address }}</p>
<p><strong>Type:</strong> {{ $type }}</p>
<p><strong>Community:</strong> {{ $location->community }}</p>
<p>{{ $location->add_info }}</p>

<br><br>

<h2>Rating: {{ $location->rating }} ({{ $location->rating_count }} votes)</h2>

@auth
@php
$userRating = $location->ratings()->where('user_id', auth()->user()->id)->first();
@endphp

@if ($userRating)
<h2>Your Rating: {{ $userRating->rating_value }}/5 stars</h2>
<form action="{{ route('locations.rate.replace', ['id' => $location->id, 'ratingId' => $userRating->id]) }}" method="POST">
    @csrf
    <div class="rating">
        <input type="radio" name="rating" value="5" id="5">
        <label for="5">5</label>
        <input type="radio" name="rating" value="4" id="4">
        <label for="4">4</label>
        <input type="radio" name="rating" value="3" id="3">
        <label for="3">3</label>
        <input type="radio" name="rating" value="2" id="2">
        <label for="2">2</label>
        <input type="radio" name="rating" value="1" id="1">
        <label for="1">1</label>
    </div>
    <button type="submit">Replace Rating</button>
</form>
@else
<form action="{{ route('locations.rate.submit', ['id' => $location->id]) }}" method="POST">
    @csrf
    <div class="rating">
        <input type="radio" name="rating" value="5" id="5">
        <label for="5">5</label>
        <input type="radio" name="rating" value="4" id="4">
        <label for="4">4</label>
        <input type="radio" name="rating" value="3" id="3">
        <label for "3">3</label>
        <input type="radio" name="rating" value="2" id="2">
        <label for="2">2</label>
        <input type="radio" name="rating" value="1" id="1">
        <label for="1">1</label>
    </div>
    <button type="submit">Rate Park</button>
</form>
@endif
@endauth

<div class="ratings">
    <h2>User Ratings:</h2>
    @foreach ($location->ratings as $rating)
    <p>Rating by {{ $rating->user->name }}: {{ $rating->rating_value }}/5 stars</p>
    @endforeach
</div>

<br><br>

@if ($location->comments)
<div class="comments">
    <h2>Comments:</h2>
    @foreach($location->comments as $comment)
    <div class="comment">
        <p>{{ $comment->body }}</p>
        <p class="timestamp">{{ $comment->created_at }}</p>
    </div>
    @endforeach
</div>
@else
<p>No comments available for this location.</p>
@endif

@auth
<div class="add-comment">
    <h2>Add a Comment:</h2>
    <form action="{{ route('locations.comments.store', ['id' => $location->id]) }}" method="POST">
        @csrf
        <textarea name="body" placeholder="Leave a comment" required></textarea>
        <button type="submit">Submit</button>
    </form>
</div>
@endauth

@guest
<!-- Content to display for non-logged-in users -->
<p>Please log in to leave a comment or rate this park.</p>
<a href="{{ route('login') }}">Log In</a>
@endguest

@else
<p>Location not found.</p>
@endif
<br /><br />
@endsection