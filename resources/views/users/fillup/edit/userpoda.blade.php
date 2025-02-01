<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PODA Application</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset ('form/css/form.css ')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


</head>
<body>
@if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#d4edda',
            color: '#155724'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#f8d7da',
            color: '#721c24'
        });
    </script>
@endif
    <div class="header">
        <div class="left">
            <img src="{{ asset('landing/assets/img/tru-picture.png') }}" alt="POSO-TRU Logo">
            <h3>POSO-TRU San Pedro, Laguna</h3>
        </div>
        <div class="right">
            <a href="{{ route('dashboard') }}">Home</a>
            {{-- <a href="#">Profile</a>
            <a href="#">Logout</a> --}}
        </div>
    </div>
                 

    <div class="container">
        <div class="sidebar">
            <label for="file-upload" class="custom-file-upload">
                PODA Permit Application
            </label>    
            <nav>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin: 1rem 0;"><a href="{{ route('poda.edit', $application->id) }}" style="color: var(--primary-color); text-decoration: none; ">1. Personal Information</a></li>
                    <li style="margin: 1rem 0;">
                        <a href="{{ route('show.upload.poda', $application->id) }}" style="color: var(--primary-color); text-decoration: none;">
                            2. Requirements
                        </a>
                    </li>     
                    <li>
                        @php
                            // Count the number of approved requirements excluding Official_receipt
                            $approvedRequirementsCount = \App\Models\PodaRequirements::where('poda_application_id', $application->id)
                                ->where('requirement_type', '!=', 'Official_receipt')
                                ->where('status', 'approved')
                                ->count();

                            // Check if exactly 8 requirements are approved
                            $hasEightApprovedRequirements = $approvedRequirementsCount === 5;
                        @endphp
                        
                        @if($hasEightApprovedRequirements)
                            <a href="{{ route('poda.payment', ['id' => $application->id]) }}" 
                                style="color: #004d00;">3. Payment Receipt</a>
                        @else
                            <span style="color: #808080; cursor: not-allowed;" 
                                title="You need exactly 8 approved requirements before accessing the payment receipt">
                                3. Payment Receipt <br>
                                (@if($approvedRequirementsCount < 8)
                                    {{ 8 - $approvedRequirementsCount }} more requirement(s) needed
                                @else
                                    Verify all requirements first
                                @endif)
                            </span>
                        @endif
                    </li>                  
                    <li>
                        @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>There were some errors with your submission:</strong>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                        @endif
                    </li>
                </ul>
            </nav>
        </div>

        <div class="main-content">
            <h1 class="section-title">Personal Information</h1>
            
            <form action="{{ route('PODAapplication.update',$application->id) }}" method="POST">
            @csrf
            @method('PUT')
                <div class="form-section">

                
                    <div class="section-header">PODA Association</div>
                    <div class="form-row">
                        <div class="form-column">
                        <select id="podaAssociationSelect" name="PODA_Association" class="form-control" data-value="{{ $application->PODA_Association }}">
                                <!-- Options will be added by JavaScript -->
                            </select>
                            
                        </div>
                        <div class="form-column">
                               
                        </div>  
                    </div>

                    <div id="applicantFields" class="hidden-section">
                        <div class="section-header">Applicant Information</div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="applicant_first_name">First Name</label>
                                <input type="text" id="applicant_first_name" name="applicant_first_name" value="{{ $application ? $application->applicant_first_name : '' }}" placeholder="Enter first name">
                            </div>
                            <div class="form-column">
                                <label for="applicant_middle_name">Middle Name</label>
                                <input type="text" id="applicant_middle_name" name="applicant_middle_name" value="{{ $application ? $application->applicant_middle_name : '' }}" placeholder="Enter middle name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="applicant_last_name">Last Name</label>
                                <input type="text" id="applicant_last_name" name="applicant_last_name" value="{{ $application ? $application->applicant_last_name : '' }}"" placeholder="Enter last name">
                            </div>
                            <div class="form-column">
                                <label for="applicant_suffix">Suffix</label>
                                <input type="text" id="applicant_suffix" name="applicant_suffix" value="{{ $application ? $application->applicant_suffix : '' }}" placeholder="Enter suffix (if any)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="Contact_No_1">Contact Number</label>
                                <input type="tel" id="Contact_No_1" name="Contact_No_1" value="{{ $application->Contact_No_1 }}" placeholder="Enter contact number">
                            </div>
                            <div class="form-column">
                                <label for="Address1">Address</label>
                                <input type="text" id="applicantAddress" name="Address1" value="{{ $application ? $application->Address1 : '' }}" placeholder="Enter complete address">
                            </div>
                        </div>
                    </div>

                    <div class="section-header">Driver Information</div>
                    <div class="form-row">
                            <div class="form-column">
                                <label for="driver_first_name">First Name</label>
                                <input type="text" id="diver_first_name" name="driver_first_name" value="{{ $application ? $application->driver_first_name : '' }}" placeholder="Enter first name">
                            </div>
                            <div class="form-column">
                                <label for="driver_middle_name">Middle Name</label>
                                <input type="text" id="driver_middle_name" name="driver_middle_name" value="{{ $application ? $application->driver_middle_name : '' }}" placeholder="Enter middle name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="driver_last_name">Last Name</label>
                                <input type="text" id="driver_last_name" name="driver_last_name" value="{{ $application ? $application->driver_last_name : '' }}"" placeholder="Enter last name">
                            </div>
                            <div class="form-column">
                                <label for="driver_suffix">Suffix</label>
                                <input type="text" id="driver_suffix" name="driver_suffix" value="{{ $application ? $application->driver_suffix : '' }}" placeholder="Enter suffix (if any)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="Contact_No_2">Contact Number</label>
                                <input type="tel" id="Contact_No_2" name="Contact_No_2" value="{{ $application->Contact_No_2 }}" placeholder="Enter contact number">
                            </div>
                            <div class="form-column">
                                <label for="Address2">Address</label>
                                <input type="text" id="driverAddress" name="Address_2" value="{{ $application ? $application->Address_2 : '' }}" placeholder="Enter complete address">
                            </div>
                        </div>
                    </div>

                    <div class="section-header">PEDICAB Description</div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="stickerNo">Sticker no</label>
                            <input type="text" id="bodyNo" name="Sticker_no" value="{{ $application ? $application->Sticker_no : '' }}" placeholder="Enter body number">
                        </div>
                        <div class="form-column">
                            <label for="unitNo1">Unit #1</label>
                            <input type="text" id="unitNo1" name="Unit_no1" value="{{ $application ? $application->Unit_no1 : '' }}"  placeholder="Enter plate number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="unitNo2">Unit #2</label>
                            <input type="text" id="unitNo2" name="Unit_no2" value="{{ $application ? $application->Unit_no2 : '' }}"  placeholder="Enter plate number">
                        </div>
                        <div class="form-column">
                            <label for="unitNo3">Unit #3</label>
                            <input type="text" id="unitNo3" name="Unit_no3" value="{{ $application ? $application->Unit_no3 : '' }}"  placeholder="Enter plate number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="unitNo4">Unit #4</label>
                            <input type="text" id="unitNo4" name="Unit_no4" value="{{ $application ? $application->Unit_no4 : '' }}"  placeholder="Enter plate number">
                        </div>      
                        <div class="form-column">
                           
                        </div>  
                    </div>
                    

                    <button type="submit" class="submit-button">Submit Application</button>
                </div>
            </form>
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
            
            <form action="{{ route('generate.pagpapatunay.poda', ['id' => $application->id]) }}" method="GET">
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
        @if(isset($files))
            @foreach($files as $file)
                @if($file->requirement_type == 'Official_Receipt' && $file->status == 'approved')
                    document.getElementById('successModal').style.display = 'block';
                @endif
            @endforeach
        @endif

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
    // Constants
const PODA_OPTIONS = [
    "SSPODA",
    "PSPODA",
    "TYPODA",
];

document.addEventListener('DOMContentLoaded', () => {
    // Initialize the TODA association dropdown
    const selectElement = document.getElementById("podaAssociationSelect");
    if (!selectElement) {
        console.error("PODA Association select element not found");
        return;
    }

    // Clear existing options
    selectElement.innerHTML = '';

    // Add default option
    const defaultOption = document.createElement("option");
    defaultOption.value = "";
    defaultOption.textContent = "Select PODA Association";
    selectElement.appendChild(defaultOption);

    // Get current value if it exists (for edit form)
    const currentValue = selectElement.getAttribute('data-value') || '';

    // Add TODA options
    PODA_OPTIONS.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option;
        optionElement.textContent = option;
        
        // Select the current value if it exists
        if (option === currentValue) {
            optionElement.selected = true;
        }
        
        selectElement.appendChild(optionElement);
    });

    // Add change event listener
    selectElement.addEventListener('change', (e) => {
        console.log('Selected PODA:', e.target.value);
    });
});
</script>

</body>
</html>
