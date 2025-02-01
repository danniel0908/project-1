<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TODA Dropping</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset ('form/css/form.css ')}}">

</head>
<body>
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
                TODA Dropping Application
            </label>    
            <nav>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin: 1rem 0;"><a href="{{ route('todadrop.edit', $application->id) }}" style="color: var(--primary-color); text-decoration: none; ">1. Personal Information</a></li>
                    <li style="margin: 1rem 0;"><a href="{{ route('show.upload.todadrop', $application->id)}}" style="color: var(--primary-color); text-decoration: none; " >2. Requirements</a></li>
                    <li>
                        @php
                            // Count the number of approved requirements excluding Official_receipt
                            $approvedRequirementsCount = \App\Models\todaDroppingRequirements::where('toda_dropping_id', $application->id)
                                ->where('requirement_type', '!=', 'Official_receipt')
                                ->where('status', 'approved')
                                ->count();

                            // Check if exactly 8 requirements are approved
                            $hasEightApprovedRequirements = $approvedRequirementsCount === 2;
                        @endphp
                        
                        @if($hasEightApprovedRequirements)
                            <a href="{{ route('todadrop.payment', ['id' => $application->id]) }}" 
                                style="color: #004d00;">3. Payment Receipt</a>
                        @else
                            <span style="color: #808080; cursor: not-allowed;" 
                                title="You need exactly 2 approved requirements before accessing the payment receipt">
                                3. Payment Receipt <br>
                                (@if($approvedRequirementsCount < 2)
                                    {{ 2 - $approvedRequirementsCount }} more requirement(s) needed
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
            
            <form action="{{ route('TODADropping.update',$application->id) }}" method="POST">
            @csrf   
            @method('PUT')
                <div class="form-section">
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
                            <label for="Contact_no">Contact Number</label>
                            <input type="tel" id="Contact_no" name="Contact_no" value="{{ $application ? $application->contact_no : '' }}"  placeholder="Enter contact number">
                        </div>
                        <div class="form-column">
                            <label for="Address">Address</label>
                            <input type="text" id="Address" name="Address" value="{{ $application ? $application->address : '' }}" placeholder="Enter complete address">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label for="Validity_Period">Validity Period:</label>
                            <input type="text" id="Validity_Period" name="Validity_Period" value="{{ $application ? $application->validity_period : '' }}" placeholder="Enter Validity Period">
                        </div>
                        <div class="form-column">
                            <label for="Case_no">Case no:</label>
                            <input type="tel" id="Case_no" name="Case_no" value="{{ $application ? $application->case_no : '' }}" placeholder="Enter Case number">
                        </div>
                    </div>

                    <div class="section-header">Motor Description</div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="bodyNo">Body Number</label>
                            <input type="text" id="bodyNo" name="Body_no" value="{{ $application ? $application->body_no : '' }}" placeholder="Enter body number">
                        </div>
                        <div class="form-column">
                            <label for="plateNo">Plate Number</label>
                            <input type="text" id="plateNo" name="Plate_no" value="{{ $application ? $application->plate_no : '' }}" placeholder="Enter plate number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="make">Make</label>
                            <input type="text" id="make" name="Make" value="{{ $application ? $application->make : '' }}" placeholder="Enter vehicle make">
                        </div>
                        <div class="form-column">
                            <label for="engineNo">Engine Number</label>
                            <input type="text" id="engineNo" name="Engine_no" value="{{ $application ? $application->engine_no : '' }}" placeholder="Enter engine number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="chassisNo">Chassis Number</label>
                            <input type="text" id="chassisNo" name="Chassis_no" value="{{ $application ? $application->chassis_no : '' }}" placeholder="Enter chassis number">
                        </div>
                        <div class="form-column">                          
                        </div>  
                    </div>

                    <div class="section-header">Reason for Dropping</div>
                    <div class="form-row">
                        <div class="form-column">
                            <textarea name="reasons" class="form-control" rows="4" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: rgb(238, 233, 233); color: black; font-size: 16px; font-family: 'Source Sans Pro', 'apple-system', BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';" placeholder="Enter reasons here" value="" >{{ $application ? $application->reasons : '' }}</textarea>
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
                    
                    <form action="{{ route('generate.pagpapatunay.todadrop', ['id' => $application->id]) }}" method="GET">
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
    <script src="{{ asset('form/form_todaModal.js') }}"></script>

</body>
</html>

