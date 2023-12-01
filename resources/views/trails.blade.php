@extends("layout")

@section("content")
<h1>List of Trails</h1>

<select id="trails-filter" onchange="location = this.value;">
    <option value="/trails?type_id={{ $typeId }}" {{ $filter === null ? 'selected' : '' }}>All Trails</option>
    <option value="/trails?filter=average_rating&type_id={{ $typeId }}" {{ $filter === 'average_rating' ? 'selected' : '' }}>Best Rated Trails</option>
    <option value="/trails?filter=most_comments&type_id={{ $typeId }}" {{ $filter === 'most_comments' ? 'selected' : '' }}>Most Commented Trails</option>
</select>

<div class="main-content">
    @foreach ($trails as $location)
    <div class="trail-box">
        <div class="trail-details">
            <a href="{{ url('/locations') }}/{{ $location->id }}" class="trail-name">{{ $location->park_name }}</a>
            <p class="trail-info">
                @if ($filter === 'average_rating')
                Average Rating: {{ number_format($location->ratings->avg('rating_value'), 2) }}
                @elseif ($filter === 'most_comments')
                Number of Comments: {{ $location->comments_count }}
                @endif
                <!-- Add more information as needed -->
                <br>
                Address: {{ $location->address ?? 'N/A' }}
                <br>
                Community: {{ $location->community ?? 'N/A' }}
                <br>
                Additional Info: {{ $location->add_info !== '' ? $location->add_info : 'N/A' }}
            </p>
        </div>
    </div>
    @endforeach
</div>

<br><br>
<br><br>

@endsection