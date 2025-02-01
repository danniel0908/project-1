<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">
    <title>@yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">
    
    

    <style>

.notes-section li {
    color: #333;
    line-height: 1.6;
}
        .file-update-popup {
                position: fixed;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: white;
                padding: 20px;
                border-radius: 10px;
                box-shadow: 0 4px 6px rgba(0,0,0,0.1);
                z-index: 1000;
                width: 90%;
                max-width: 400px;
            }

            .popup-overlay {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0,0,0,0.5);
                z-index: 999;
                display: none;
            }

            .popup-close {
                position: absolute;
                top: 10px;
                right: 10px;
                cursor: pointer;
                font-size: 20px;
            }

        .custom-modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0,0,0,0.5);
        }

        .modal-content {
            position: relative;
            background-color: #fff;
            margin: 10% auto;
            width: 50%;
            min-width: 300px;
            max-width: 600px;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }

        .modal-header {
            padding: 15px 20px;
            background-color: #fff;
            border-bottom: 1px solid #e5e5e5;
            border-radius: 4px 4px 0 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .modal-title {
            font-size: 16px;
            font-weight: 500;
            color: #333;
        }

        .close {
            color: #999;
            font-size: 20px;
            font-weight: bold;
            cursor: pointer;
            padding: 0 5px;
        }

        .close:hover {
            color: #666;
        }

        .modal-body {
            padding: 20px;
            min-height: 100px;
            max-height: 400px;
            overflow-y: auto;
        }

        .modal-footer {
            padding: 15px 20px;
            border-top: 1px solid #e5e5e5;
            text-align: right;
        }

        .close-btn {
            padding: 6px 12px;
            background-color: #6c757d;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .close-btn:hover {
            background-color: #5a6268;
        }

        /* Style for the invalid status that triggers the modal */
        .status.invalid {
            color: #dc3545;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .status.invalid:hover {
            opacity: 0.8;
        }
        
        
        .status {
            font-weight: 500; /* Slightly less bold */
            padding: 3px 8px; /* Minimal padding */
            border-radius: 3px; /* Softer rounded edges */
            display: inline-block;
            width: auto;
            text-align: center;
            font-size: 0.8em; /* Slightly smaller font */
            }

        .status.approved {
            color: white;
            background-color: #4CAF50; /* Softer green */
        }

        .status.invalid {
            color: white;
            background-color: #F44336; /* Softer red */
        }

        .status.pending {
            color: white;
            background-color: #42A5F5; /* Softer yellow */
        }


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

        .spinner {
        width: 50px;
        height: 50px;
        margin: 0 auto;
        border: 4px solid #f3f3f3;
        border-top: 4px solid #004d00;
        border-radius: 50%;
        animation: spin 1s linear infinite;
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    /* Optional: Add fade in/out animations */
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }

    .fade-out {
        animation: fadeOut 0.3s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes fadeOut {
        from { opacity: 1; }
        to { opacity: 0; }
    }
    </style>
</head>
<body>
    <div id="remarksModal" class="custom-modal">
        <div class="modal-content">
            <div class="modal-header">
                <span class="modal-title">Verifier Remarks</span>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <p id="remarksContent"></p>
            </div>
            <div class="modal-footer">
                <button class="close-btn">Close</button>
            </div>
        </div>
    </div>

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

    @if(session('success'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#d4edda',
            color: '#155724'
        });
    </script>
@endif

@if(session('error'))
    <script>
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'error',
            title: "{{ session('error') }}",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            background: '#f8d7da',
            color: '#721c24'
        });
    </script>
@endif

            <!-- Loading Overlay -->
            <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 9999;">
                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                    <div class="spinner"></div>
                    <p style="margin: 10px 0 0 0; color: #333;">Uploading files...</p>
                </div>
            </div>
    @yield('requirement-form')

    <!-- Pop-up Modal HTML -->
    <div id="fileUpdatePopup" class="popup-overlay">
        <div class="file-update-popup">
            <span class="popup-close">&times;</span>
            <h3 id="popupTitle">Update File</h3>
            <form id="fileUpdateForm" action="" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="fileUpload">Select New File</label>
                    <input type="file" class="form-control" id="fileUpload" name="file" required>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update File</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function showForm(sectionId) {
            document.querySelectorAll('.form-section').forEach(function(section) {
                section.style.display = 'none';
            });
            document.getElementById(sectionId).style.display = 'block';
        }
        function showImagePreview(event, imgId) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var dataURL = reader.result;
                var output = document.getElementById(imgId);
                output.src = dataURL;
                output.style.display = 'block';
            };
            reader.readAsDataURL(input.files[0]);
        }
    </script>
    <script>
        // Get modal elements
        const modal = document.getElementById("remarksModal");
        const remarksContent = document.getElementById("remarksContent");
        const closeBtn = modal.querySelector(".close");
        const footerCloseBtn = modal.querySelector(".close-btn");

        // Function to show remarks
        function showRemarks(remarks) {
            remarksContent.textContent = remarks;
            modal.style.display = "block";
            document.body.style.overflow = 'hidden'; // Prevent background scrolling
        }

        // Close modal function
        function closeModal() {
            modal.style.display = "none";
            document.body.style.overflow = 'auto'; // Restore scrolling
        }

        // Event listeners for closing modal
        closeBtn.onclick = closeModal;
        footerCloseBtn.onclick = closeModal;

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const loadingOverlay = document.getElementById('loadingOverlay');
    const allFileInputs = document.querySelectorAll('input[type="file"]');
    const submitButton = document.querySelector('button[type="submit"]');

    // Show loading overlay function
    function showLoading() {
        loadingOverlay.style.display = 'block';
        loadingOverlay.classList.add('fade-in');
        submitButton.disabled = true;
    }

    // Hide loading overlay function
    function hideLoading() {
        loadingOverlay.classList.add('fade-out');
        setTimeout(() => {
            loadingOverlay.style.display = 'none';
            loadingOverlay.classList.remove('fade-in', 'fade-out');
            submitButton.disabled = false;
        }, 300);
    }

    // Handle form submission
    form.addEventListener('submit', function(e) {
        // Check if any files are selected
        let hasFiles = false;
        allFileInputs.forEach(input => {
            if (input.files && input.files.length > 0) {
                hasFiles = true;
            }
        });

        if (hasFiles) {
            showLoading();
        }
    });

    // Handle individual file selection
    allFileInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            if (this.files && this.files.length > 0) {
                const file = this.files[0];
                const fileSize = file.size / (1024 * 1024); // Convert to MB

                // Show brief loading for files over 1MB
                if (fileSize > 1) {
                    showLoading();
                    // Hide after 1 second if not submitted
                    setTimeout(() => {
                        if (!form.classList.contains('submitting')) {
                            hideLoading();
                        }
                    }, 1000);
                }
            }
        });
    });

    // Handle errors
    window.addEventListener('error', function(e) {
        hideLoading();
        alert('An error occurred during upload. Please try again.');
    });

    // Handle successful page load
    window.addEventListener('load', function() {
        hideLoading();
    });

    // Add error handling for AJAX requests
    document.addEventListener('ajax:error', function() {
        hideLoading();
    });
});
    </script>
</body>
</html>


