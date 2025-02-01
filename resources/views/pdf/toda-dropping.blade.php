<!-- resources/views/pdf/toda-application.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>TODA Dropping</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .application-id {
            text-align: right;
            margin-bottom: 20px;
        }
        .section {
            margin-bottom: 20px;
        }
        .section-title {
            font-weight: bold;
            margin-bottom: 10px;
        }
        .field {
            margin-bottom: 10px;
        }
        .field-label {
            font-weight: bold;
        }
        .signature-section {
            margin-top: 50px;
        }
        .signature-line {
            border-top: 1px solid black;
            width: 200px;
            margin-top: 50px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>TODA Dropping Form</h2>
        <p>{{ $currentDate }}</p>
    </div>

    <div class="application-id">
        <p>Dropping ID: {{ $customId }}</p>
    </div>

    <div class="section">
        <div class="section-title">Operator Information</div>
        <div class="field">
            <span class="field-label">Name:</span>
            {{ $application->applicant_first_name }} 
            {{ $application->applicant_middle_name }} 
            {{ $application->applicant_last_name }}
            {{ $application->applicant_suffix }}
        </div>
        <div class="field">
            <span class="field-label">Contact Number:</span>
            {{ $application->Contact_no }}
        </div>
        <div class="field">
            <span class="field-label">Address:</span>
            {{ $application->Address }}
        </div>
        <div class="field">
            <span class="field-label">Validity Period:</span>
            {{ $application->Validity_Period }}
        </div>
        <div class="field">
            <span class="field-label">Case no:</span>
            {{ $application->Case_no }}
        </div>
        <div class="field">
            <span class="field-label">Reasons:</span>
            {{ $application->reasons }}
        </div>
    </div>

    
    <div class="section">
        <div class="section-title">Vehicle Information</div>
        <div class="field">
            <span class="field-label">Body Number:</span>
            {{ $application->Body_no }}
        </div>
        <div class="field">
            <span class="field-label">Plate Number:</span>
            {{ $application->Plate_no }}
        </div>
        <div class="field">
            <span class="field-label">Make:</span>
            {{ $application->Make }}
        </div>
        <div class="field">
            <span class="field-label">Engine Number:</span>
            {{ $application->Engine_no }}
        </div>
        <div class="field">
            <span class="field-label">Chassis Number:</span>
            {{ $application->Chassis_no }}
        </div>
    </div>

    <div class="signature-section">
        <div class="signature-line"></div>
        <p>Applicant's Signature</p>
    </div>
</body>
</html>