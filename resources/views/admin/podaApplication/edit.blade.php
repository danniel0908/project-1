@extends('layouts.app')

@section('title')
PODA Application Edit
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
                            <li class="breadcrumb-item"><a href="{{ route('PODAapplication.index') }}" class="text-decoration-none">Back to List</a></li>
                            <li class="breadcrumb-item active">Edit PODA Application</li>
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

                <form action="{{ route('PODAapplication.update', $PODAapplication->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- PODA Association -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">PODA Association</label>
                        <select id="podaAssociationSelect" name="PODA_Association" class="form-select">
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
                                           value="{{ $PODAapplication->applicant_first_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="applicant_last_name" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->applicant_last_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="applicant_middle_name" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->applicant_middle_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="applicant_suffix" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->applicant_suffix }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_No_1" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Contact_No_1 }}" 
                                           placeholder="Enter contact number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address1" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Address1 }}" 
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
                                           value="{{ $PODAapplication->driver_first_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Last Name</label>
                                    <input type="text" name="driver_last_name" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->driver_last_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Middle Name</label>
                                    <input type="text" name="driver_middle_name" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->driver_middle_name }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label">Suffix</label>
                                    <input type="text" name="driver_suffix" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->driver_suffix }}" 
                                           placeholder="Enter applicant's full name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Contact Number</label>
                                    <input type="tel" name="Contact_No_2" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Contact_No_2 }}" 
                                           placeholder="Enter contact number">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Complete Address</label>
                                    <input type="text" name="Address_2" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Address_2 }}" 
                                           placeholder="Enter complete address">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pedicab Description -->
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="card-title mb-0">Pedicab Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Sticker Number</label>
                                    <input type="text" name="Sticker_no" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Sticker_no    }}" 
                                           placeholder="Enter Sticker number" required>
                                </div>
                                <div class="col-md-6">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit 1</label>
                                    <input type="text" name="Unit_no1" class="form-control"value="{{ $PODAapplication->Unit_no1 }}"   placeholder="Unit_no1">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit 2</label>
                                    <input type="text" name="Unit_no2" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Unit_no2 }}" 
                                            >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit 3</label>
                                    <input type="text" name="Unit_no3" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Unit_no3 }}" 
                                            >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit 4</label>
                                    <input type="text" name="Unit_no4" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Unit_no4 }}" 
                                            >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit 5</label>
                                    <input type="text" name="Unit_no5" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Unit_no5 }}" 
                                            >
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Unit 6</label>
                                    <input type="text" name="Unit_no6" 
                                           class="form-control" 
                                           value="{{ $PODAapplication->Unit_no6 }}"  
                                            >
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Update Application <i class="fas fa-save me-2"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    const podaAssociations = [
        "SSPODA",
        "RRPODA",
        "TTPODA",
    ];

    const select = document.getElementById("podaAssociationSelect");
    const currentValue = "{{ $PODAapplication->PODA_Association }}";

    podaAssociations.forEach(association => {
        const option = new Option(association, association);
        if (association === currentValue) {
            option.selected = true;
        }
        select.add(option);
    });
</script>
@endsection