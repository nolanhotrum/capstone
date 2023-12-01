@extends("layout")

@section('content')
@if ($location)
<h1>{{ $location->park_name }} ({{ $type }})</h1>
<!-- Display Google Map -->
<div id="map" style="width: 100%; height: 700px;"></div>

<script>
    let map;
    let directionsService;
    let directionsRenderer;

    function initMap() {
        // Initialize map
        map = new google.maps.Map(document.getElementById("map"), {
            center: {
                lat: parseFloat('{{ $location->latitude }}'),
                lng: parseFloat('{{ $location->longitude }}'),
            },
            zoom: 12, // Adjust the zoom level to ensure directions are visible
            styles: [{
                featureType: "poi",
                elementType: "labels",
                stylers: [{
                    visibility: "off",
                }],
            }],
        });

        // Initialize directions service and renderer
        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            map: map,
        });

        // Get user's current location (if available)
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                (position) => {
                    const userLocation = new google.maps.LatLng(
                        position.coords.latitude,
                        position.coords.longitude
                    );

                    // Display directions from user's location to the location
                    displayDirections(userLocation);
                },
                (error) => {
                    console.error("Error getting user location:", error);
                }
            );
        }
    }

    function displayDirections(userLocation) {
        const destination = new google.maps.LatLng(
            parseFloat('{{ $location->latitude }}'),
            parseFloat('{{ $location->longitude }}')
        );

        // Request directions from user's location to the destination
        directionsService.route({
                origin: userLocation,
                destination: destination,
                travelMode: google.maps.TravelMode.DRIVING,
            },
            (response, status) => {
                if (status === "OK") {
                    // Display the directions on the map
                    directionsRenderer.setDirections(response);
                } else {
                    console.error("Directions request failed:", status);
                }
            });
    }

    document.addEventListener('DOMContentLoaded', function() {
        let stars = document.querySelectorAll('.rating i');

        stars.forEach(function(star) {
            star.addEventListener('click', function() {
                let rating = this.dataset.rating;
                stars.forEach(function(s) {
                    s.classList.remove('active');
                    if (s.dataset.rating <= rating) {
                        s.classList.add('active');
                    }
                });

                // Update the hidden input value
                document.querySelector('.rating input[name="rating"]').value = rating;
            });
        });
    });
</script>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD-7uGxcXtxOHLNCj867iBF6CfAP0IDeFw&callback=initMap"></script>
<div class="content-container">
    <div class="ratings" style="flex: 1; margin-right: 20px;">
        <h2>Rating: {{ $location->rating }} ({{ $location->ratings->count() }} ratings)</h2>

        @auth
        @php
        $userRating = $location->ratings()->where('user_id', auth()->user()->id)->first();
        @endphp

        @if ($userRating)
        <h3>Your Rating: {{ $userRating->rating_value }}/5 stars</h3>
        <form action="{{ route('locations.rate.replace', ['id' => $location->id, 'ratingId' => $userRating->id]) }}" method="POST">
            @csrf
            <div class="rating">
                @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star{{ $i <= $userRating->rating_value ? ' active' : '' }}" data-rating="{{ $i }}"></i>
                    @endfor
                    <input type="hidden" name="rating" value="{{ $userRating->rating_value }}" />
            </div>
            <button type="submit">Replace Rating</button>
        </form>
        @else
        <h3>Rate This Park</h3>
        <form action="{{ route('locations.rate.submit', ['id' => $location->id]) }}" method="POST">
            @csrf
            <div class="rating">
                @for ($i = 1; $i <= 5; $i++) <i class="fas fa-star" data-rating="{{ $i }}"></i>
                    @endfor
                    <input type="hidden" name="rating" value="1" />
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
    </div>

    <div class="comments" style="flex: 1;">

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
        <h2>Comments:</h2>

        @if ($location->comments->isNotEmpty())
        @foreach($location->comments as $comment)
        <div class="comment">
            <p class="comment-body">{{ $comment->body }}</p>
            <p class="timestamp">
                Posted {{ $comment->created_at->diffForHumans() }}
                <span class="username">, by {{ $comment->user->name ?? 'Unknown User' }}</span>
            </p>
        </div>
        @endforeach
        @else
        <p>No comments available for this location.</p>
        @endif

        @guest
        <!-- Content for non-logged-in users -->
        <p>Please log in to leave a comment or rate this park.</p>
        <a href="{{ route('login') }}">Log In</a>
        @endguest
    </div>
</div>

<br><br>
<br><br>

@else
<p>Location not found.</p>
@endif
@endsection