@extends('layouts.app')

@section('title')
TODA Application Edit
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
            <div class="container-fluid">

                <div id="personal-info" class="form-section">
                    <div style = "display: flex; justify-content: space-between; color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">
                    <h3 >Applicant's Information</h1>
                        <div style="text-align: end; color: #004d00; rgb(207, 207, 207)"><h3>{{ $TODAapplication->custom_id }}</h1></div>
                    </div>
                    <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px; margin-top: 20px; ">
                        <p>Name: <b> {{ $TODAapplication->Applicants_name }}</b></p>
                        <p>Contact: <b>{{ $TODAapplication->Contact_No_1 }}</b></p>
                        <p>Address: <b>{{ $TODAapplication->Address1 }}</b></p>
                    </div>
                </div>

                <div id="personal-info" class="form-section">
                    <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Driver's Information</h1>
                    <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px;">
                    <p>Name: <b>{{ $TODAapplication->Drivers_name }}</b></p>
                    <p>Contact: <b>{{ $TODAapplication->Contact_No_2 }}</b></p>
                    <p>Address: <b> {{ $TODAapplication->Address_2 }}</b></p>
                    </div>
                </div>

                <div id="personal-info" class="form-section">
                    <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Motor's Description</h1>
                    <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px;">
                        <p>Body no: <b>{{ $TODAapplication->Body_no }}</b></p>
                        <p>Plate no: <b>{{ $TODAapplication->Plate_no }}</b></p>
                        <p>Make: <b>{{ $TODAapplication->Make }}</b></p>
                        <p>Chassis no: <b>{{ $TODAapplication->Chassis_no }}</b></p>
                        <p>Engine no: <b> {{ $TODAapplication->Engine_no }}</b></p>
                    </div>
                </div>
                <div id="remarks-info" class="form-section">
                <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">
                    Admin Remarks
                </h3>
                <div class="card" style="padding: 20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- Add this new select dropdown -->
                                <div class="mb-3">
                                    <select id="predefined-messages-{{ $TODAapplication->id }}" class="form-control" onchange="insertPredefinedMessage(this.value, {{ $TODAapplication->id }})">
                                        <option value="">Select a predefined message...</option>
                                        @foreach($predefinedMessages as $message)
                                            <option value="{{ $message->id }}">{{ $message->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Your existing textarea -->
                                <textarea 
                                    id="remarks-{{ $TODAapplication->id }}" 
                                    class="form-control"
                                    rows="4" 
                                    style="resize: vertical; min-height: 100px;"
                                    placeholder="Add administrative remarks here..."
                                >{{ $TODAapplication->remarks }}</textarea>
                                <div class="d-flex justify-content-end mt-3">
                                    <button 
                                        onclick="updateRemarks({{ $TODAapplication->id }})"
                                        class="button-style"
                                        style="min-width: 120px;"
                                    >
                                        Save Remarks
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div id="personal-info" class="form-section">
                <h1 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Requirements</h1>
                <!-- Main Form -->
                <form action="{{ route('toda-requirements.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="toda_application_id" value="{{ $TODAapplication->id }}">
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
                                    'Inspection_clearance' => 'Inspection Clearance and/or Certificate of Noise Emission Compliance (1 Original Copy)',
                                    'license' => "Professional driver's license (1 Photocopy)",
                                    'COR' => "Latest Certificate of Registration and Official Receipt of the vehicle (1 Photocopy)",
                                    'Deed_of_Sale' => 'Deed of Sale or Deed of Conveyance/Transfer (1 Photocopy)',
                                    'Insurance' => 'Insurance Coverage for Third Party Liability (1 Photocopy)',
                                    'Barangay_Clearance' => 'Barangay Business Clearance certifying availability of a garage (1 Original Copy)',
                                    'Picture' => 'Pictures wearing TODA uniform (2 Original Copies)',
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
                                        <a href="{{ $file->drive_link }}" style="text-decoration: none;" class="button-style">View attachment</a>                                         @endforeach
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

        <div id="account-creation" class="form-section" style="margin-top: 20px;">
            <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">User Account Creation</h3>
            <div class="card" style="padding: 20px;">
                <div class="row">
                    <div class="col-md-12">
                        <p style="margin-bottom: 15px;">
                            @if($TODAapplication->user_id)
                                <i class="fas fa-check-circle" style="color: #004d00;"></i> User account has been created for this applicant.
                            @else
                                <i class="fas fa-info-circle" style="color: #004d00;"></i> No user account exists for this applicant yet.
                            @endif
                        </p>
                        <button 
                            onclick="createUserAccount({{ $TODAapplication->id }})"
                            class="button-style"
                            {{ $TODAapplication->user_id ? 'disabled' : '' }}
                            style="width: 100%; margin-top: 10px; {{ $TODAapplication->user_id ? 'background-color: #cccccc;' : '' }}"
                        >
                            {{ $TODAapplication->user_id ? 'Account Already Created' : 'Create User Account' }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
<script>
    document.addEventListener('DOMContentLoaded', () => {
    const uploadModal = document.getElementById('uploadModal');
    const modalForm = document.getElementById('modalUploadForm');
    const requirementTypeInput = document.getElementById('requirementType');

    uploadModal.addEventListener('show.bs.modal', (event) => {
        const button = event.relatedTarget;
        const requirementType = button.getAttribute('data-requirement');
        const todaApplicationId = '{{ $TODAapplication->id }}'; // Pass it from the backend

        // Update modal title and hidden input
        const modalTitle = uploadModal.querySelector('.modal-title');
        const label = button.getAttribute('data-label');
        modalTitle.textContent = `Upload ${label}`;
        requirementTypeInput.value = requirementType;

        // Generate the correct action URL
        const actionUrl = `/admin/toda-requirements/${todaApplicationId}/upload/${requirementType}`;
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
    fetch(`/update-remarks/toda/${applicationId}`, {
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
    function createUserAccount(applicationId) {
    Swal.fire({
        title: 'Create User Account',
        text: 'Are you sure you want to create a user account for this applicant?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#004d00',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, create account'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`/toda-applications/${applicationId}/create-user`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'An unknown error occurred');
                    });
                }
                return response.json();
            })
            .then(data => {
                if (data.error) {
                    Swal.fire('Error', data.message, 'error');
                    return;
                }

                // Different messages based on whether user existed or was created
                if (data.existing_user) {
                    Swal.fire({
                        title: 'Application Assigned!',
                        html: `
                            <p>The application has been assigned to <strong>${data.user_name}</strong></p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p style="color: blue;">User account already exists in the system.</p>
                        `,
                        icon: 'success',
                        confirmButtonColor: '#004d00'
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        title: 'Success!',
                        html: `
                            <p>New user account created successfully!</p>
                            <p><strong>Email:</strong> ${data.email}</p>
                            <p><strong>Phone:</strong> ${data.phone_number}</p>
                            <p><strong>Password:</strong> ${data.password}</p>
                            <p style="color: red;">Please save these credentials!</p>
                        `,
                        icon: 'success',
                        confirmButtonColor: '#004d00'
                    }).then(() => {
                        location.reload();
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error.message || error);
                Swal.fire('Error', error.message || 'An error occurred while creating the user account.', 'error');
            });
        }
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
<script>
    function updateRemarks(applicationId) {
        // Get the remarks value
        const remarksTextarea = document.getElementById(`remarks-${applicationId}`);
        const remarks = remarksTextarea.value;
        const token = document.querySelector('meta[name="csrf-token"]').content;
        

        // Disable textarea and show loading state
        remarksTextarea.disabled = true;
        
        // Show loading indicator
        Swal.fire({
            title: 'Saving...',
            text: 'Please wait while we save your remarks and send notification',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Make the API request
        fetch(`/api/toda-applications/${applicationId}/remarks`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({ 
                remarks: remarks,
                send_sms: true  // Always send SMS when updating remarks
            })
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Remarks updated and notification sent successfully',
                    timer: 2000,
                    showConfirmButton: false
                });
            } else {
                throw new Error(data.message || 'Failed to update remarks');
            }
        })
        .catch(error => {
            console.error('Error updating remarks:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to update remarks. Please try again.'
            });
        })
        .finally(() => {
            // Re-enable textarea
            remarksTextarea.disabled = false;
        });
    }
</script>
@endsection
