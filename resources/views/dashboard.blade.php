
@extends('users.layout')

@section('content')
@include('users.privacyNotice')

<div class="dashboard-body" id="dashboardBody">
    <div class="dashboard-container">
        <header class="header-1">
            <div class="main-dashboard">
                <h1>Dashboard</h1>
            </div>
            <div class="secondary-dashboard">
                <a href="#" class="dashboard-link">Dashboard</a>
            </div>
        </header>
            @if(!empty($violations) && $violations->isNotEmpty())
                <div class="alert alert-warning alert-dismissible fade show d-flex align-items-center" role="alert" style="border-left: 5px solid #ffc107; padding: 1.25rem; background-color: #fff9e6;">
                    <div>
                        <strong>⚠ Attention!</strong> You have existing traffic violations:
                        <ul style="margin-top: 0.5rem;">
                            @foreach($violations as $violation)
                                <li>
                                    <strong>Plate Number:</strong> {{ $violation->plate_number }}  
                                    <br>
                                    <strong>Violation:</strong> {{ $violation->violation_details }}  
                                    <br>
                                    <strong>Fee:</strong> ₱{{ number_format($violation->fee, 2) }}
                                </li>
                            @endforeach
                        </ul>
                        <p class="mt-2" style="font-size: 0.9rem;">
                            Please address these violations before your application can be approved.
                        </p>
                    </div>
                </div>
            @endif
        <section class="content">
            <div class="border">
                <div class="current-time">
                    <h2>Current Time</h2>
                    <p>
                        <div class="date" id="time"></div>
                    </p>
                </div>
            </div>
            <div class="application-status">
                <h2>Application Status</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Service</th>
                            <th>Applicant ID</th>
                            <th>Date Filed</th>
                            <th>Driver's Name</th>
                            <th>Status</th>
                            <th>Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($noApplications)
                            <tr><td colspan="6">No application found</td></tr>
                        @else
                            {{-- TODA Application --}}
                            @forelse ($applications['TODAapplications'] as $application)
                                @include('partials.application-row', [
                                    'application' => $application, 
                                    'serviceName' => 'TODA Application', 
                                    'editRoute' => 'toda.edit'
                                ])
                            @empty
                            @endforelse

                            {{-- PODA Application --}}
                            @forelse ($applications['PODAapplications'] as $application)
                                @include('partials.application-row', [
                                    'application' => $application, 
                                    'serviceName' => 'PODA Application', 
                                    'editRoute' => 'poda.edit'
                                ])
                            @empty
                            @endforelse

                            {{-- Sticker Application --}}
                            @forelse ($applications['PPFapplications'] as $application)
                                @include('partials.application-row', [
                                    'application' => $application, 
                                    'serviceName' => 'Sticker Application', 
                                    'editRoute' => 'sticker.edit',
                                    'additionalId' => $application->PPF_Association
                                ])
                            @empty
                            @endforelse

                            {{-- Private Service Application --}}
                            @forelse ($applications['ServiceApplications'] as $application)
                                @include('partials.application-row', [
                                    'application' => $application, 
                                    'serviceName' => 'Private Service Application', 
                                    'editRoute' => 'service.edit'
                                ])
                            @empty
                            @endforelse

                            {{-- TODA Dropping --}}
                            @forelse ($applications['TODAdropping'] as $application)
                                @include('partials.application-row', [
                                    'application' => $application, 
                                    'serviceName' => 'TODA Dropping', 
                                    'editRoute' => 'todadrop.edit',
                                    'driverName' => $application->operator_name,
                                    'statusField' => 'status'
                                ])
                            @empty
                            @endforelse

                            {{-- PODA Dropping --}}
                            @forelse ($applications['PODAdropping'] as $application)
                                @include('partials.application-row', [
                                    'application' => $application, 
                                    'serviceName' => 'PODA Dropping', 
                                    'editRoute' => 'podadrop.edit',
                                    'driverName' => $application->operator_name,
                                    'statusField' => 'status'
                                ])
                            @empty
                            @endforelse
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
    @include('users.footer')
</div>

<script>
function showRemarks(remarks) {
    Swal.fire({
        title: 'Remarks',
        html: remarks.replace(/\n/g, '<br>'),
        icon: 'warning',
        confirmButtonText: 'Close',
        confirmButtonColor: '#dc3545',
        customClass: {
            container: 'remarks-popup',
            content: 'remarks-content'
        }
    });
}
</script>
@endsection