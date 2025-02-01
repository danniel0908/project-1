@extends('layouts.app')

@section('title')
TODA Dropping List
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>TODA Dropping list</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Dropping Tables</li>
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
                                <form action="{{ route('TODADropping.index') }}" method="GET">
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
                            <form id="uploadForm" action="{{ route('upload.excel-toda-dropping') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
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
                                        <th>Operator Name</th>
                                        <th>Contact#</th>
                                        <th>Status</th>
                                        <th>Progress</th>
                                        <th>Action</th>
                                        <th>Certificate</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = ($TODAdroppings->currentPage() - 1) * $TODAdroppings->perPage() + 1; ?>
                                    @foreach ($TODAdroppings as $TODAdropping)
                                    <tr>
                                        <td><a href="{{route('TODADropping.show', $TODAdropping->id)}}" style="font-weight: bold; font-size: 20px;">+</a></td>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $TODAdropping->applicants_name }}</td>
                                        <td>{{ $TODAdropping->contact_no }}</td>

                                        <td>
                                            <form action="{{ route('TODADropping.updateStatus', $TODAdropping->id) }}" method="POST" id="statusForm">
                                                @method('PUT')
                                                @csrf
                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="{{ $TODAdropping->status }}" selected>{{ ucfirst($TODAdropping->status) }}</option>
                                                    @foreach(['pending', 'approved', 'rejected'] as $option)
                                                        @if($option != $TODAdropping->status)
                                                            <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $TODAdropping->progressPercentage }}%;" aria-valuenow="{{ $TODAdropping->progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($TODAdropping->progressPercentage, 2) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('TODADropping.TODAdestroy', $TODAdropping->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                @include('modals.delete_modal')
                                                <a class="btn btn-primary" href="{{ route('TODADropping.edit',$TODAdropping->id) }}">Edit</a>
                                                <button type="button" class="btn btn-danger" onclick="showDeleteModal(this.form)">Delete</button>
                                            </form>
                                        </td>

                                        <td>
                                            <a class="btn btn-primary" href="{{ route('generate.toda.id',$TODAdropping->id) }}">print</a>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer clearfix">
                                {{ $TODAdroppings->appends(request()->input())->links('pagination::bootstrap-4') }}
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
