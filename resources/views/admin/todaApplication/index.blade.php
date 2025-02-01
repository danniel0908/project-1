<style>

th a {
        text-decoration: none;
        color: inherit;
        position: relative;
        display: inline-flex;
        align-items: center;
    }
    
    th a:hover {
        text-decoration: none;
        color: #007bff;
    }
    
    th a i {
        margin-left: 5px;
        font-size: 0.8em;
    }
    
    .fa-sort {
        opacity: 0.3;
    }
    
    .fa-sort-up, .fa-sort-down {
        opacity: 1;
    }
    .progress {
        height: 25px;
        background-color: #f0f0f0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
    }
    .progress-bar {
        height: 100%;
        background-color: #4CAF50;
        border-radius: 20px;
        transition: width 0.5s ease-in-out;
        position: relative;
    }
    .progress-bar::after {
        content: attr(data-percentage);
        position: absolute;
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: white;
        font-weight: bold;
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
    .progress-icon {
        margin-right: 10px;
        color: #4CAF50;
    }
    .loading-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 1000;
    }

    .loading-content {
        background: white;
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        width: 300px;
    }

    .spinner {
        border: 4px solid #f3f3f3;
        border-top: 4px solid #3498db;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        animation: spin 1s linear infinite;
        margin: 20px auto;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .upload-progress {
        width: 100%;
        background-color: #e0e0e0;
        padding: 3px;
        border-radius: 3px;
        margin: 15px 0;
        position: relative;
    }

    .progress-bar {
        width: 0%;
        height: 20px;
        background-color: #4CAF50;
        border-radius: 3px;
        transition: width 0.5s ease-in-out;
    }

    #progressText {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: black;
    }
    .modal-header {
            background-color: #007bff;
            color: white;
        }

        .icon-container-1 {
    width: 35px;
    height: 35px;
    display: flex;
    justify-content: center;
    align-items: center;
    background-color: #fc0c0c48;
    border-radius: 50%;

  }
  .icon-1  {
    width: 17px;
    height: 17px;
    color: #d10d0d;
  }


    .icon-container {
        width: 35px;
        height: 35px;
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #04e40048;
        border-radius: 50%;
    }
    .icon {
        width: 17px;
        height: 17px;
        color: #269b24;
    }
</style>
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

@extends('layouts.app')

@section('title')
TODA Application List
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1></h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">TODA Applicants</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- /.row -->
            <div class="row">
                <div class="col-12">
                    <div class="card">
                    @include('partials.alerts')
                        <div class="card-header">
                            <div class="card-tools">
                                <form action="{{ route('TODAapplication.index') }}" method="GET">
                                    <div class="input-group input-group-sm" style="width: 150px;">
                                        <input type="text" name="search" class="form-control float-right" placeholder="Search">
                                        <div class="input-group-append">
                                            <button type="submit" class="btn btn-default">
                                                <i class="fas fa-search"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <form id="uploadForm" action="{{ route('upload.excel-toda') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
                                @csrf
                                <div class="custom-file mr-3" style="max-width: 300px;">
                                    <input type="file" class="custom-file-input" id="excelFile" name="file" accept=".xlsx,.xls,.csv" required>
                                    <label class="custom-file-label" for="excelFile">Choose Excel file</label>
                                </div>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-upload mr-1"></i>Upload
                                </button>
                            </form>
                        </div>
                        <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div class="spinner"></div>
                    <p style="margin: 10px 0 0 0; color: #333;">Uploading files...</p>
                </div>
            </div>

                        <!-- Loading Overlay -->
                        <div id="loadingOverlay" class="loading-overlay" style="display:none;">
                            <div class="loading-content">
                                <div class="spinner"></div>
                                <div class="upload-progress">
                                    <div id="progressBar" class="progress-bar"></div>
                                    <span id="progressText">0%</span>
                                </div>
                                <p id="uploadStatus">Uploading...</p>
                            </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                
                            <thead>
    <tr>
        <th></th>
        <th>No.</th>
        <th>
            <a href="{{ route('TODAapplication.index', [
                'sort' => 'toda_association',
                'direction' => $sortField === 'toda_association' && $sortDirection === 'asc' ? 'desc' : 'asc',
                'search' => request('search')
            ]) }}" class="text-dark">
                TODA Association
                @if($sortField === 'toda_association')
                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                @else
                    <i class="fas fa-sort"></i>
                @endif
            </a>
        </th>
        <th>
            <a href="{{ route('TODAapplication.index', [
                'sort' => 'drivers_name',
                'direction' => $sortField === 'drivers_name' && $sortDirection === 'asc' ? 'desc' : 'asc',
                'search' => request('search')
            ]) }}" class="text-dark">
                Drivers name
                @if($sortField === 'drivers_name')
                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                @else
                    <i class="fas fa-sort"></i>
                @endif
            </a>
        </th>
        <th>
            <a href="{{ route('TODAapplication.index', [
                'sort' => 'contact',
                'direction' => $sortField === 'contact' && $sortDirection === 'asc' ? 'desc' : 'asc',
                'search' => request('search')
            ]) }}" class="text-dark">
                Contact#
                @if($sortField === 'contact')
                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                @else
                    <i class="fas fa-sort"></i>
                @endif
            </a>
        </th>
        <th>
            <a href="{{ route('TODAapplication.index', [
                'sort' => 'status',
                'direction' => $sortField === 'status' && $sortDirection === 'asc' ? 'desc' : 'asc',
                'search' => request('search')
            ]) }}" class="text-dark">
                Status
                @if($sortField === 'status')
                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                @else
                    <i class="fas fa-sort"></i>
                @endif
            </a>
        </th>
        <th>
            <a href="{{ route('TODAapplication.index', [
                'sort' => 'progress',
                'direction' => $sortField === 'progress' && $sortDirection === 'asc' ? 'desc' : 'asc',
                'search' => request('search')
            ]) }}" class="text-dark">
                Progress
                @if($sortField === 'progress')
                    <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down' }}"></i>
                @else
                    <i class="fas fa-sort"></i>
                @endif
            </a>
        </th>
        <th>Action</th>
        <th>ID</th>
        <th>Certificate</th>
    </tr>
