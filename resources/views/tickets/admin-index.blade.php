@extends('layouts.app')

@section('content')
<div class="container">
    <h1>All Support Tickets</h1>

    @if($tickets->isEmpty())
        <div class="alert alert-info">
            No support tickets found.
        </div>
    @else
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tickets as $ticket)
                    <tr>
                        <td>{{ $ticket->id }}</td>
                        <td>{{ $ticket->user->name }}</td>
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
                            <a href="{{ route('admin.tickets.show', $ticket) }}" 
                               class="btn btn-sm btn-primary">
                                Manage
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $tickets->links() }}
    @endif
</div>
@endsection