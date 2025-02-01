

@extends('users.layout')


@section('content')
<div class="dashboard-body" id="dashboardBody">
    <div class="dashboard-container">
     
        <section class="content">
        <div class="container mx-auto px-4 py-8">
        <div class="container">
    <h1>My Tickets</h1>
    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">Create New Ticket</a>

    @if($tickets->isEmpty())
        <div class="alert alert-info">You have no tickets yet.</div>
    @else
        <table class="table">
        <tbody>
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Priority</th>
                    <th>Last Updated</th>
                    <th>Actions</th>
                </tr>
            </thead>
                @foreach($tickets as $ticket)
                <tr>
                   <td data-label="subject"> <strong></strong>{{ $ticket->subject }}</td>
                   <td> <strong>Status: </strong>{{ ucfirst($ticket->status) }}</td>
                   <td> <strong>Priority: </strong>{{ ucfirst($ticket->priority) }}</td>
                    <td> <strong>LastUpdated:  </strong>{{ $ticket->updated_at->diffForHumans() }}</td>
                    <td>
                        <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{ $tickets->links() }}
    @endif
</div>
        </div>
    </div>
</div>

<style>
    /* Hide the <strong>Service:</strong> text by default (for desktop and larger screens) */
.table tbody td strong {
    display: none;
}

/* Show the <strong>Service:</strong> text only on mobile screens (max-width: 768px) */
@media (max-width: 768px) {
    .table tbody td strong {
        display: inline;
    }
}
    </style>
@endsection