</thead>
                                <tbody>
                                    <?php $i = ($TODAapplications->currentPage() - 1) * $TODAapplications->perPage() + 1; ?>

                                    @foreach ($TODAapplications as $TODAapplication)
                                    <tr>
                                        <td>
                                            <a href="{{ route('TODAapplication.show', $TODAapplication->id) }}" style="font-weight: bold; font-size: 20px;">+</a>
                                        </td>

                                        <td>{{ $i++ }}</td>
                                        <td>{{ $TODAapplication->TODA_Association }}</td>
                                        <td>{{ $TODAapplication->Drivers_name }}</td>
                                        <td>{{ $TODAapplication->Contact_No_2 }}</td>
                                        <td>
                                            <form action="{{ route('TODAapplication.updateStatus', $TODAapplication->id) }}" method="POST" id="statusForm">
                                                @method('PUT')
                                                @csrf
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="{{ $TODAapplication->Status }}" selected>{{ ucfirst($TODAapplication->Status) }}</option>
                                                    @foreach(['pending', 'approved', 'rejected'] as $option)
                                                        @if($option != $TODAapplication->Status)
                                                            <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $TODAapplication->progressPercentage }}%;" aria-valuenow="{{ $TODAapplication->progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($TODAapplication->progressPercentage, 2) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                        <form action="{{ route('TODAapplication.destroy',$TODAapplication->id) }}" method="POST" class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-primary" href="{{ route('TODAapplication.edit',$TODAapplication->id) }}">Edit</a>
                                            <button type="button" class="btn btn-danger" onclick="showDeleteModal(this.form)">Delete</button>
                                        </form>
                                        </td>
                                        <td>
                                        <a class="btn btn-primary" href="{{ route('generate.toda.id',$TODAapplication->id) }}">print</a>
                                        </td>

                                        <td>
                                        <a class="btn btn-primary" href="{{ route('generate.toda.cerf',$TODAapplication->id) }}">print</a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <!-- After your table -->
                            <div class="card-footer clearfix">
                                {{ $TODAapplications->appends(request()->input())->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
            </div>
            <!-- /.row -->
            <!-- /.row -->
        </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
</div>


<script>
document.getElementById('excelFile').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerHTML = fileName;
});
</script>




<script>
document.getElementById('excelFile').addEventListener('change', function(e) {
    var fileName = e.target.files[0].name;
    var nextSibling = e.target.nextElementSibling;
    nextSibling.innerHTML = fileName;
});
function showModal() {
            const modal = new bootstrap.Modal(document.getElementById('smsModal'));
            modal.show();
        }

   // JavaScript to toggle visibility of the message container
   document.getElementById('addMessageLink').addEventListener('click', function () {
        const messageContainer = document.getElementById('messageContainer');
        if (messageContainer.style.display === 'none') {
            messageContainer.style.display = 'block';
        } else {
            messageContainer.style.display = 'none';
        }
    });

    function removeFields() {
        var statusContainer = document.querySelector('.status-container');
        var statusInput = document.getElementById('status');
    
    // Toggle visibility
    if (statusContainer.style.display === "none") {
        statusContainer.style.display = "block";  // Show the fields
    } else {
        statusContainer.style.display = "none";  // Hide the fields
        statusInput.value = ""; // Clear the status field
    }
}
</script>


@endsection




