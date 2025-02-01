@extends('layouts.app')

@section('title')
Admin Dashboard
@endsection

@section('content')
<style>
    /* Custom Styling */
    .content-wrapper {
        background-color: #f4f6f9;
    }
    
    .card {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        border-radius: 8px;
    }
    
    .card-header {
        background-color: #007bff !important;
        border-top-left-radius: 8px;
        border-top-right-radius: 8px;
    }
    
    .nav-pills .nav-link {
        color: white;
        transition: all 0.3s ease;
    }
    
    .nav-pills .nav-link.active {
        background-color: rgba(255,255,255,0.2);
    }
    
    .nav-pills .nav-link:hover {
        background-color: rgba(255,255,255,0.1);
    }
    
    .form-label {
        font-weight: 600;
        color: #495057;
    }
    
    .table thead {
        background-color: #f8f9fa;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(0,123,255,0.075);
        transition: background-color 0.3s ease;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <section class="content">
        <div class="container-fluid p-4">
        {{-- Success and Error Messages --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        <div class="card mb-4">
    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Violators Management</h4>
        <div class="nav nav-pills" id="form-tabs" role="tablist">
            <a class="nav-link active" id="manual-entry-tab" data-toggle="tab" href="#manual-entry" role="tab">
                <i class="fas fa-edit me-1"></i> Manual Entry
            </a>
            <a class="nav-link" id="file-upload-tab" data-toggle="tab" href="#file-upload" role="tab">
                <i class="fas fa-upload me-1"></i> Bulk Upload
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content" id="form-tabs-content">
            {{-- Manual Entry Tab --}}
            <div class="tab-pane fade show active" id="manual-entry" role="tabpanel">
                <form action="{{ route('violators.store') }}" method="POST" class="needs-validation" novalidate>
                    @csrf
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="plate_number" class="form-label">Plate Number <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="plate_number" 
                                id="plate_number" 
                                class="form-control @error('plate_number') is-invalid @enderror" 
                                value="{{ old('plate_number') }}"
                                required
                                pattern="[A-Za-z0-9]+"
                                placeholder="Enter plate number"
                            >
                            @error('plate_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">Looks good!</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="violator_name" class="form-label">Violator Name <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="violator_name" 
                                id="violator_name" 
                                class="form-control @error('violator_name') is-invalid @enderror" 
                                value="{{ old('violator_name') }}"
                                required
                                placeholder="Full name"
                            >
                            @error('violator_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">Looks good!</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="violation_details" class="form-label">Violation Details <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="violation_details" 
                                id="violation_details" 
                                class="form-control @error('violation_details') is-invalid @enderror" 
                                value="{{ old('violation_details') }}"
                                required
                                placeholder="Details"
                            >
                            @error('violation_details')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">Looks good!</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-4 mb-3">
                            <label for="fee" class="form-label">Fee <span class="text-danger">*</span></label>
                            <input 
                                type="text" 
                                name="fee" 
                                id="fee" 
                                class="form-control @error('fee') is-invalid @enderror" 
                                value="{{ old('fee') }}"
                                required
                                placeholder="Enter fee amount"
                            >
                            @error('fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">Looks good!</div>
                            @enderror
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="violation_date" class="form-label">Violation Date <span class="text-danger">*</span></label>
                            <input 
                                type="date" 
                                name="violation_date" 
                                id="violation_date" 
                                class="form-control @error('violation_date') is-invalid @enderror" 
                                value="{{ old('violation_date') }}"
                                required
                            >
                            @error('violation_date')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @else
                                <div class="valid-feedback">Looks good!</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-3">
                        <button type="reset" class="btn btn-secondary me-2">
                            <i class="fas fa-undo me-1"></i> Reset
                        </button>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-plus-circle me-1"></i> Add Violator
                        </button>
                    </div>
                </form>
            </div>

            {{-- File Upload Tab --}}
            <div class="tab-pane fade" id="file-upload" role="tabpanel">
                <div class="alert alert-info" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    Upload an Excel or CSV file containing violator information. 
                    Ensure the file matches the expected format.
                </div>
                <form action="{{ route('violators.upload') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <label for="file" class="form-label">Excel or CSV File <span class="text-danger">*</span></label>
                            <div class="custom-file">
                                <input 
                                    type="file" 
                                    name="file" 
                                    id="file" 
                                    class="custom-file-input @error('file') is-invalid @enderror"
                                    accept=".csv, .xlsx, .xls"
                                    required
                                >
                                <label class="custom-file-label" for="file">Choose file...</label>
                                @error('file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-cloud-upload-alt me-1"></i> Upload File
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        
{{-- Violators Table --}}
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-md-6 bg-primary text-white d-flex justify-content-between align-items-center">
                        <h4>Violators List</h4>
                    </div>
                    <div class="col-md-6">
                        <form action="{{ route('violators.index') }}" method="GET" class="form-inline float-right">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="Search by plate, name, or details" 
                                       value="{{ request('search') }}">
                                <div class="input-group-append">
                                    <button class="btn btn-primary" type="submit">
                                        <i class="fa fa-search"></i> Search
                                    </button>
                                    <a href="{{ route('violators.index') }}" class="btn btn-secondary">
                                        <i class="fa fa-refresh"></i> Reset
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered table-hover">
                    <thead class="thead-light">
                        <tr>
                            <th>ID</th>
                            <th>Plate Number</th>
                            <th>Violator Name</th>
                            <th>Violation Details</th>
                            <th>Fee</th>
                            <th>Violation Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                        @forelse($violators as $violator)
                            <tr>
                                <td>{{ $i++ }}</td>
                                <td>{{ $violator->plate_number }}</td>
                                <td>{{ $violator->violator_name }}</td>
                                <td>{{ $violator->violation_details }}</td>
                                <td>{{ number_format($violator->fee, 2) }}</td>
                                <td>{{ $violator->violation_date->format('Y-m-d') }}</td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#editModal{{ $violator->id }}">
                                            Edit
                                        </button>
                                        @include('tmu.partials.edit-modal', ['violator' => $violator])

                                        <form action="{{ route('violators.destroy', $violator) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    @if(request('search'))
                                        No results found for "{{ request('search') }}".
                                    @else
                                        No violators found.
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                {{-- Pagination Links --}}
                <div class="mt-3 d-flex justify-content-center">
                    {{ $violators->appends(request()->input())->links() }}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

<script src="https://cdn.tailwindcss.com"></script>