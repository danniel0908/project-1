<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schedule Details</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            text-align: center;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Schedule Details for User</h1>
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
</body>
</html>
