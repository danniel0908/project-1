@extends('users.fillup.layout')
@section('title', 'Sticker Application')

@section('content-form')
    <div class="header">
        <div class="left">
            <img src="{{ asset('landing/assets/img/tru-picture.png') }}" alt="POSO-TRU Logo">
            <h3>POSO-TRU San Pedro, Laguna</h3>
        </div>
        <div class="right">
            <a href="{{ route('dashboard') }}">Home</a>
        </div>
    </div>

    <div class="container">
        <div class="sidebar">
            <label for="file-upload" class="custom-file-upload">
                Sticker Permit Application
            </label>    
            <nav>
                <ul style="list-style: none; padding: 0;">
                    <li style="margin: 1rem 0;"><a href="{{ route('ppf.fillup') }}" style="color: var(--primary-color); text-decoration: none; ">1. Personal Information</a></li>
                    <li style="margin: 1rem 0;"><a href="{{ route('upload.sticker')}}" style="color: grey; pointer-events: none;">2. Requirements</a></li>
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
            
            <form action="{{ route('PPFapplication.store') }}" method="POST">
                @csrf   
                <input type="hidden" id="applicantType" name="applicant_type" value="{{ $userInfo['applicantType'] }}">
                <input type="hidden" id="userFirstName" value="{{ $userInfo['firstName'] }}">
                <input type="hidden" id="userMiddleName" value="{{ auth()->user()->middle_name }}">
                <input type="hidden" id="userLastName" value="{{ $userInfo['lastName'] }}">
                <input type="hidden" id="userSuffix" value="{{ auth()->user()->suffix}}">
                <input type="hidden" id="userContactNo" value="{{ auth()->user()->phone_number  }}">


                <div class="form-section">

                    <div class="section-header">TODA Association</div>
                    <div class="form-row">
                        <div class="form-column">
                            <select id="ppfAssociationSelect" name="PPF_Association">
                                <!-- Options will be added by JavaScript -->
                            </select>
                        </div>
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

                    <div class="section-header">Motor Description</div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="Body_no">Body Number</label>
                            <input type="text" id="Body_no" name="Body_no" placeholder="Enter body number">
                        </div>
                        <div class="form-column">
                            <label for="Plate_no">Plate Number</label>
                            <input type="text" id="Plate_no" name="Plate_no" placeholder="Enter plate number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="Make">Make</label>
                            <input type="text" id="Make" name="Make" placeholder="Enter vehicle make">
                        </div>
                        <div class="form-column">
                            <label for="Engine_no">Engine Number</label>
                            <input type="text" id="Engine_no" name="Engine_no" placeholder="Enter engine number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-column">
                            <label for="Chassis_no">Chassis Number</label>
                            <input type="text" id="Chassis_no" name="Chassis_no" placeholder="Enter chassis number">
                        </div>
                    </div>

                    <button type="submit" class="submit-button">Submit Application</button>
                </div>
            </form>
        </div>
    </div>

    <script src="{{ asset('form/form_stickerModal.js') }}"></script>


@endsection