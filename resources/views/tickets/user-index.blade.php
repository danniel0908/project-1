
@extends('users.layout')


@section('content')
<div class="dashboard-body" id="dashboardBody">
    <div class="dashboard-container">
        <header class="header-1">
            <div class="main-dashboard">
                <h1>Profile </h1>
            </div>
            <div class="secondary-dashboard">
                Profile
                <a href="#" >/Dashboard </a>
            </div>
        </header>
        <section class="content">
        <div class="container mx-auto px-4 py-8">
    
        <div class="container">
    <h1>My Support Tickets</h1>
    
    <a href="{{ route('tickets.create') }}" class="btn btn-primary mb-3">
        Create New Ticket
    </a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($tickets->isEmpty())
        <div class="alert alert-info">
            You have no support tickets yet.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->subject }}</td>
                        <td>
                            <span class="badge 
                                @switch($ticket->status)
                                    @case('open') bg-success @break
                                    @case('in_progress') bg-warning @break
                                    @case('resolved') bg-info @break
                                    @case('closed') bg-secondary @break
                                @endswitch
                            ">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </td>
                        <td>{{ $ticket->created_at->diffForHumans() }}</td>
                        <td>
                            <a href="{{ route('tickets.show', $ticket) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
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
@endsection










