@extends('layouts.app')

@section('title')
PODa Dropping Edit
@endsection
@section('content')

<style>
    body {
        font-family: "Source Sans Pro", "apple-system", BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background-color: #f9f9f9;
        margin: 0;
        padding: 20px;
    }
    .container {
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        padding: 20px;
        border-radius: 5px;
    }
    h1 {
        color: #004d00;
        border-bottom: 1px solid #ccc;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 20px;
    }
    thead th {
        background-color: #004d00;
        color: #fff;
        padding: 12px;
        text-align: left;
    }
    tbody td {
        padding: 12px;
        border: 1px solid #ddd;
    }
    .button-style {
        display: inline-block;
        padding: 8px 12px;
        background-color: #004d00;
        color: #fff;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .button-style:hover {
        background-color: #006600;
    }

    .file-input-label {
        display: inline-block;
        padding: 8px 12px;
        background-color: #004d00;
        color: #fff;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }
    .file-input-label:hover {
        background-color: #006600;
    }
    .submit-button {
        display: block;
        width: 100%;
        padding: 10px;
        background-color: #004d00;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        transition: background-color 0.3s;
    }
    .submit-button:hover {
        background-color: #006600;
    }
    input[type="checkbox"] {
      accent-color: #006600; /* Changes the color of the checkbox */
    }
</style>

<div class="content-wrapper">
@include('partials.alerts')

        <!-- Content Header (Page header) -->
        <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item active">Applicant Tables</li>
                </ol>
            </div>
            </div>

        </div><!-- /.container-fluid -->
        </section>
        <!-- Main content -->
        <div class="main-content">
                <div id="personal-info" class="form-section">
                    <h1 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Requirements</h1>
                    <!-- Main Form -->
                    <form action="{{ route('podadrop-requirements.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="poda_dropping_id" value="{{ $PODAdropping->id }}">
                        <table class="table table-bordered" style="width: 100%; margin-top: 20px;">
                            <thead>
                                <tr>
                                    <th>Requirement</th>
                                    <th>Attachment</th>
                                    <th>Action</th>
                                    <th>Remarks</th>
                                    <th>Approval Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach([
                                        'Application_form' => 'Duly-accomplished Application form (1 Original Set)',
                                        'Current_franchise' => 'Current franchise (1 Photocopy)',
                                        'Official_Receipt' => 'Official Receipt (1 Original Copy and 1 Photocopy)'
                                    ] as $type => $label)
                                <tr>
                                    <td>{{ $label }}</td>
                                    <td style="text-align: center">
                                        @php
                                            $filesForType = $files->filter(fn($file) => $file->requirement_type === $type);
                                        @endphp
                                        @if($filesForType->isEmpty())
                                            <p>No files uploaded for this requirement.</p>
                                        @else
                                            @foreach($filesForType as $file)
                                            <button onclick="window.location.href='{{ $file->drive_link }}'" class="button-style">View attachment</button> 
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>
                                        <button type="button" class="button-style" data-bs-toggle="modal" data-bs-target="#uploadModal" 
                                                data-requirement="{{ $type }}" data-label="{{ $label }}">
                                                @if($filesForType->isEmpty())
                                                    Upload
                                                @else
                                                    Reupload
                                                @endif
                                        </button>
                                    </td>
                                    <td style="text-align: center">
                                        <input type="text" class="form-control" name="remarks[{{ $type }}]" value="{{ $filesForType->first()->remarks ?? '' }}" placeholder="Add remarks">
                                    </td>
                                    <td style="text-align: center">
                                        @foreach($filesForType as $file)
                                            <select name="status[{{ $file->id }}]" class="form-select">
                                                <option value="" {{ $file->status == 'pending' || $file->status == null ? 'selected' : '' }}>Select</option>
                                                <option value="approved" {{ $file->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                                <option value="reject" {{ $file->status == 'reject' ? 'selected' : '' }}>Reject</option>
                                            </select>
                                        @endforeach
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <button type="submit" class="button-style">Save All Changes</button>
                    </form>

                    <!-- File Upload Modal -->
                    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="uploadModalLabel">Upload File</h5>
                                </div>
                                <form id="modalUploadForm" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <input type="file" class="form-control" name="file" required>
                                        <input type="hidden" name="requirement_type" id="requirementType">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">Upload</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const uploadModal = document.getElementById('uploadModal');
    const modalForm = document.getElementById('modalUploadForm');
    const requirementTypeInput = document.getElementById('requirementType');

    uploadModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        const requirementType = button.getAttribute('data-requirement');
        const podaDroppingId = '{{ $PODAdropping->id }}'; // Pass it from the backend

        // Update modal title and hidden input
        const modalTitle = uploadModal.querySelector('.modal-title');
        const label = button.getAttribute('data-label');
        modalTitle.textContent = `Upload ${label}`;
        requirementTypeInput.value = requirementType;

        // Generate the correct action URL
        const actionUrl = `/admin/podadrop-requirements/${podaDroppingId}/upload/${requirementType}`;
        modalForm.action = actionUrl;
    });
});

</script>

    <script>
    function updateRemarks(applicationId) {
    // Get the remarks value from textarea
    const remarksText = document.getElementById(`remarks-${applicationId}`).value;
    
    // Create the request headers
    const headers = {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
    };

    // Show loading state on button
    const button = document.querySelector(`#remarks-${applicationId}`).nextElementSibling.querySelector('button');
    const originalButtonText = button.innerHTML;
    button.innerHTML = 'Saving...';
    button.disabled = true;

    // Make the AJAX request
    fetch(`/update-remarks/poda-drop/${applicationId}`, {
        method: 'POST',
        headers: headers,
        body: JSON.stringify({
            remarks: remarksText
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Show success message
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.message,
                timer: 2000,
                showConfirmButton: false
            });
        } else {
            // Show error message
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message
            });
        }
    })
    .catch(error => {
        // Show error message
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating remarks'
        });
        console.error('Error:', error);
    })
    .finally(() => {
        // Reset button state
        button.innerHTML = originalButtonText;
        button.disabled = false;
    });
}
    </script>
<script>
    function insertPredefinedMessage(messageId, applicationId) {
        if (!messageId) {
            return;
        }

        // Show loading state
        const textarea = document.getElementById(`remarks-${applicationId}`);
        const originalContent = textarea.value;
        textarea.value = 'Loading message...';
        textarea.disabled = true;

        // Get CSRF token
        const token = document.querySelector('meta[name="csrf-token"]').content;

        // Make the API request
        fetch(`/api/predefined-messages/${messageId}`, {
            method: 'GET',
            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token
            },
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data && data.message && data.message.content) {
                // Update textarea with the message content
                textarea.value = data.message.content;
            } else {
                throw new Error('Invalid message format received');
            }
        })
        .catch(error => {
            console.error('Error fetching predefined message:', error);
            // Restore original content if there's an error
            textarea.value = originalContent;
            
            // Show error message to user
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to load the predefined message. Please try again.'
            });
        })
        .finally(() => {
            // Re-enable textarea
            textarea.disabled = false;
        });
    }

    
</script>

@endsection
