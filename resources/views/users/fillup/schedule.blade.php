<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Private Service Application</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: "Source Sans Pro", "apple-system", BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
            background-image: url("assets/img/capitol.jpg");
            background-size: cover;
            background-repeat: no-repeat;
        }

        .left {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 500px;
        }
        .right {
            margin-right: 80px;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #004d00;
            color: white;
            position: relative;
            z-index: 1000;
        }
        .header img {
            width: 40px;
            cursor: pointer;
        }
        .header .left, .header .right {
            display: flex;
            align-items: center;
        }
        .header .right a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
        }
        .header .right a i {
            font-size: 1.2em;
        }
        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            margin-top: 50px;
        }

        .sidebar {
            width: 25%;
            padding: 20px;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
        }

        .profile-pic {
            text-align: center;
            margin-bottom: 20px;
        }

        .profile-pic img {
            border-radius: 50%;
            width: 250px;
            height: 250px;
            cursor: pointer;
        }

        .custom-file-upload {
            display: inline-block;
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            margin-top: 25px;
            background-color: #004d00;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        .custom-file-upload:hover {
            background-color: #004d00;
        }
        button {
            display: inline-block;
            width: 95%;
            padding: 10px;
            margin-bottom: 20px;
            margin-top: 25px;
            background-color: #004d00;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }
        button:hover {
            background-color: #004d00;
        }
        .button-style {
            display: inline-block;
            width: 80%;
            padding: 10px 10px 9px 10px;
            margin-bottom: 20px;
            margin-top: 25px;
            background-color: #004d00;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
        }

        #fileInput1, #fileInput2, #fileInput3, #fileInput4 {
            display: none;
        }

        #uploadedImage1, #uploadedImage2, #uploadedImage3, #uploadedImage4 {
            display: none;
            width: 50px;
            height: 50px;
            border-radius: 35px;
            cursor: pointer;
            margin-left: 50px;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            margin: 10px 0;
            font-size: 1.1em;
        }
        nav ul li a {
            text-decoration: none;
        }
        nav ul li a:hover {
            text-decoration: underline;
        }

        .main-content {
            width: 75%;
            padding: 20px;
        }
        th, td {
        border: 1px solid black;
        padding: 8px;
    }
    th {
        background-color: #f2f2f2;
    }

        h1 {
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        thead th {
            background-color: #004d00;
            color: #fff;
            padding: 10px;
        }

        tbody td {
            padding: 10px;
            border: 1px solid #ddd;
        }

        p {
            color: #555;
        }

        form {
            display: flex;
            flex-wrap: wrap;
            padding: 20px;
        }

        .form-group {
            flex: 1 1 100%;
            margin-bottom: 15px;
        }

        .form-group.half {
            flex: 1 1 48%;
            margin-right: 2%;
        }

        .form-group.half:last-child {
            margin-right: 0;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            background-color: rgb(238, 233, 233);
            color: black;
            font-size: 16px;
            font-family: "Source Sans Pro", "apple-system", BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        @media (max-width: 768px) {
            .form-group.half {
                flex: 1 1 100%;
                margin-right: 0;
            }

            .header {
                flex-direction: column;
                text-align: center;
            }

            .header .left, .header .right {
                justify-content: center;
            }

            .right {
                margin-right: 0;
            }
            .container {
                flex-direction: column;
            }

            .sidebar, .main-content {
                width: 90%;
            }

            .sidebar {
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
            #uploadedImage1, #uploadedImage2, #uploadedImage3, #uploadedImage4 {
                display: none;
                width: 50px;
                height: 50px;
                border-radius: 35px;
                cursor: pointer;
                margin-left: 20px;
            }
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body>
    <div class="header">
        <div class="left">
            <img src="{{ asset('landing/assets/img/tru-picture.png') }}" alt="sign up image" style="width: 75px; height: 75px;">

            <h3>POSO-TRU San Pedro, Laguna</h3>
        </div>
        <div class="right">
            <a href="{{ route('dashboard') }}">Home</a>
            {{-- <a href="#">Profile</a>
            <a href="#">Logout</a> --}}
        </div>
    </div>

    <div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; margin-top: 20px;">
        <div class="container">
            <div class="sidebar">
                <label for="file-upload" class="custom-file-upload">
                    Private Service Permit Application
                    @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Error!</strong><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                </label>
                <input type="file" id="file-upload" style="display: none;">
                <nav>
                    <ul>
                    <li>
                        <a href="{{ route('service.edit', ['id' => $serviceApplicationId]) }}" style="color: #004d00;">
                            1.) Personal Information
                        </a>
                    </li>
                        
                        <li>
                            <a href="{{ route('schedule.create', ['serviceApplicationId' => $serviceApplicationId]) }}"
                            style="color: #004d00;">2.) Schedule</a>
                        </li>                    

                        <li><a href="{{ route('service.upload', ['service_application_id' => $serviceApplication->id]) }}" style="color: #004d00;">3.) Requirements</a></li>
                        <li>
                        @php
                            $approvedRequirementsCount = \App\Models\privateServiceRequirements::where('private_service_id', $serviceApplication->id)
                                ->where('requirement_type', '!=', 'Official_receipt')
                                ->where('status', 'approved')
                                ->count();

                            $hasAllRequirementsApproved = $approvedRequirementsCount === 8;
                        @endphp

                        @if($hasAllRequirementsApproved)
                            <a href="{{ route('service.payment', ['id' => $serviceApplication->id]) }}" 
                                style="color: #004d00;">3. Payment Receipt</a>
                        @else
                            <span style="color: #808080; cursor: not-allowed;" 
                                title="You need exactly 6 approved requirements before accessing the payment receipt">
                                3. Payment Receipt <br>
                                (@if($approvedRequirementsCount < 8)
                                    {{ 8 - $approvedRequirementsCount }} more requirement(s) needed
                                @else
                                    Verified
                                @endif)
                            </span>
                        @endif
                    </li>   
                    </ul>
                </nav>

            </div>
            <div class="main-content">
                <div id="personal-info" class="form-section">
                    <h1 style="color: #004d00; border-bottom: 1px solid rgb(207, 207, 207); padding-left: 20px; padding-bottom: 20px;">Private Service Schedule</h1>
                    <form action="{{ route('schedule.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="service_application_id" value="{{ $serviceApplicationId }}">
                        <div class="form-group">
                            <label for="route_from">Route From</label>
                            <input type="text" id="route_from" name="route_from[]" required>
                            
                        </div>

                        <div class="form-group">
                            <label for="route_to">Route To</label>
                            <input type="text" id="route_to" name="route_to[]" required>
                        </div>

                        <div class="form-group">
                            <label for="am_time_from">AM Time From</label>
                            <input type="time" id="am_time_from" name="am_time_from[]" required>
                        </div>

                        <div class="form-group">
                            <label for="am_time_to">AM Time To</label>
                            <input type="time" id="am_time_to" name="am_time_to[]" required>
                        </div>

                        <div class="form-group">
                            <label for="pm_time_from">PM Time From</label>
                            <input type="time" id="pm_time_from" name="pm_time_from[]" required>
                        </div>

                        <div class="form-group">
                            <label for="pm_time_to">PM Time To</label>
                            <input type="time" id="pm_time_to" name="pm_time_to[]" required>
                        </div>

                        <button type="submit">Submit Schedule</button>
                    </form>

                </div>
                <section class="content">
                    <h1>Schedule</h1>
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
                                <tr data-id="{{ $schedule->id }}">
                                    <td class="editable" data-field="route_from">{{ $schedule->route_from }}</td>
                                    <td class="editable" data-field="route_to">{{ $schedule->route_to }}</td>
                                    <td class="editable" data-field="am_time_from">{{ $schedule->am_time_from }}</td>
                                    <td class="editable" data-field="am_time_to">{{ $schedule->am_time_to }}</td>
                                    <td class="editable" data-field="pm_time_from">{{ $schedule->pm_time_from }}</td>
                                    <td class="editable" data-field="pm_time_to">{{ $schedule->pm_time_to }}</td>
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


