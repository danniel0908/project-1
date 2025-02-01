<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">


@extends('layouts.app')

@section('title')
Private Service Application Edit
@endsection
@section('content')

<style>
    .editable {
    cursor: pointer;
    position: relative;
    border: 1px solid #070000;
    padding: 8px;
    }

    .editable:hover {
        background-color: #f5f5f5;
    }

    .editable.editing {
        padding: 0;
    }

    .editable input {
        width: 100%;
        padding: 7px;
        border: 2px solid #007bff;
        outline: none;
    }

    .editable.updated {
        animation: highlight 1s ease-out;
    }

    @keyframes highlight {
        0% { background-color: #90EE90; }
        100% { background-color: transparent; }
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }

    th {
        background-color: #f8f9fa;
        padding: 8px;
    }

    td {
        padding: 8px;
    }
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
        text-align: center;

    }
    tbody td {
        padding: 10px;
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
                    <div style = "display: flex; justify-content: space-between; color: hsl(120, 100%, 15%); border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">
                    <h3 >Applicant's Information</h1>
                        <div style="text-align: end; color: #004d00; rgb(207, 207, 207)"><h3>{{ $ServiceApplication->PPF_Association }}</h1></div>
                        <div style="text-align: end; color: #004d00; rgb(207, 207, 207)"><h3>{{ $ServiceApplication->custom_id }}</h1></div>

                    </div>
                    <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px; margin-top: 20px; ">
                        <p>Name: <b> {{ $ServiceApplication->Applicants_name }}</b></p>
                        <p>Contact: <b>{{ $ServiceApplication->Contact_No_1 }}</b></p>
                        <p>Address: <b>{{ $ServiceApplication->Address1 }}</b></p>
                    </div>
                </div>

                <div id="personal-info" class="form-section">
                    <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Driver's Information</h1>
                    <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px;">
                    <p>Name: <b>{{ $ServiceApplication->Drivers_name}}</b></p>
                    <p>Contact: <b>{{ $ServiceApplication->Contact_No_2}}</b></p>
                    <p>Address: <b> {{ $ServiceApplication->Address_2}}</b></p>
                    <p>Gender: <b> {{ $ServiceApplication->Gender }}</b></p>
                    <p>Age: <b> {{ $ServiceApplication->age}}</b></p>

                    </div>
                </div>

                <div id="personal-info" class="form-section">
                    <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Motor's Description</h1>
                    <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px;">
                        <p>Body no: <b>{{ $ServiceApplication->Body_no }}</b></p>
                        <p>Plate no: <b>{{ $ServiceApplication->Plate_no }}</b></p>
                        <p>Make: <b>{{ $ServiceApplication->Make }}</b></p>
                        <p>Chassis no: <b>{{ $ServiceApplication->Chassis_no }}</b></p>
                        <p>Engine no: <b> {{ $ServiceApplication->Engine_no }}</b></p>
                    </div>
                </div>

                <h3 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">
                    Admin Remarks
                </h3>
                <div class="card" style="padding: 20px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <!-- Add this new select dropdown -->
                                <div class="mb-3">
                                    <select id="predefined-messages-{{ $ServiceApplication->id }}" class="form-control" onchange="insertPredefinedMessage(this.value, {{ $ServiceApplication->id }})">
                                        <option value="">Select a predefined message...</option>
                                        @foreach($predefinedMessages as $message)
                                            <option value="{{ $message->id }}">{{ $message->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <!-- Your existing textarea -->
                                <textarea 
                                    id="remarks-{{ $ServiceApplication->id }}" 
                                    class="form-control"
                                    rows="4" 
                                    style="resize: vertical; min-height: 100px;"
                                    placeholder="Add administrative remarks here..."
                                >{{ $ServiceApplication->remarks }}</textarea>
                                <div class="d-flex justify-content-end mt-3">
                                    <button 
                                        onclick="updateRemarks({{ $ServiceApplication->id }})"
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
            <div class="main-content">
            <div id="personal-info" class="form-section">
                <h1 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Requirements</h1>
                <!-- Main Form -->
                <form action="{{ route('service-requirements.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="private_service_id" value="{{ $ServiceApplication->id }}">
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


            
            <div id="personal-info" class="form-section">
                <div class="card" style="padding-left: 20px; padding-bottom: 20px; padding-top: 20px;">

                    <section class="content">
                        <h1>Schedule</h1>
                        @if(session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                        <table>
                            <thead>
                                <tr>
                                    <th  style="border: 1px solid #070000;" colspan="2">Route</th>
                                    <th  style="border: 1px solid #070000;" colspan="4">Time</th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid #070000;">From</th>
                                    <th style="border: 1px solid #070000;">To</th>
                                    <th  style="border: 1px solid #070000;"colspan="2">AM</th>
                                    <th  style="border: 1px solid #070000;"colspan="2">PM</th>
                                </tr>
                                <tr>
                                    <th style="border: 1px solid #070000;"></th>
                                    <th style="border: 1px solid #070000;"></th>
                                    <th style="border: 1px solid #070000;">From</th>
                                    <th style="border: 1px solid #070000;">To</th>
                                    <th style="border: 1px solid #070000;">From</th>
                                    <th style="border: 1px solid #070000;">To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr data-id="{{ $schedule->id }}">
                                        <td class="editable" data-field="route_from">{{ $schedule->route_from }}</td>
                                        <td class="editable" data-field="route_to">{{ $schedule->route_to }}</td>
                                        <td class="editable" data-field="am_time_from">{{ $schedule->am_time_from }}</td>
                                        <td class="editable" data-field="am_time_to">{{ $schedule->am_time_to }}</td>
                                        <td class="editable" data-field="pm_time_from">{{ $schedule->pm_time_from }}</td>
                                        <td class="editable" data-field="pm_time_to">{{ $schedule->pm_time_to }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No schedules found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </section>
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
        const serviceApplicationId = '{{ $ServiceApplication->id }}'; // Pass it from the backend

        // Update modal title and hidden input
        const modalTitle = uploadModal.querySelector('.modal-title');
        const label = button.getAttribute('data-label');
        modalTitle.textContent = `Upload ${label}`;
        requirementTypeInput.value = requirementType;

        // Generate the correct action URL
        const actionUrl = `/admin/service-requirements/${serviceApplicationId}/upload/${requirementType}`;
        modalForm.action = actionUrl;
    });
});

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
    fetch(`/update-remarks/private-service/${applicationId}`, {
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
        // Add this to your page's JavaScript section or a separate .js file
$(document).ready(function() {
    // Store original content when starting edit
    let originalContent;
    
    // Handle double click on editable cells
    $('.editable').dblclick(function(e) {
        const cell = $(this);
        if (!cell.hasClass('editing')) {
            originalContent = cell.text().trim();
            const input = $('<input type="text">')
                .val(originalContent)
                .addClass('form-control');
            
            cell.html(input)
                .addClass('editing');
            
            input.focus();
        }
    });

    // Handle input blur and enter key
    $(document).on('blur keyup', '.editable input', function(e) {
        if (e.type === 'keyup' && e.keyCode !== 13) return;
        
        const input = $(this);
        const cell = input.closest('td');
        const newValue = input.val().trim();
        const field = cell.data('field');
        const id = cell.closest('tr').data('id');

        if (newValue !== originalContent) {
            updateCell(id, field, newValue, cell);
        } else {
            cell.html(originalContent)
                .removeClass('editing');
        }
    });

    // Function to update the cell value
    function updateCell(id, field, value, cell) {
        const data = {};
        data[field] = value;

        $.ajax({
            url: `/schedules/${id}`,
            method: 'PUT',
            data: data,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    cell.html(value)
                        .removeClass('editing')
                        .addClass('updated');
                    
                    // Remove the updated highlight after 1 second
                    setTimeout(() => {
                        cell.removeClass('updated');
                    }, 1000);
                } else {
                    alert('Update failed');
                    cell.html(originalContent)
                        .removeClass('editing');
                }
            },
            error: function(xhr) {
                alert('Error updating value: ' + (xhr.responseJSON?.message || 'Unknown error'));
                cell.html(originalContent)
                    .removeClass('editing');
            }
        });
    }
});
    </script>
@endsection



