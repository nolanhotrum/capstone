@extends("layout")

@section("content")

<div class="main-content">
    <h1>Trails Page</h1>

    <select id="filter" onchange="location = this.value;">
        <option value="/trails?type_id={{ $typeId }}" {{ $filter === null ? 'selected' : '' }}>All Trails</option>
        <option value="/trails?filter=average_rating&type_id={{ $typeId }}" {{ $filter === 'average_rating' ? 'selected' : '' }}>Best Rated Trails</option>
        <option value="/trails?filter=most_comments&type_id={{ $typeId }}" {{ $filter === 'most_comments' ? 'selected' : '' }}>Most Commented Trails</option>
    </select>

    <ul>
        @foreach ($trails as $location)
        <li>
            {{ $location->park_name }}
            @if ($filter === 'average_rating')
            Average Rating: {{ number_format($location->ratings->avg('rating_value'), 2) }}
            @elseif ($filter === 'most_comments')
            Number of Comments: {{ $location->comments_count }}
            @endif
        </li>
        @endforeach
    </ul>
</div>

@endsection