<!-- Include jQuery -->
<script>
    $(document).ready(function() {
    $('.editable').on('click', function() {
        const $this = $(this);
        const originalText = $this.text();
        const fieldName = $this.data('field');
        const scheduleId = $this.closest('tr').data('id');

        // Create input element
        const $input = $('<input>', {
            type: 'text',
            value: originalText,
            blur: function() {
                const newValue = $(this).val();
                // Update the cell text
                $this.text(newValue);

                // Prepare the form data for AJAX request
                const formData = new FormData();
                formData.append(fieldName, newValue);
                formData.append('_token', '{{ csrf_token() }}'); // Add CSRF token

                // Make AJAX call to update the data
                $.ajax({
                    url: '/schedule/' + scheduleId,
                    type: 'POST', // Change method to POST for simplicity
                    data: formData,
                    contentType: false, // Important for FormData
                    processData: false, // Important for FormData
                    success: function(response) {
                        console.log('Update successful');
                    },
                    error: function(xhr) {
                        console.error('Update failed:', xhr.responseText);
                        $this.text(originalText); // Revert to original text if error
                    }
                });
            },
            keypress: function(e) {
                if (e.which === 13) { // Enter key
                    $(this).blur(); // Trigger blur event to save
                }
            }
        });

        $this.empty().append($input);
        $input.focus();
    });
});


</script>


</body>
</html>





