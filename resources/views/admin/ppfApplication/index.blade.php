@extends('layouts.app')

@section('title')
PPF Application List
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>PUJ/PUB/FX Applicants</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Applicant Tables</li>
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
                        <div class="card-header">
                        @include('partials.alerts')
                            <div class="card-tools">
                                <form action="{{ route('PPFapplication.index') }}" method="GET">
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
                            <form id="uploadForm" action="{{ route('upload.excel-sticker') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
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
                        <!-- /.card-header -->
                        <div class="card-body table-responsive p-0">
                            <table class="table table-hover text-nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>No.</th>
                                        <th>Type</th>
                                        <th>Applicant's name</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Action</th>
                                        <th>ID</th>
                                        <th>Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = ($PPFapplications->currentPage() - 1) * $PPFapplications->perPage() + 1; ?>
                                    @foreach ($PPFapplications as $PPFapplication)
                                    <tr>
                                        <td><a href="{{route('PPFapplication.show', $PPFapplication->id)}}" style="font-weight: bold; font-size: 20px;">+</a></td>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $PPFapplication->PPF_Association }}</td>
                                        <td>{{ $PPFapplication->Applicants_name }}</td>
                                        <td>{{ $PPFapplication->Contact_No_1 }}</td>
                                        <td>

                                            <form action="{{ route('PPFapplication.updateStatus', $PPFapplication->id) }}" method="POST" id="statusForm">
                                                @method('PUT')
                                                @csrf
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="{{ $PPFapplication->Status }}" selected>{{ ucfirst($PPFapplication->Status) }}</option>
                                                    @foreach(['pending', 'approved', 'rejected'] as $option)
                                                        @if($option != $PPFapplication->Status)
                                                            <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $PPFapplication->progressPercentage }}%;" aria-valuenow="{{ $PPFapplication->progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($PPFapplication->progressPercentage, 2) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('PPFapplication.destroy', $PPFapplication->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                @include('modals.delete_modal')
                                                <a class="btn btn-primary" href="{{ route('PPFapplication.edit', $PPFapplication->id) }}">Edit</a>
                                                <button type="button" class="btn btn-danger" onclick="showDeleteModal(this.form)">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer clearfix">
                                {{ $PPFapplications->appends(request()->input())->links('pagination::bootstrap-4') }}
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


@endsection
