<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Pagpapatunay</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            margin: 30px;
            line-height: 1.6;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo {
            max-width: 100px;
            margin-bottom: 20px;
        }
        .title {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .content {
            margin-bottom: 30px;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .requirements-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .requirements-table th,
        .requirements-table td {
            padding: 8px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="header">
        @if($logo_data)
            <img src="{{ $logo_data }}" class="logo">
        @endif
        <div class="title">PAGPAPATUNAY</div>
    </div>

    <div class="content">
        <p>Ito ay nagpapatunay na si {{ $applicant_name }} na may ID Number {{ $custom_id }} ay isang Service na may pangalan na "{{ $service_name }}"<p>

        <table class="info-table">
            <tr>
                <td><strong>ID Number:</strong></td>
                <td>{{ $custom_id }}</td>
            </tr>
            <tr>
                <td><strong>Pangalan ng Aplikante:</strong></td>
                <td>{{ $applicant_name }}</td>
            </tr>
            <tr>
                <td><strong>Pangalan ng Drayber:</strong></td>
                <td>{{ $driver_name }}</td>
            </tr>
            <tr>
                <td><strong>Address:</strong></td>
                <td>{{ $address }}</td>
            </tr>
            <tr>
                <td><strong>Contact Number:</strong></td>
                <td>{{ $contact_no }}</td>
            </tr>
        </table>

        <h3>Mga Naaprubahang Dokumento</h3>
        <table class="requirements-table">
            <thead>
                <tr>
                    <th>Uri ng Dokumento</th>
                    <th>Petsa ng Pag-apruba</th>
                    <th>Inaprubahan ni</th>
                </tr>
            </thead>
            <tbody>
                @foreach($requirements as $requirement)
                <tr>
                    <td>{{ $requirement['type'] }}</td>
                    <td>{{ $requirement['approved_at'] }}</td>
                    <td>{{ $requirement['approved_by'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="footer">
        <p>Inisyu ngayong {{ $issue_date }}</p>
        <div style="margin-top: 50px;">
            <p>_________________________</p>
            <p>Pirma ng Authorized Personnel</p>
        </div>
    </div>
</body>
</html>