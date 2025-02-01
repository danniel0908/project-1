
    @extends('users.layout')


    <style>
        .attachment-upload {
        margin-bottom: 1rem;
    }

    .attachment-label {
        display: inline-block;
        padding: 0.5rem 1rem;
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        cursor: pointer;
        transition: background-color 0.15s ease;
    }

    .attachment-label:hover {
        background-color: #e5e7eb;
    }

    .attachment-input {
        display: none;
    }

    .file-list {
        margin-top: 0.5rem;
        font-size: 0.875rem;
    }

    .file-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.25rem 0;
    }

    .file-remove {
        color: #ef4444;
        cursor: pointer;
    }
        .closed-ticket-message {
            background-color: #f3f4f6;
            padding: 1rem;
            border-radius: 6px;
            text-align: center;
            color: #6b7280;
            margin-top: 2rem;
            border: 1px solid #e5e7eb;
        }
        .ticket-container {
            padding: 1.5rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .ticket-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid #e5e7eb;
        }

        .ticket-title {
            font-size: 1.5rem;
            color: #111827;
            font-weight: 600;
        }

        .ticket-metadata {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            padding: 1rem;
            background: #f9fafb;
            border-radius: 6px;
            margin-bottom: 2rem;
        }

        .metadata-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .metadata-label {
            color: #6b7280;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .metadata-value {
            color: #111827;
            font-weight: 500;
        }

        .status-badge {
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.875rem;
            font-weight: 500;
        }

        .status-open {
            background-color: #dbeafe;
            color: #1e40af;
        }

        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .status-resolved {
            background-color: #d1fae5;
            color: #065f46;
        }

        .priority-high {
            background-color: #fee2e2;
            color: #991b1b;
        }

        .priority-medium {
            background-color: #fef3c7;
            color: #92400e;
        }

        .priority-low {
            background-color: #d1fae5;
            color: #065f46;
        }

        .messages-container {
            margin-top: 2rem;
        }

        .messages-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
        }

        .messages-title {
            font-size: 1.25rem;
            color: #111827;
            font-weight: 600;
        }

        .message {
            margin-bottom: 1.5rem;
            padding: 1rem;
            border-radius: 8px;
            position: relative;
        }

        .user-message {
            background-color: #f3f4f6;
            margin-right: 2rem;
        }

        .admin-message {
            background-color: #dbeafe;
            margin-left: 2rem;
        }

        .message-content {
            color: #374151;
            line-height: 1.5;
            margin-bottom: 0.5rem;
        }

        .message-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.875rem;
            color: #6b7280;
        }

        .message-author {
            font-weight: 500;
        }

        .message-time {
            font-size: 0.75rem;
        }

        .reply-form {
            margin-top: 2rem;
            background: #f9fafb;
            padding: 1.5rem;
            border-radius: 8px;
        }

        .reply-textarea {
            width: 100%;
            min-height: 120px;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 6px;
            margin-bottom: 1rem;
            font-size: 0.875rem;
            resize: vertical;
            transition: border-color 0.15s ease;
        }

        .reply-textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .submit-button {
            background-color: #2563eb;
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 6px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            transition: background-color 0.15s ease;
        }

        .submit-button:hover {
            background-color: #1d4ed8;
        }

        @media (max-width: 768px) {
            .ticket-metadata {
                grid-template-columns: 1fr;
            }
            
            .message {
                margin-left: 0;
                margin-right: 0;
            }
            
            .ticket-container {
                padding: 1rem;
            }
        }
    </style>

    @section('content')
    @section('content')
    <div class="dashboard-body" id="dashboardBody">
        <div class="dashboard-container">
            <section class="content">
                <div class="ticket-container">
                    <div class="ticket-header">
                        <h1 class="ticket-title">Ticket: {{ $ticket->subject }}</h1>
                    </div>

                    <div class="ticket-metadata">
                        <div class="metadata-item">
                            <span class="metadata-label">Status:</span>
                            <span class="status-badge status-{{ strtolower($ticket->status) }}">
                                {{ ucfirst($ticket->status) }}
                            </span>
                        </div>
                        <div class="metadata-item">
                            <span class="metadata-label">Priority:</span>
                            <span class="status-badge priority-{{ strtolower($ticket->priority) }}">
                                {{ ucfirst($ticket->priority) }}
                            </span>
                        </div>
                        <div class="metadata-item">
                            <span class="metadata-label">Description:</span>
                            <span class="metadata-value">{{ $ticket->description }}</span>
                        </div>
                    </div>
                                    

                    <div class="messages-container">
                        <div class="messages-header">
                            <h2 class="messages-title">Messages</h2>
                        </div>
                        
                        @foreach($messages as $message)
                            <div class="message {{ $message->is_admin_message ? 'admin-message' : 'user-message' }}">
                                <div class="message-content">
                                    {{ $message->message }}
                                </div>
                                <div class="message-footer">
                                    <span class="message-author">{{ $message->user->full_name }}</span>
                                    <span class="message-time">{{ $message->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if(strtolower($ticket->status) !== 'closed')
                    <form action="{{ route('tickets.reply', $ticket) }}" method="POST" class="reply-form" enctype="multipart/form-data">
                        @csrf
                        <textarea 
                            name="message" 
                            class="reply-textarea" 
                            placeholder="Type your reply here..."
                            required></textarea>
                        
                        <div class="attachment-upload">
                            <label for="attachments" class="attachment-label">
                                <i class="fas fa-paperclip"></i> Add Attachments
                            </label>
                            <input 
                                type="file" 
                                name="attachments[]" 
                                id="attachments" 
                                class="attachment-input" 
                                multiple
                                accept=".jpg,.jpeg,.png,.pdf">
                            <div id="file-list" class="file-list"></div>
                        </div>
                        
                        <button type="submit" class="submit-button">Send Message</button>
                    </form>
                @else
                    <div class="closed-ticket-message">
                        This ticket is closed and no longer accepts replies.
                    </div>
                @endif
                </div>
            </section>
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
            @include('users.footer')
        </div>
    </div>
    @endsection









