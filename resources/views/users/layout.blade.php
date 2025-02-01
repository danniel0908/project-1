<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TRU</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/introjs.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intro.js/5.1.0/intro.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">


    <style>
        body {
            font-family: "Source Sans Pro", "apple-system", BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            background-color: #f9f9f9;
            margin: 0;
            padding: 0;
        }

        .header {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            padding: 16px 20px;
            color: white;
        }

        .left {
            display: flex;
            justify-content: flex-start;
            margin-left: 85px; /* Default margin when sidebar is collapsed */
            align-items: center;
            cursor: pointer;
            position: relative;
            z-index: 1000;
            transition: margin-left 0.3s; /* Add transition to match sidebar */
        }

        .left.expanded {
            margin-left: 185px; /* Increased margin when sidebar is expanded */
        }

        .header img {
            width: 40px;
            cursor: pointer;
        }

        .header .right {
            display: flex;
            justify-content: flex-end;
        }

        .header .right a {
            color: white;
            margin-left: 20px;
            text-decoration: none;
        }

        .header .right a i {
            font-size: 1.2em;
        }

        .sidebar {
            position: fixed;
            left: 0;
            top: 0;
            width: 70px;
            height: 100%;
            background-color: #ffffff;
            color: white;
            transition: width 0.3s;
            overflow-x: hidden;
            box-shadow: rgba(0, 0, 0, 0.24) 0px 3px 8px;
            z-index: 999;
        }


        .sidebar-image {
            border-bottom-color: gray;
            border-width: 1px;
            border-style: solid;
            border-top: none;
            border-left: none;
            border-right: none;
            width: 200px;
            padding-left: 15px;
            display: flex;
            margin-bottom: 0;
        }

        .sidebar-image p {
            margin-left: 20px;
        }

        .sidebar.expanded {
            width: 170px;
        }

        .sidebar-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 10px;
        }

        .sidebar-content a {
            display: flex;
            width: 100%;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 18px;
            color: white;
            background: linear-gradient(#0eaa3d 0 0) var(--p,0)/var(--p,0) no-repeat;
            transition: .4s,background-position 0s;
            margin-left: 40px;
        }

        .sidebar-content a:hover {
            --p: 100%;
            color: #fff;
        }

        .sidebar-content a i {
            margin-right: 5px;
        }

        .sidebar-image .profile-pic {
            border-radius: 36px;
            width: 35px;
            height: 35px;
            margin-bottom: 3px;
            margin-top: 10px;
        }

        .sidebar-content .label {
            display: none;
        }

        .sidebar.expanded .label {
            display: inline;
        }

        .dashboard-body {
            transition: margin-left 0.3s;
            margin-left: 70px;
        }

        .dashboard-container {
            width: 90%;
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            padding: 20px;
        }

        .header-1 {
            display: flex;
            justify-content: space-between;
            padding-bottom: 10px;
            border-bottom: 1px solid #ddd;
        }

        .header-1 .dashboard-link {
            color: #004d00;
            text-decoration: none;
            font-size: 19px;
        }

        .content {
            margin-top: 20px;
        }
        .current-time,
        .application-status {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .status-rejected {
            color: red;
        }

        .status-approved {
            color: green;
        }

        .status-pending {
            color: blue;
        }

        .Services {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h2 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th,
        table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        table th {
            background-color: #f0f2f5;
        }

        .approved {
            color: rgb(121, 119, 255);
            font-weight: bold;
        }

        footer {
            text-align: center;
            margin-top: 20px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }

        footer p {
            margin: 5px 0;
        }

        footer a {
            color: #004d00;
            text-decoration: none;
        }

        .secondary-dashboard {
            margin-top: 25px;
        }

        /* Dropdown styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-content {
            display: none;
            background-color: #f9f9f9;
            min-width: 200px;
            box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* Responsive styles */
        @media (max-width: 768px) {

            html, body {
                max-width: 100%;
                overflow-x: hidden;
                margin: 0;
                padding: 0;
            }
            

            body {
            font-size: 14px; 
            }

            .header {
                flex-grow: 1;
                display: flex;
                justify-content: flex-end;
                padding: 0;
                margin-right: 10px;
            }
            [style*="background-color: #004d00"] {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 10px;
            }
            .dashboard-container {
                width: 100%;
                margin: 10px;
                padding: 10px;
                box-sizing: border-box;
            }

            .header-1 .dashboard-link {
                font-size: 16px;
            }

          

            h2 {
                font-size: 18px;
            }

            /* Responsive table styles */
            table thead {
                display: none;
            }

            table tr {
                display: block;
                margin-bottom: 1rem;
                border: 1px solid #ddd;
                border-radius: 8px;
                background: #fff;
                box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            }

            table td {
                display: block;
                padding: 12px 15px;
                border: none;
                border-bottom: 1px solid #eee;
                position: relative;
                padding-left: 45%;
            }

            table td:before {
                content: attr(data-label);
                position: absolute;
                left: 15px;
                width: 40%;
                padding-right: 10px;
                font-weight: bold;
                text-align: left;
            }

            table td:last-child {
                border-bottom: none;
            }

            /* Adjust sidebar for mobile */
            .sidebar {
                width: 50px;
                z-index: 999;

            }

            .sidebar.expanded {
                width: 150px;
            }

            .dashboard-body {
                margin-left: 50px;
            }

            .left {
                margin-left: 55px;
                position: relative;
                z-index: 1000;
            }
            /* dashboard */
            .main-dashboard{
                font-size: 10px;
                
            }
        }

        /* Additional responsive adjustments for smaller screens */
        @media screen and (max-width: 480px) {
            .dashboard-container {
                width: 100%;
                margin: 10px auto;
                padding: 8px;
            }

            table td {
                padding-left: 45%;
            }

            .left {
                margin-left: 55px;
            }
        }

        
        /* New styles for tour button */
        #startTour {
            background-color: #004d00;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            margin-right: 20px;
            display: flex;
            align-items: center;
        }

        #startTour i {
            margin-right: 5px;
        }

        /* Intro.js custom styles */
        .tour-highlight {
            box-shadow: 0 0 10px rgba(0, 77, 0, 0.5);
            border: 2px solid #004d00;
            border-radius: 4px;
        }
        .custom-tooltip {
            background-color: #f9f9f9;
            color: #004d00;
            border-radius: 6px;
            padding: 15px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        .introjs-tooltipbuttons {
            background-color: #f0f0f0;

        }

        .remarks-icon {
    color: #dc3545;
    cursor: pointer;
    transition: transform 0.2s;
    font-size: 1.2em;
}

.remarks-icon:hover {
    transform: scale(1.1);
}

.text-center {
    text-align: center;
}
.text-muted {
    color: #6c757d;
    font-size: 0.9em;
}
    </style>

</head>
<body>
    <div style="background-color: #004d00; display: flex; justify-content: space-between; position: relative;">
    <div class="left" id="sidebarButton">
            <i class="fas fa-bars" onclick="toggleSidebar()" style="color: white"></i>
        </div>
        <div class="header">
            <button id="startTour">
                <i class="fas fa-info-circle"></i> Start Tour
            </button>
            <div class="right">
                <a href="#">{{ $userInfo['fullName'] }}</a>
            </div>
        </div>
    </div>


    
    @include('users.sidebar')
    @yield('content')

    <script>
        let isExpanded = false;

        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const dashboardBody = document.getElementById('dashboardBody');
            const sidebarButton = document.getElementById('sidebarButton');
            isExpanded = !isExpanded;
            
            if (isExpanded) {
                sidebar.classList.add('expanded');
                sidebarButton.classList.add('expanded');
                dashboardBody.style.marginLeft = '150px';
            } else {
                sidebar.classList.remove('expanded');
                sidebarButton.classList.remove('expanded');
                dashboardBody.style.marginLeft = '50px';
            }
        }
    </script>


<script>
        // Interactive Tour Setup
        function setupInteractiveTour() {
        const introJs = window.introJs();
        const sidebar = document.getElementById('sidebar');
        const dashboardBody = document.getElementById('dashboardBody');
        const sidebarButton = document.getElementById('sidebarButton');
            
        introJs.setOptions({
            steps: [
                {
                    element: '.sidebar',
                    intro: 'Welcome to TRU! This is your sidebar navigation. You can expand it by hovering or clicking the menu icon.',
                    position: 'right'
                },
                {
                    element: '[href="{{ route("dashboard") }}"]',
                    intro: 'Dashboard: Here you can get an overview of your key information and activities.',
                    position: 'right'
                },
                {
                    element: '[href="{{ route("users.profile") }}"]',
                    intro: 'Profile: Manage and view your personal information and settings.',
                    position: 'right'
                },
                {
                    element: '[href="{{ route("users.services") }}"]',
                    intro: 'Services: Access and manage the various services available to you.',
                    position: 'right'
                },
                {
                    element: '.header .right',
                    intro: 'User Menu: Quick access to your account name',
                    position: 'bottom'
                },
                {
                    element: '.current-time',
                    intro: 'Current Time: Displays the real-time date and time for your reference.',
                    position: 'top'
                },
                {
                    element: '.application-status',
                    intro: 'Application Status: View all your submitted applications, their current status, and important details.',
                    position: 'top'
                },
          
                    {
                        element: '.service',
                        intro: 'Service: The type of service you want to avail',
                        position: 'top'
                    },
                    {
                        element: '.applicant-id',
                        intro: 'Applicant ID: Unique identifier for your application',
                        position: 'top'
                    },
                    {
                        element: '.date-filed',
                        intro: 'Date Filed: When you submitted your application',
                        position: 'top'
                    },
                    {
                        element: '.applicant-name',
                        intro: 'Applicant Name: Your name as the permit applicant',
                        position: 'top'
                    },
                    {
                        element: '.status',
                        intro: 'Status: Current progress of your application',
                        position: 'top'
                    },
                    {
                        element: '.remarks',
                        intro: 'Remarks: Additional notes from application reviewers',
                        position: 'top'
                    }
                ],
        showStepNumbers: true,
        showBullets: false,
        scrollToElement: true,
        overlayOpacity: 0.7,
        nextLabel: 'Next →',
        prevLabel: '← Previous',
        skipLabel: 'Skip Tour',
        doneLabel: 'Finish Tour',
        keyboardNavigation: true,
        highlightClass: 'tour-highlight',
        exitOnOverlayClick: true,
        exitOnEsc: true,
        tooltipClass: 'custom-tooltip',
        tooltipPosition: 'auto',
        positionPrecedence: ['right', 'left', 'bottom', 'top']
        });

        introJs.onbeforechange(function(targetElement) {
        const currentStep = this._currentStep;
        
        // Expand sidebar for steps 1, 2, 3, 4
        if ([1, 2, 3, 4].includes(currentStep)) {
            sidebar.classList.add('expanded');
            sidebarButton.classList.add('expanded');
            dashboardBody.style.marginLeft = '150px';
        } else {
            // Collapse sidebar for other steps
            sidebar.classList.remove('expanded');
            sidebarButton.classList.remove('expanded');
            dashboardBody.style.marginLeft = '50px';
        }
    });

    introJs.oncomplete(function() {
        sidebar.classList.remove('expanded');
        sidebarButton.classList.remove('expanded');
        dashboardBody.style.marginLeft = '50px';
    });

    introJs.onexit(function() {
        sidebar.classList.remove('expanded');
        sidebarButton.classList.remove('expanded');
        dashboardBody.style.marginLeft = '50px';
    });


        // Event listener for starting the tour
        document.getElementById('startTour').addEventListener('click', function() {
            // Start the tour
            introJs.start();
        });
    }

    // Call the setup function when the page loads
    document.addEventListener('DOMContentLoaded', setupInteractiveTour);
        // Time update function (from your existing code)
        function updateTime() {
            const now = new Date();
            let hours = now.getHours();
            const minutes = now.getMinutes().toString().padStart(2, '0');
            const seconds = now.getSeconds().toString().padStart(2, '0');

            const ampm = hours >= 12 ? 'PM' : 'AM';
            hours = hours % 12;
            hours = hours ? hours : 12;
            const formattedTime = `${hours}:${minutes}:${seconds} ${ampm}`;

            document.getElementById('time').textContent = formattedTime;
        }

        // Update the time immediately when the page loads
        updateTime();

        // Set an interval to update the time every second
        setInterval(updateTime, 1000);
</script>
@stack('scripts')
</body>
</html>
