<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset ('form/css/form.css ')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="{{ asset('landing/assets/img/favicon.png') }}" rel="icon">

<style>
        #loadingOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 9999;
        }

        .spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #004d00;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            margin: 0 auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .fade-in {
            opacity: 1;
            transition: opacity 0.3s ease-in;
        }

        .fade-out {
            opacity: 0;
            transition: opacity 0.3s ease-out;
        }

        .submit-button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
</style>
</head>
<body>
  <!-- Loading Overlay -->
  <div id="loadingOverlay">
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; text-align: center; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
            <div class="spinner"></div>
            <p style="margin: 10px 0 0 0; color: #333;">Submitting application...</p>
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

@yield('content-form')
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            const loadingOverlay = document.getElementById('loadingOverlay');
            const submitButton = document.querySelector('.submit-button');

            function showLoading() {
                loadingOverlay.style.display = 'block';
                loadingOverlay.classList.add('fade-in');
                submitButton.disabled = true;
            }

            function hideLoading() {
                loadingOverlay.classList.add('fade-out');
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                    loadingOverlay.classList.remove('fade-in', 'fade-out');
                    submitButton.disabled = false;
                }, 300);
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {
                // Don't prevent default here since we want the Laravel form to submit
                showLoading();
            });

            // Handle validation errors (Laravel specific)
            if (document.querySelector('.alert-danger')) {
                hideLoading();
            }

            // Handle successful form submission (Laravel specific)
            @if(session('success'))
                hideLoading();
            @endif
        });
    </script>
</body>
</html>