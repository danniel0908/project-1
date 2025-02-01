@extends('users.upload.layout')

@section('title', 'TODA Dropping')
@section('requirement-form')
<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; margin-top: 20px;">
        <div class="container">
            <div class="sidebar">
                <label for="file-upload" class="custom-file-upload">
                    TODA Dropping
                </label>
                <input type="file" id="file-upload" style="display: none;">
                <nav>
                <ul>
                    <li>
                        <a href="{{ route('todadrop.edit',['id' => $todaDropping->id]) }}" 
                        style="color: #004d00;">1.) Personal Information</a>
                    </li>
                    <li>
                        <a href="{{ route('show.upload.todadrop', $todaDropping->id) }}" style="color: #004d00; text-decoration: none;">
                            2.) Requirements
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('todadrop.edit',['id' => $todaDropping->id]) }}" 
                        style="color: #004d00;">3.) Payment Receipt</a>
                    </li>
                </ul>
                </nav>
            </div>
            <div class="main-content">
              
                        <h2 style="color: #004d00; padding-left: 20px; margin-top: 40px;">Final Step: Payment Receipt</h2>
        <table style="width: 100%;">
            <thead>
                <tr>
                    <th>Requirement</th>
                    <th>Attachment</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <form action="{{ route('todaDrop.upload', ['toda_dropping_id' => $todaDropping->id]) }}" method="POST" enctype="multipart/form-data">
            @csrf
                <tr>
                    <td>Official Receipt (1 Original Copy and 1 Photocopy)
                    <br> 
                        @foreach($files as $file)
                            @if($file->requirement_type == 'Official_Receipt')
                                @if ($file->status == 'approved')
                                    <p class="status approved"><i class="fa fa-check-circle"></i> Approved</p>
                                    <div class="alert alert-success" style="margin-top: 10px; padding: 10px; border-radius: 4px; background-color: #d4edda; border-color: #c3e6cb; color: #155724;">
                                        <i class="fa fa-info-circle"></i> Your application has been approved! You may now proceed to the POSO-TRU Office to claim your certificate and ID.
                                    </div>
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
                        @if($files->isEmpty() || !$files->contains('requirement_type', 'Official_Receipt'))
                            <p>No files uploaded for this requirement.</p>
                            <td>
                                <input type="file" class="form-control" name="files[]" id="file2">
                                <input type="hidden" name="requirement_type[]" value="Official_Receipt">
                            </td>
                        @else
                            @foreach($files as $file)
                                @if($file->requirement_type == 'Official_Receipt')
                                    <a href="{{ $file->drive_link }}" style="text-decoration: none;" class="button-style">View attachment</a>
                                @endif
                            @endforeach
                        @endif
                        @foreach($files as $file)
                            @if($file->requirement_type == 'Official_Receipt')
                                <td>
                                    @if($file->status !== 'approved')
                                        <button type="button" class="button-style edit-file-btn" 
                                            data-requirement-type="{{ $file->requirement_type }}" 
                                            data-file-id="{{ $file->id }}">
                                            Edit
                                        </button>
                                    @endif
                                </td>                                 
                            @endif
                        @endforeach
                    </td>
                </tr>
                <tr>
                    <td colspan="3" style="text-align: center">
                        <button type="submit" class="btn btn-primary btn-sm" style="width: 200px; height:50px;">Submit Payment Receipt</button>
                    </td>
                </tr>
            </form>
            </tbody>
        </table>

        <div class="notes-section" style="margin-top: 20px; padding: 15px; background-color: #f8f9fa; border-radius: 4px; border: 1px solid #dee2e6;">
            <p style="text-align: center; margin-bottom: 10px;">
                <strong>Important Notes:</strong>
            </p>
            <ul style="list-style-type: none; padding: 0; margin: 0;">
                <li style="margin-bottom: 8px; text-align: center;">
                    1. For payment processing, please proceed to the Municipal Treasury Office to pay and obtain your official receipt.
                </li>
                <li style="margin-bottom: 8px; text-align: center;">
                    2. You have two options for submitting the receipt:
                    <br>• Upload it directly through this system
                    <br>• Submit it in person at the POSO-TRU Office
                </li>
                <li style="text-align: center;">
                    3. If any requirement is marked as invalid, click on the 'Invalid' mark to check the remarks.
                </li>
            </ul>
        </div>
            </div>
        </div>
    </div>
    <div id="successModal" class="modal" style="display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5);">
            <div class="modal-content" style="background-color: #fefefe; margin: 15% auto; padding: 20px; border: 1px solid #888; width: 80%; max-width: 500px; border-radius: 8px; position: relative;">
                <span class="close-modal" style="position: absolute; right: 15px; top: 10px; font-size: 28px; font-weight: bold; cursor: pointer; color: #666;">&times;</span>               
                <div style="text-align: center;">
                    <i class="fa fa-check-circle" style="font-size: 70px; color: #28a745;"></i>
                    <h3 style="color: #155724; margin-bottom: 15px;">Congratulations!</h3>
                    <p style="color: #155724; margin-bottom: 20px;">Your application has been approved.</p>
                    
                    <div style="margin: 20px 0;">
                        <p>Generate your Pagpapatunay document below.</p>
                        <p style="font-size: 0.9em; margin-top: 10px;">This document will be required when claiming your certificate and ID at the POSO-TRU Office.</p>
                    </div>
                    
                    <form action="{{ route('generate.pagpapatunay.todadrop', ['id' => $todaDropping->id]) }}" method="GET">
                        @csrf
                        <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-size: 16px; background-color: #004d00; border: none; border-radius: 4px; color: white; cursor: pointer;">
                            <i class="fa fa-file-pdf"></i> Generate Pagpapatunay
                        </button>
                    </form>
                </div>
            </div>
        </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Show modal if the status is approved
            @foreach($files as $file)
                @if($file->requirement_type == 'Official_Receipt' && $file->status == 'approved')
                    document.getElementById('successModal').style.display = 'block';
                @endif
            @endforeach

            // Close modal functionality
            const modal = document.getElementById('successModal');
            const closeBtn = document.querySelector('.close-modal');

            if (closeBtn) {
                closeBtn.onclick = function() {
                    modal.style.display = 'none';
                }
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                if (event.target == modal) {
                    modal.style.display = 'none';
                }
            }
        });
    </script>
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
                    fileUpdateForm.action = `/toda/update-file/${fileId}`;
                    
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