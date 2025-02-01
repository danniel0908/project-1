<style>
    table {
        width: 100%;
        text-align: center;
        border-collapse: collapse;
    }
    th, td {
        border: 1px solid black;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }
</style>


@extends('layouts.app')

<title>Service Application</title>

@section('content')

<!-- /.content -->

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
                        <li class="breadcrumb-item active">Applicant Tables</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-12 margin-tb">
                            <div style="text-align: right;">
                                <a class="btn btn-primary" href="{{ route('ServiceApplication.index') }}"> Back</a>
                            </div>
                        </div>
                    </div>
                    <section class="content">
                        <h1>{{ $name }} Schedule</h1>
                        @if(session('error'))
                            <p>{{ session('error') }}</p>
                        @endif
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="2">Route</th>
                                    <th colspan="4">Time</th>
                                </tr>
                                <tr>
                                    <th>From</th>
                                    <th>To</th>
                                    <th colspan="2">AM</th>
                                    <th colspan="2">PM</th>
                                </tr>
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th>From</th>
                                    <th>To</th>
                                    <th>From</th>
                                    <th>To</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($schedules as $schedule)
                                    <tr>
                                        <td>{{ $schedule->route_from }}</td>
                                        <td>{{ $schedule->route_to }}</td>
                                        <td>{{ $schedule->am_time_from }}</td>
                                        <td>{{ $schedule->am_time_to }}</td>
                                        <td>{{ $schedule->pm_time_from }}</td>
                                        <td>{{ $schedule->pm_time_to }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No schedules found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </section>
                </div>
            </div>
        </div>
    </div>
    <!-- /.content -->
</div>



@endsection


