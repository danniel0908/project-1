@extends('layouts.app')

@section('title')
PODA Dropping List
@endsection

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>PODA Dropping List</h1>
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
                                <form action="{{ route('PODAdropping.index') }}" method="GET">
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
                            <form id="uploadForm" action="{{ route('upload.excel-poda-dropping') }}" method="POST" enctype="multipart/form-data" class="d-flex align-items-center">
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
                                        <th>Contact No.</th>

                                        <td><br></td>
                                        <th>Status</th>
                                        <th>Progress</th>

                                        <th width="280px">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php $i = ($PODAdroppings->currentPage() - 1) * $PODAdroppings->perPage() + 1; ?>
                                    @foreach ($PODAdroppings as $PODAdropping)
                                    <tr>
                                        <td><a href="{{route('PODADropping.show', $PODAdropping->id)}}"style="font-weight: bold; font-size: 20px;">+</a></td>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $PODAdropping->applicants_name }}</td>
                                        <td>{{ $PODAdropping->contact_no }}</td>
                                        <td><br></td>
                                        <td>
                                            <form action="{{ route('PODAdropping.updateStatus', $PODAdropping->id) }}" method="POST">
                                                @method('PUT')
                                                @csrf

                                                <select name="status" class="form-control" onchange="this.form.submit()">
                                                    <option value="{{ $PODAdropping->status }}" selected>{{ ucfirst($PODAdropping->status) }}</option>
                                                    @foreach(['pending', 'approved', 'rejected'] as $option)
                                                        @if($option != $PODAdropping->status)
                                                            <option value="{{ $option }}">{{ ucfirst($option) }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </form>
                                        </td>
                                        <td>
                                            <div class="progress">
                                                <div class="progress-bar" role="progressbar" style="width: {{ $PODAdropping->progressPercentage }}%;" aria-valuenow="{{ $PODAdropping->progressPercentage }}" aria-valuemin="0" aria-valuemax="100">
                                                    {{ round($PODAdropping->progressPercentage, 2) }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <form action="{{ route('PODAdropping.PODAdestroy', $PODAdropping->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                @include('modals.delete_modal')
                                                <a class="btn btn-primary" href="{{ route('PODAdropping.edit',$PODAdropping->id) }}">Edit</a>
                                                <button type="button" class="btn btn-danger" onclick="showDeleteModal(this.form)">Delete</button>
                                            </form>
                                        </td>
                                    </tr>

                                    @endforeach
                                </tbody>
                            </table>
                            <div class="card-footer clearfix">
                                {{ $PODAdroppings->appends(request()->input())->links('pagination::bootstrap-4') }}
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
