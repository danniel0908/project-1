
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
                    <h1>Ticket #{{ $ticket->id }} - {{ $ticket->subject }}</h1>
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

                        <div class="card-body">
                            <div class="ticket-details">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>User:</strong> {{ $ticket->user->full_name }}<br>
                                        <strong>Email:</strong> {{ $ticket->user->email }}<br>
                                        <strong>Phone number:</strong> 0{{ $ticket->user->phone_number }}<br>
                                        <strong>Status:</strong> 
                                        <span class="badge 
                                            @switch($ticket->status)
                                                @case('open') badge-primary @break
                                                @case('in_progress') badge-warning @break
                                                @case('resolved') badge-success @break
                                                @case('closed') badge-secondary @break
                                            @endswitch
                                        ">
                                            {{ ucfirst($ticket->status) }}
                                        </span><br>
                                    </div>
                                    <div class="col-md-6">
                                        <strong>Priority:</strong> {{ ucfirst($ticket->priority) }}<br>
                                        <strong>Created:</strong> {{ $ticket->created_at->diffForHumans() }}<br>
                                        <strong>Last Updated:</strong> {{ $ticket->updated_at->diffForHumans() }}
                                    </div>
                                </div>
                                <hr>
                                <div class="ticket-description">
                                    <h4>Initial Description</h4>
                                    <p>{{ $ticket->description }}</p>
                                </div>
                            </div>
                                @if($attachments && $attachments->count() > 0)
                                    <div class="ticket-attachments mt-4">
                                        <h4>Attachments</h4>
                                            <div class="row">
                                                @foreach($attachments as $attachment)
                                                    <div class="col-md-4 mb-3">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                <div class="d-flex align-items-center">
                                                                    @if(in_array($attachment->mime_type, ['image/jpeg', 'image/png', 'image/gif']))
                                                                        <img src="https://drive.google.com/thumbnail?id={{ $attachment->path }}&sz=w150" 
                                                                            class="img-thumbnail mb-2" 
                                                                            style="max-height: 150px; width: auto;"
                                                                            alt="{{ $attachment->filename }}">
                                                                    @else
                                                                        <i class="fas fa-file-pdf fa-3x text-danger"></i>
                                                                    @endif
                                                                </div>
                                                            <div>
                                                            <p class="mb-1">{{ $attachment->filename }}</p>
                                                            <small class="text-muted">
                                                                {{ number_format($attachment->file_size / 1024, 2) }} KB
                                                            </small>
                                                            <div class="mt-2">
                                                            <a href="{{ $attachment->drive_link }}" 
                                                            class="btn btn-sm btn-primary"
                                                            target="_blank">
                                                                View
                                                            </a>
                                                             
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                @endif
                            <h3>Conversation</h3>
                            <div class="message-thread">
                                @foreach($messages as $message)
                                    <div class="message 
                                        {{ $message->is_admin_message ? 'admin-message bg-light' : 'user-message' }} 
                                        card mb-3
                                    ">
                                        <div class="card-body">
                                            <p>{{ $message->message }}</p>
                                            <small class="text-muted">
                                                {{ $message->user->full_name }} - 
                                                {{ $message->created_at->diffForHumans() }}
                                                @if($message->is_admin_message)
                                                    <span class="badge badge-info">Admin</span>
                                                @endif
                                            </small>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <form action="{{ route('admin.tickets.reply', $ticket) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="message">Admin Reply</label>
                                    <textarea name="message" id="message" class="form-control" rows="4" required></textarea>
                                </div>
                                <div class="form-group">
                                    <label for="status">Update Ticket Status</label>
                                    <select name="status" id="status" class="form-control">
                                        <option value="open" {{ $ticket->status == 'open' ? 'selected' : '' }}>Open</option>
                                        <option value="in_progress" {{ $ticket->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                                        <option value="resolved" {{ $ticket->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                                        <option value="closed" {{ $ticket->status == 'closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Reply</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
    </section>
</div>

@endsection
