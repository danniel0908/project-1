@extends('users.fillup.layout')
@section('title', 'TODA Dropping')

@section('content-form')
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
                    <li style="margin: 1rem 0;"><a href="{{ route('toda.drop.fillup') }}" style="color: var(--primary-color); text-decoration: none; ">1. Personal Information</a></li>
                    <li style="margin: 1rem 0;"><a href="{{ route('upload.todaDrop')}}" style="color: grey; pointer-events: none;">2. Requirements</a></li>
                    <li>
                        <a href="" 
                        style="color: grey; pointer-events: none;">3. Payment Receipt</a>
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
            
            <form action="{{ route('TODADropping.store') }}" method="POST">
            @csrf   
                <div class="form-section">
                    <div class="form-row">
                        <div class="form-column">
                                <label for="applicant_first_name">First Name</label>
                                <input type="text" id="applicant_first_name" name="applicant_first_name" value="{{ $userInfo['applicantType'] === 'Operator' ? $userInfo['firstName'] : '' }}" placeholder="Enter first name">
                            </div>
                            <div class="form-column">
                                <label for="applicant_middle_name">Middle Name</label>
                                <input type="text" id="applicant_middle_name" name="applicant_middle_name" value="{{ $userInfo['applicantType'] === 'Operator' ? $userInfo['middle_name'] : '' }}" placeholder="Enter middle name">
                            </div>  
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="applicant_last_name">Last Name</label>
                                <input type="text" id="applicant_last_name" name="applicant_last_name" value="{{ $userInfo['applicantType'] === 'Operator' ? $userInfo['lastName'] : '' }}" placeholder="Enter last name">
                            </div>
                            <div class="form-column">
                                <label for="applicant_suffix">Suffix</label>
                                <input type="text" id="applicant_suffix" name="applicant_suffix" value="{{ $userInfo['applicantType'] === 'Operator' ? $userInfo['suffix'] : '' }}" placeholder="Enter suffix (if any)">
                            </div>
                    </div>
                    <div class="form-column">
                            <label for="Contact_no">Contact Number</label>
                            <input type="tel" id="Contact_no" name="Contact_no" value="{{ $user->phone_number }}"  placeholder="Enter contact number">
                        </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label for="Address">Address</label>
                            <input type="text" id="Address" name="Address"  placeholder="Enter complete address">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label for="Validity_Period">Validity Period:</label>
                            <input type="text" id="Validity_Period" name="Validity_Period" placeholder="Enter Validity Period">
                        </div>
                        <div class="form-column">
                            <label for="Case_no">Case no:</label>
                            <input type="tel" id="Case_no" name="Case_no"  placeholder="Enter Case number">
                        </div>
                    </div>

                    <div class="section-header">Motor Description</div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="bodyNo">Body Number</label>
                            <input type="text" id="bodyNo" name="Body_no" placeholder="Enter body number">
                        </div>
                        <div class="form-column">
                            <label for="plateNo">Plate Number</label>
                            <input type="text" id="plateNo" name="Plate_no"  placeholder="Enter plate number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="make">Make</label>
                            <input type="text" id="make" name="Make"  placeholder="Enter vehicle make">
                        </div>
                        <div class="form-column">
                            <label for="engineNo">Engine Number</label>
                            <input type="text" id="engineNo" name="Engine_no" placeholder="Enter engine number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="chassisNo">Chassis Number</label>
                            <input type="text" id="chassisNo" name="Chassis_no" placeholder="Enter chassis number">
                        </div>
                        <div class="form-column">                          
                        </div>  
                    </div>

                    <div class="section-header">Reason for Dropping</div>
                    <div class="form-row">
                        <div class="form-column">
                            <textarea name="reasons" class="form-control" rows="4" style="width: 100%; padding: 10px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; background-color: rgb(238, 233, 233); color: black; font-size: 16px; font-family: 'Source Sans Pro', 'apple-system', BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';" placeholder="Enter reasons here"></textarea>
                        </div>
 
                    </div>

                    <button type="submit" class="submit-button">Submit Application</button>
                </div>
            </form>
        </div>
        
    </div>

    <script src="{{ asset('form/form_todaModal.js') }}"></script>
@endsection
