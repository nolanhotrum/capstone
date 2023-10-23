@extends("layout")

@section('content')
<h1>{{ $location->park_name }} ({{ $type }})</h1>

<p><strong>Address:</strong> {{ $location->address }}</p>
<p><strong>Type:</strong> {{ $type }}</p>
<p><strong>Community:</strong> {{ $location->community }}</p>
<p>{{ $location->add_info }}</p>
@endsection