@extends('layouts.app')

@section('title')
Customer Service
@endsection

@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Tickets</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Ticket Tables</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        

                    

<div class="container">

    <table class="table table-hover">
        <thead>
            <tr>
                <th>Ticket ID</th>
                <th>User</th>
                <th>Subject</th>
                <th>Status</th>
                <th>Priority</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tickets as $ticket)
            <tr>
                <td>{{ $ticket->id }}</td>
                <td>{{ $ticket->user->full_name }}</td>
                <td>{{ $ticket->subject }}</td>
                <td>
                    <span class="badge 
                        @switch($ticket->status)
                            @case('open') badge-primary @break
                            @case('in_progress') badge-warning @break
                            @case('resolved') badge-success @break
                            @case('closed') badge-secondary @break
                        @endswitch
                    ">
                        {{ ucfirst($ticket->status) }}
                    </span>
                </td>
                <td>{{ ucfirst($ticket->priority) }}</td>
                <td>{{ $ticket->created_at->diffForHumans() }}</td>
                <td>
                    <a href="{{ route('admin.tickets.show', $ticket) }}" class="btn btn-sm btn-info">
                        View Details
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $tickets->links() }}
</div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>

@endsection
