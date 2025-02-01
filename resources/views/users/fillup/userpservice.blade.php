@extends('users.fillup.layout')
@section('title', 'Private Service Application')

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
                Private Service Permit Application
            </label>    
            <nav>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin: 1rem 0;"><a href="{{ route('service-applications.create') }}" style="color: var(--primary-color); text-decoration: none;">1. Personal Information</a></li>
               
                        <li><a href="#" style="color: grey; pointer-events: none;">2.) Schedule (Fillup application first)</a></li>
                
                    
                    <li style="margin: 1rem 0;"><a href="" style="color: grey; pointer-events: none;">3. Requirements</a></li>
                    <li style="margin: 1rem 0;"><a href="" style="color: grey; pointer-events: none;">4. Payment Receipt</a></li>


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
            
            <form action="{{ route('ServiceApplication.store') }}" method="POST">
                @csrf   
                <div class="form-section">

                <div class="section-header">Service Name</div>

                    <div class="form-row">
                        <div class="form-column">
                            <input type="text" id="Service_name" name="Service_name" placeholder="Enter service's name">
                        </div>
                        <div class="form-column"></div>  
                    </div>

                    <div id="applicantFields">
                        <div class="section-header">
                        {{ $userInfo['applicantType'] === 'Driver' ? 'Operator Information' : 'Applicant Information' }}
                            @if($userInfo['applicantType'] === 'Driver')
                            <div class="checkbox-container">
                                <input type="checkbox" id="autoFillDriverFields">
                                <label for="autoFillDriverFields">Auto-fill with driver details</label>
                            </div>
                            @endif
                        </div>                  
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
                        <div class="form-row">
                            <div class="form-column">
                                <label for="Contact_No_1">Contact Number</label>
                                <input type="tel" id="Contact_No_1" name="Contact_No_1" value="{{ $userInfo['applicantType'] === 'Operator' ? $userInfo['phone_number'] : '' }}" placeholder="Enter contact number">
                            </div>
                            <div class="form-column">
                                <label for="Address1">Address</label>
                                <input type="text" id="Address1" name="Address1" placeholder="Enter complete address">
                            </div>
                        </div>
                    </div>

                    <div id="driverFields">
                    <div class="section-header">
                    Driver Information
                            @if($userInfo['applicantType'] === 'Operator')
                            <div class="checkbox-container">
                                <input type="checkbox" id="autoFillDriverFields">
                                <label for="autoFillDriverFields">Auto-fill with operator details</label>
                            </div>
                            @endif
                    </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="driver_first_name">First Name</label>
                                <input type="text" id="driver_first_name" name="driver_first_name" 
                                    value="{{ $userInfo['applicantType'] === 'Driver' ? $userInfo['firstName'] : '' }}" 
                                    placeholder="Enter first name">
                            </div>
                            <div class="form-column">
                                <label for="driver_middle_name">Middle Name</label>
                                <input type="text" id="driver_middle_name" name="driver_middle_name" 
                                    value="{{ $userInfo['applicantType'] === 'Driver' ? (auth()->user()->middle_name ?? '') : '' }}" 
                                    placeholder="Enter middle name">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="driver_last_name">Last Name</label>
                                <input type="text" id="driver_last_name" name="driver_last_name" 
                                    value="{{ $userInfo['applicantType'] === 'Driver' ? $userInfo['lastName'] : '' }}" 
                                    placeholder="Enter last name">                            
                                </div>
                            <div class="form-column">
                                <label for="driver_suffix">Suffix</label>
                                <input type="text" id="driver_suffix" name="driver_suffix" 
                                    value="{{ $userInfo['applicantType'] === 'Driver' ? (auth()->user()->suffix ?? '') : '' }}" 
                                    placeholder="Enter suffix (if any)">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-column">
                                <label for="Contact_No_2">Contact Number</label>
                                <input type="tel" id="Contact_No_2" name="Contact_No_2" 
                                    value="{{ $userInfo['applicantType'] === 'Driver' ? (auth()->user()->phone_number ?? '') : '' }}" 
                                    placeholder="Enter contact number">
                                </div>
                            <div class="form-column">
                                <label for="Address_2">Address</label>
                                <input type="text" id="Address_2" name="Address_2" placeholder="Enter complete address">
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label for="Gender">Gender</label>
                            <select id="Gender" name="Gender">
                                <option value="">Select Gender</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                                <option value="prefer_not_to_say">Prefer not to say</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-column">
                            <label for="age">Age</label>
                            <input type="text" id="age" name="age" placeholder="Enter Driver's age">
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
                            <input type="text" id="plateNo" name="Plate_no" placeholder="Enter plate number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="make">Make</label>
                            <input type="text" id="make" name="Make" placeholder="Enter vehicle make">
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
                        <div class="form-column"></div>  
                    </div>

                    <button type="submit" class="submit-button">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Wait for DOM to be fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const autoFillDriverFields = document.getElementById('autoFillDriverFields');
    
    // Only initialize auto-fill functionality if the checkbox exists
    if (autoFillDriverFields) {
        autoFillDriverFields.addEventListener('change', function() {
            if (this.checked) {
                // Determine which fields to copy from based on applicant type
                const isDriverApplicant = document.querySelector('[data-applicant-type="Driver"]') !== null;
                
                if (isDriverApplicant) {
                    // Copy from driver fields to operator fields
                    document.getElementById('applicant_first_name').value = document.getElementById('driver_first_name').value || '';
                    document.getElementById('applicant_middle_name').value = document.getElementById('driver_middle_name').value || '';
                    document.getElementById('applicant_last_name').value = document.getElementById('driver_last_name').value || '';
                    document.getElementById('applicant_suffix').value = document.getElementById('driver_suffix').value || '';
                    document.getElementById('Contact_No_1').value = document.getElementById('Contact_No_2').value || '';
                    document.getElementById('Address1').value = document.getElementById('Address_2').value || '';
                } else {
                    // Copy from operator fields to driver fields
                    document.getElementById('driver_first_name').value = document.getElementById('applicant_first_name').value || '';
                    document.getElementById('driver_middle_name').value = document.getElementById('applicant_middle_name').value || '';
                    document.getElementById('driver_last_name').value = document.getElementById('applicant_last_name').value || '';
                    document.getElementById('driver_suffix').value = document.getElementById('applicant_suffix').value || '';
                    document.getElementById('Contact_No_2').value = document.getElementById('Contact_No_1').value || '';
                    document.getElementById('Address_2').value = document.getElementById('Address1').value || '';
                }
            } else {
                // Clear the auto-filled fields when unchecked
                const fieldsToCheck = isDriverApplicant ? [
                    'applicant_first_name', 'applicant_middle_name', 'applicant_last_name',
                    'applicant_suffix', 'Contact_No_1', 'Address1'
                ] : [
                    'driver_first_name', 'driver_middle_name', 'driver_last_name',
                    'driver_suffix', 'Contact_No_2', 'Address_2'
                ];

                fieldsToCheck.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) field.value = '';
                });
            }
        });
    }

    // Form validation
    const form = document.querySelector('form');
    if (form) {
        form.addEventListener('submit', function(e) {
            // Add your validation logic here
            const requiredFields = [
                'Service_name',
                'applicant_first_name',
                'applicant_last_name',
                'Contact_No_1',
                'Address1',
                'driver_first_name',
                'driver_last_name',
                'Contact_No_2',
                'Address_2',
                'Gender',
                'age',
                'Body_no',
                'Plate_no',
                'Make',
                'Engine_no',
                'Chassis_no'
            ];

            let isValid = true;
            requiredFields.forEach(fieldId => {
                const field = document.getElementById(fieldId);
                if (field && !field.value.trim()) {
                    isValid = false;
                    field.classList.add('error');
                } else if (field) {
                    field.classList.remove('error');
                }
            });

            if (!isValid) {
                e.preventDefault();
                alert('Please fill in all required fields');
            }
        });
    }
});
    </script>

    @endsection