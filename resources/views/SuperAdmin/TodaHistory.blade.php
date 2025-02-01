
@extends('layouts.app')

@section('title', 'User List')

@section('content')
<div class="content-wrapper">


    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>History Logs</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Applicant Tables</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">


        <!-- Users Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Admin</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th>browser</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($history as $record)
                    <tr> 
                    <td>{{ $record->admin->name ?? 'Unknown Admin' }}</td>
                    <td>{{ $record->action == 'delete' ? 'Deleted' : 'Status Change' }}</td>
                    <td>{{ $record->new_status }}</td>
                    <td>{{ $record->browser }}</td>
                    <td>{{ $record->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </section>
</div>


@endsection
