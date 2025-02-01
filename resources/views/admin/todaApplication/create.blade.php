@extends('layouts.app')

@section('title')
New TODA Application
@endsection

@section('content')
<div class="content-wrapper bg-light">
    <div class="container-fluid py-4">
        <div class="card shadow-sm">

            <div class="card-header bg-white py-3">
                <div class="d-flex justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb mb-0">
                            <li class="breadcrumb-item"><a href="{{ route('TODAapplication.index') }}" class="text-decoration-none">Back to List</a></li>
                            <li class="breadcrumb-item active">Create TODA Application</li>
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

                <form action="{{ route('TODAapplication.store') }}" method="POST">
                    @csrf

                    <!-- TODA Association -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">TODA Association</label>
                        <select id="todaAssociationSelect" name="TODA_Association" 
                                class="form-select" required>
                            <option value="">Select TODA Association</option>
                        </select>
                    </div>

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
                                           value="{{ old('applicant_first_name') }}" 
                                           required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="applicant_middle_name" id="applicant_middle_name"
                                           class="form-control" 
                                           value="{{ old('applicant_middle_name') }}" 
                                           >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="applicant_last_name" id="applicant_last_name"
                                           class="form-control" 
                                           value="{{ old('applicant_last_name') }}" 
                                            required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="applicant_suffix" id="applicant_suffix"
                                           class="form-control" 
                                           value="{{ old('applicant_suffix') }}" 
                                           >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_No_1" id="applicant_contact"
                                           class="form-control" 
                                           value="{{ old('Contact_No_1') }}" 
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address1" id="applicant_address"
                                           class="form-control" 
                                           value="{{ old('Address1') }}" 
                                            required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Driver Information -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title mb-0">Driver's Information</h5>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="sameAsApplicant">
                                    <label class="form-check-label text-white" for="sameAsApplicant">
                                        Same as Applicant
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <label class="form-label">First Name</label>
                                    <input type="text" name="driver_first_name" id="driver_first_name"
                                           class="form-control" 
                                           value="{{ old('driver_first_name') }}" 
                                           required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="driver_middle_name" id="driver_middle_name"
                                           class="form-control" 
                                           value="{{ old('driver_middle_name') }}" 
                                           >
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="driver_last_name" id="driver_last_name"
                                           class="form-control" 
                                           value="{{ old('driver_last_name') }}" 
                                            required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="driver_suffix" id="driver_suffix"
                                           class="form-control" 
                                           value="{{ old('driver_suffix') }}" 
                                           >
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_No_2" id="driver_contact"
                                           class="form-control" 
                                           value="{{ old('Contact_No_2') }}" 
                                            required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address_2" id="driver_address"
                                           class="form-control" 
                                           value="{{ old('Address_2') }}" 
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
                                           value="{{ old('Body_no') }}" 
                                            required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Plate Number</label>
                                    <input type="text" name="Plate_no" 
                                           class="form-control" 
                                           value="{{ old('Plate_no') }}" 
                                            required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Make/Model</label>
                                    <input type="text" name="Make" 
                                           class="form-control" 
                                           value="{{ old('Make') }}" 
                                            required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Engine Number</label>
                                    <input type="text" name="Engine_no" 
                                           class="form-control" 
                                           value="{{ old('Engine_no') }}" 
                                            required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Chassis Number</label>
                                    <input type="text" name="Chassis_no" 
                                           class="form-control" 
                                           value="{{ old('Chassis_no') }}" 
                                            required>
                                </div>
                            </div>
                        </div>
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

<script>
// TODA Associations
const todaAssociations = [
    "ACRHOTODA", "AMPCHOSJTODA", "BCTODA", "CVTODA", "DHAPATTODA",
    "LAFITTODA", "PACTODA", "PCHAITODA", "PIGGERYTODA", "RJCTODA",
    "RUNSTODA", "SASTODA", "SAWESTVTODA", "SEPAGCOTODA", "SKLTODA",
    "SPVHTODA", "SPDOTA", "SRCOTODA", "STLTPDA", "SCSPTODA"
];

const select = document.getElementById("todaAssociationSelect");
todaAssociations.forEach(association => {
    const option = new Option(association, association);
    select.add(option);
});


// Auto-fill functionality
document.getElementById('sameAsApplicant').addEventListener('change', function() {
    if (this.checked) {
        // Copy values from applicant fields to driver fields
        document.getElementById('driver_first_name').value = document.getElementById('applicant_first_name').value;
        document.getElementById('driver_middle_name').value = document.getElementById('applicant_middle_name').value;
        document.getElementById('driver_last_name').value = document.getElementById('applicant_last_name').value;
        document.getElementById('driver_suffix').value = document.getElementById('applicant_suffix').value;
        document.getElementById('driver_contact').value = document.getElementById('applicant_contact').value;
        document.getElementById('driver_address').value = document.getElementById('applicant_address').value;
        
        // Make driver fields readonly
        ['first_name', 'middle_name', 'last_name', 'suffix', 'contact', 'address'].forEach(field => {
            document.getElementById('driver_' + field).readOnly = true;
        });
    } else {
        // Clear and enable driver fields
        ['first_name', 'middle_name', 'last_name', 'suffix', 'contact', 'address'].forEach(field => {
            const element = document.getElementById('driver_' + field);
            element.value = '';
            element.readOnly = false;
        });
    }
});

// Update driver fields when applicant fields change (if checkbox is checked)
['first_name', 'middle_name', 'last_name', 'suffix', 'contact', 'address'].forEach(field => {
    document.getElementById('applicant_' + field).addEventListener('input', function() {
        if (document.getElementById('sameAsApplicant').checked) {
            document.getElementById('driver_' + field).value = this.value;
        }
    });
});
</script>
@endsection