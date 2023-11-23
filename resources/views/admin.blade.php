@extends('layout')

@section('content')
<h1>Admin Park Requests</h1>

@if($parkRequests->isEmpty())
<p>No park requests available.</p>
@else
<table class="table">
    <thead>
        <tr>
            <th>ID</th>
            <th>User</th>
            <th>Park Name</th>
            <th>Address</th>
            <th>Additional Info</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach($parkRequests as $parkRequest)
        <tr>
            <td>{{ $parkRequest->id }}</td>
            <td>{{ $parkRequest->user->name }}</td>
            <td>{{ $parkRequest->park_name }}</td>
            <td>{{ $parkRequest->address }}</td>
            <td>{{ $parkRequest->add_info }}</td>
            <td>{{ $parkRequest->status }}</td>
            <td>
                @if($parkRequest->status === 'pending')
                <a href="{{ route('admin.recommendation.approveDeny', ['id' => $parkRequest->id, 'action' => 'approve']) }}">Approve</a>
                |
                <a href="{{ route('admin.recommendation.approveDeny', ['id' => $parkRequest->id, 'action' => 'deny']) }}">Deny</a>
                @else
                {{ $parkRequest->status }}
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection