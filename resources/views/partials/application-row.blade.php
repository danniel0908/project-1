
@php
    $statusClass = '';
    $statusValue = $statusField ?? 'Status';
    $status = strtolower($application->{$statusValue});
    
    switch ($status) {
        case 'rejected':
            $statusClass = 'status-rejected';
            break;
        case 'approved':
            $statusClass = 'status-approved';
            break;
        case 'pending':
            $statusClass = 'status-pending';
            break;
    }

    $driverName = $application->Drivers_name ?: $application->applicants_name;
@endphp

<tr>
    <td data-label="Service">
        <a href="{{ route($editRoute, $application->id) }}" style="color: black; text-decoration: none;">
            <p class="label"><i class="fa-solid fa-pen-to-square"></i> {{ $serviceName }}</p>
        </a>
    </td>
    <td data-label="Applicant ID">
        {{ $application->custom_id }}
        @if(isset($additionalId))
            <br>
            {{ $additionalId }}
        @endif
    </td>
    <td data-label="Date Filed">{{ $application->created_at->format('F d, Y') }}</td>
    <td data-label="Driver's Name">{{ $driverName }}</td>
    <td data-label="Status" class="{{ $statusClass }}">{{ $application->{$statusValue} }}</td>
    <td data-label="Remarks" class="text-center">
    @if(!empty($application->remarks))
        <div style="display: flex; flex-direction: column; align-items: center;">
            <i class="fas fa-exclamation-triangle remarks-icon" 
                style="color: #ffc107; font-size: 1.5em;"
                onclick="showRemarks('{{ addslashes($application->remarks) }}')"
                title="Click to view remarks">
            </i>
            <span style="font-size: 0.7em;">Click!</span>
        </div>
    @else
        <span class="text-muted">N/A</span>
    @endif
</td>
</tr>