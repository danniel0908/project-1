@extends('users.upload.layout')

@section('title', 'Service Requirements')
@section('requirement-form')
    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; margin-top: 20px;">
        <div class="container">
            <div class="sidebar">
                <label for="file-upload" class="custom-file-upload">
                    PODA Dropping Franchise
                </label>
                <input type="file" id="file-upload" style="display: none;">
                <nav>
                    <ul>
                        <li><a href="{{ route('podadrop.edit',['id' => $Application->id]) }}" style="color: #004d00;">1.) Personal Information</a></li>
                        <li><a href="{{ route('upload.podaDrop')}}" style="color: #004d00;">2.) Requirements</a></li>
                        <li>
                            @php
                                // Count the number of approved requirements excluding Official_receipt
                                $approvedRequirementsCount = \App\Models\podaDroppingRequirements::where('poda_dropping_id', $Application->id)
                                    ->where('requirement_type', '!=', 'Official_receipt')
                                    ->where('status', 'approved')
                                    ->count();

                                // Check if exactly 8 requirements are approved
                                $hasEightApprovedRequirements = $approvedRequirementsCount === 2;
                            @endphp
                            
                            @if($hasEightApprovedRequirements)
                                <a href="{{ route('podadrop.payment', ['id' => $Application->id]) }}" 
                                    style="color: #004d00;">3. Payment Receipt</a>
                            @else
                                <span style="color: #808080; cursor: not-allowed;" 
                                    title="You need exactly 8 approved requirements before accessing the payment receipt">
                                    3. Payment Receipt <br>
                                    (@if($approvedRequirementsCount < 2)
                                        {{ 2 - $approvedRequirementsCount }} more requirement(s) needed
                                    @else
                                        Verify all requirements first
                                    @endif)
                                </span>
                            @endif
                        </li>   
                    </ul>
                </nav>
            </div>
            <div class="main-content">
                <div id="personal-info" class="form-section">
                        <h1 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Uploading of Requirements</h1>
                <table>
                    <thead>
                        <tr>
                            <th>Requirement</th>
                            <th>Attachment</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="{{ route('podaDrop.upload',['poda_dropping_id' => $Application->id]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <tr>
                                <td>Duly-accomplished Application form (1 Original Set)
                                <br>
                                    @foreach($files as $file)
                                                @if($file->requirement_type == 'Application_form')
                                                @if ($file->status == 'approved')
                                                <p class="status approved"><i class="fa fa-check-circle"></i> Approved</p>                                              
                                                @elseif ($file->status == 'reject')
                                                    <p class="status invalid" onclick="showRemarks('{{ $file->remarks }}')" style="cursor: pointer;">
                                                        <i class="fa fa-times-circle"></i> Invalid
                                                    </p>
                                                    @else
                                                        <p class="status pending">Verifying</p>
                                                    @endif
                                                @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($files->isEmpty() || !$files->contains('requirement_type', 'Application_form'))
                                    <p>No files uploaded for this requirement.</p>
                                    <td>
                                        <input type="file" class="form-control" name="files[]" id="file2">
                                        <input type="hidden" name="requirement_type[]" value="Application_form">
                                    </td>
                                    @else
                                        @foreach($files as $file)
                                            @if($file->requirement_type == 'Application_form')
                                                <a href="{{ $file->drive_link }}" style="text-decoration: none;" class="button-style">View attachment</a>
                                            @endif
                                        @endforeach
                                    @endif
                                    @foreach($files as $file)
                                        @if($file->requirement_type == 'Application_form')
                                            <td>
                                                <button type="button" class="button-style edit-file-btn" 
                                                    data-requirement-type="{{ $file->requirement_type }}" 
                                                    data-file-id="{{ $file->id }}">
                                                    Edit
                                                </button>
                                            </td>                                 
                                        @endif
                                    @endforeach
                                </td>
                            </tr>

                            <tr>
                                <td>Current franchise (1 Photocopy)
                                <br>
                                    @foreach($files as $file)
                                                @if($file->requirement_type == 'Current_franchise')
                                                @if ($file->status == 'approved')
                                                <p class="status approved"><i class="fa fa-check-circle"></i> Approved</p>                                              
                                                @elseif ($file->status == 'reject')
                                                    <p class="status invalid" onclick="showRemarks('{{ $file->remarks }}')" style="cursor: pointer;">
                                                        <i class="fa fa-times-circle"></i> Invalid
                                                    </p>
                                                    @else
                                                        <p class="status pending">Verifying</p>
                                                    @endif
                                                @endif
                                    @endforeach
                                </td>
                                <td>
                                    @if($files->isEmpty() || !$files->contains('requirement_type', 'Current_franchise'))
                                    <p>No files uploaded for this requirement.</p>
                                    <td>
                                        <input type="file" class="form-control" name="files[]" id="file2">
                                        <input type="hidden" name="requirement_type[]" value="Current_franchise">
                                    </td>
                                    @else
                                        @foreach($files as $file)
                                            @if($file->requirement_type == 'Current_franchise')
                                                <a href="{{ $file->drive_link }}" style="text-decoration: none;" class="button-style">View attachment</a>
                                            @endif
                                        @endforeach
                                    @endif
                                    @foreach($files as $file)
                                        @if($file->requirement_type == 'Current_franchise')
                                            <td>
                                                <button type="button" class="button-style edit-file-btn" 
                                                    data-requirement-type="{{ $file->requirement_type }}" 
                                                    data-file-id="{{ $file->id }}">
                                                    Edit
                                                </button>
                                            </td>                                 
                                        @endif
                                    @endforeach
                                </td>
                            </tr>


                           
                            <tr>
                                <td colspan="4" style = "text-align: center">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </td>
                            </tr>
                        </form>
                    </tbody>
                </table>

            <p>Note: If the requirement i   s marked as invalid, click on the 'Invalid' mark to check the remarks.</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editButtons = document.querySelectorAll('.edit-file-btn');
            const popup = document.getElementById('fileUpdatePopup');
            const popupClose = popup.querySelector('.popup-close');
            const fileUpdateForm = document.getElementById('fileUpdateForm');
            const popupTitle = document.getElementById('popupTitle');

            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const fileId = this.getAttribute('data-file-id');
                    const requirementType = this.getAttribute('data-requirement-type');
                    
                    // Update form action dynamically
                    fileUpdateForm.action = `/podadrop/update-file/${fileId}`;
                    
                    // Update popup title
                    popupTitle.textContent = `Update ${requirementType.replace(/_/g, ' ')}`;
                    
                    // Show popup
                    popup.style.display = 'block';
                });
            });

            // Close popup when clicking close button or overlay
            popupClose.addEventListener('click', closePopup);
            popup.addEventListener('click', function(e) {
                if (e.target === popup) {
                    closePopup();
                }
            });

            function closePopup() {
                popup.style.display = 'none';
            }
        });
    </script>
@endsection