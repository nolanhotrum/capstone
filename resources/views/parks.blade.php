@extends("layout")

@section("content")
<h1>List of Parks</h1>

<select id="filter" onchange="location = this.value;">
    <option value="/parks?type_id={{ $typeId }}" {{ $filter === null ? 'selected' : '' }}>All Parks</option>
    <option value="/parks?filter=average_rating&type_id={{ $typeId }}" {{ $filter === 'average_rating' ? 'selected' : '' }}>Best Rated Parks</option>
    <option value="/parks?filter=most_comments&type_id={{ $typeId }}" {{ $filter === 'most_comments' ? 'selected' : '' }}>Most Commented Parks</option>
</select>

<div class="main-content">
    @foreach ($parks as $location)
    <div class="park-box">
        <div class="park-details">
            <a href="{{ url('/locations') }}/{{ $location->id }}" class="park-name">{{ $location->park_name }}</a>
            <p class="park-info">
                @if ($filter === 'average_rating')
                Average Rating: {{ number_format($location->ratings->avg('rating_value'), 2) }}
                @elseif ($filter === 'most_comments')
                Number of Comments: {{ $location->comments_count }}
                @endif
                <!-- Additional details -->
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

<br /><br />
<br /><br />


@endsection