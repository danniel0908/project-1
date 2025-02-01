
@extends('layouts.app')

@section('title')
TODA Dropping Application
@endsection

@section('content')
<div class="content-wrapper bg-light">
    <div class="container-fluid py-4">
        <div class="card shadow-sm">

            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('TODADropping.index') }}" class="text-decoration-none">Back to List</a></li>
                            <li class="breadcrumb-item active">TODA Dropping Application</li>
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

                <form action="{{ route('TODADropping.update',$TODAdropping->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Applicant Information -->
                    <div class="card mb-4" id="applicantFields">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Applicant's Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="applicant_first_name" id="applicant_first_name"
                                           class="form-control" 
                                           value="{{ $TODAdropping->applicant_first_name  }}" 
                                           required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="applicant_middle_name" id="applicant_middle_name"
                                           class="form-control" 
                                           value="{{ $TODAdropping->applicant_middle_name  }}" 
                                           >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="applicant_last_name" id="applicant_last_name"
                                           class="form-control" 
                                           value="{{ $TODAdropping->applicant_last_name  }}" 
                                            required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="applicant_suffix" id="applicant_suffix"
                                           class="form-control" 
                                           value="{{ $TODAdropping->applicant_suffix  }}" 
                                           >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_no" id="Contact_no"
                                           class="form-control" 
                                           value="{{ $TODAdropping->contact_no  }}" 
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address" id="Address"
                                           class="form-control" 
                                           value="{{ $TODAdropping->address  }}" 
                                            required>
                                </div>
                            </div>
                        </div>
                    </div> 

                    <!-- franchise info -->

                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Franchise Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label">Validity Period</label>
                                    <input type="text" name="Validity_Period" 
                                           class="form-control" 
                                           value="{{ $TODAdropping->validity_period  }}" 
                                            required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Case no</label>
                                    <input type="text" name="Case_no" 
                                           class="form-control" 
                                           value="{{ $TODAdropping->case_no  }}" 
                                            required>
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
                                           value="{{ $TODAdropping->body_no}}" 
                                            required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Plate Number</label>
                                    <input type="text" name="Plate_no" 
                                           class="form-control" 
                                           value="{{ $TODAdropping->plate_no  }}" 
                                            required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Make/Model</label>
                                    <input type="text" name="Make" 
                                           class="form-control" 
                                           value="{{ $TODAdropping->make  }}" 
                                            required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Engine Number</label>
                                    <input type="text" name="Engine_no" 
                                           class="form-control" 
                                           value="{{ $TODAdropping->engine_no  }}" 
                                            required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Chassis Number</label>
                                    <input type="text" name="Chassis_no" 
                                           class="form-control" 
                                           value="{{ $TODAdropping->chassis_no  }}" 
                                            required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Driver's Reason</h5>
                        </div>
                        <textarea name="reasons" 
                                id="reasons"
                                class="form-control" 
                                rows="4"
                                placeholder="Enter reason here">{{ $TODAdropping->reasons  }}</textarea>
                    </div>
                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Submit Application <i class="fas fa-save ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection