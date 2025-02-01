@extends('layouts.app')

@section('title')
Sticker Application Edit
@endsection

@section('content')
@include('partials.alerts')

<div class="content-wrapper bg-light">
    <div class="container-fluid py-4">


        <!-- Main Card -->
        <div class="card shadow-sm">
            
        <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('PPFapplication.index') }}" class="text-decoration-none">Back to List</a></li>
                            <li class="breadcrumb-item active">Edit STICKER Application</li>
                        </ol>
                    </nav>
                </div>
            </div>
            
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <h6 class="alert-heading mb-1">Please fix the following errors:</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('PPFapplication.update', $PPFapplication->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Sticker Association -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Association</label>
                        <select id="ppfAssociationSelect" name="PPF_Association" class="form-select">
                        </select>
                    </div>


                    <!-- Applicant Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Applicant's Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">First name</label>
                                    <input type="text" name="applicant_first_name" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->applicant_first_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="applicant_last_name" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->applicant_last_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="applicant_middle_name" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->applicant_middle_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="applicant_suffix" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->applicant_suffix }}" 
                                           >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_No_1" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Contact_No_1 }}" 
                                           placeholder="Enter contact number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address1" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Address1 }}" 
                                           placeholder="Enter complete address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Driver's Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                            <div class="col-md-3">
                                    <label class="form-label">First name</label>
                                    <input type="text" name="driver_first_name" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->driver_first_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="driver_last_name" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->driver_last_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="driver_middle_name" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->driver_middle_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="driver_suffix" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->driver_suffix }}" 
                                           >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_No_2" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Contact_No_2 }}" 
                                           placeholder="Enter contact number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address_2" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Address_2 }}" 
                                           placeholder="Enter complete address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Motor Description -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Motor Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Body Number</label>
                                    <input type="text" name="Body_no" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Body_no }}" 
                                           placeholder="Enter body number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Plate Number</label>
                                    <input type="text" name="Plate_no" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Plate_no }}" 
                                           placeholder="Enter plate number">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Make/Model</label>
                                    <input type="text" name="Make" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Make }}" 
                                           placeholder="Enter make/model">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Engine Number</label>
                                    <input type="text" name="Engine_no" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Engine_no }}" 
                                           placeholder="Enter engine number">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Chassis Number</label>
                                    <input type="text" name="Chassis_no" 
                                           class="form-control" 
                                           value="{{ $PPFapplication->Chassis_no }}" 
                                           placeholder="Enter chassis number">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Submit Application <i class="fas fa-save me-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const ppfAssociations = [
        "Public Utility Jeep",
     "Public Utility Bus",
     "FX",
    ];

    const select = document.getElementById("ppfAssociationSelect");
    const currentValue = "{{ $PPFapplication->PPF_Association }}";

    ppfAssociations.forEach(association => {
        const option = new Option(association, association);
        if (association === currentValue) {
            option.selected = true;
        }
        select.add(option);
    });
</script>
@endsection