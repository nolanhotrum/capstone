@extends("layout")

@section("content")

<div class="main-content">
    <h1>List of Parks</h1>

    <select id="filter" onchange="location = this.value;">
        <option value="/parks?type_id={{ $typeId }}" {{ $filter === null ? 'selected' : '' }}>All Parks</option>
        <option value="/parks?filter=average_rating&type_id={{ $typeId }}" {{ $filter === 'average_rating' ? 'selected' : '' }}>Best Rated Parks</option>
        <option value="/parks?filter=most_comments&type_id={{ $typeId }}" {{ $filter === 'most_comments' ? 'selected' : '' }}>Most Commented Parks</option>
    </select>

    <ul>
        @foreach ($parks as $location)
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