@extends('layout')

@section('content')
<h1 id="admin-park-requests">Admin Park Requests</h1>

<div class="main-content">
    @if($parkRequests->isEmpty())
    <p id="no-requests-message">No park requests available.</p>
    @else
    <table class="table admin-table">
        <thead>
            <tr>
                <th>User</th>
                <th>Park Name</th>
                <th>Type</th>
                <th>Address</th>
                <th>Additional Info</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($parkRequests as $parkRequest)
            <tr>
                <td>{{ $parkRequest->user->name }}</td>
                <td>{{ $parkRequest->park_name }}</td>
                <td>{{ $parkRequest->type }}</td>
                <td>{{ $parkRequest->address }}</td>
                <td>{{ $parkRequest->add_info }}</td>
                <td>{{ $parkRequest->status }}</td>
                <td class="admin-actions">
                    @if($parkRequest->status === 'pending')
                    <a href="{{ route('admin.recommendation.approveDeny', ['id' => $parkRequest->id, 'action' => 'approve']) }}" class="admin-approve">Approve</a>
                    <a href="{{ route('admin.recommendation.approveDeny', ['id' => $parkRequest->id, 'action' => 'deny']) }}" class="admin-deny">Deny</a>
                    @else
                    {{ $parkRequest->status }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endif
@endsection