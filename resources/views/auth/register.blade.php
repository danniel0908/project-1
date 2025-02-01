@extends('landing.layout')

@section('content')
<style>

    .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .steps-indicator {
            display: flex;
            justify-content: center;
            margin-bottom: 2rem;
            gap: 1rem;
        }

        .step-dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #e5e7eb;
            transition: all 0.3s;
        }

        .step-dot.active {
            background-color: #059669;
            transform: scale(1.2);
        }

        .step-buttons {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .step-button {
            flex: 1;
        }
        .register-container {
            min-height: 100vh;
            /* Changed to a light green background */
            background-color: #ecfdf5;
            background-image: linear-gradient(to bottom right, #ecfdf5, #d1fae5);
            padding: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-wrapper {
            display: flex;
            max-width: 1000px;
            width: 100%;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .image-section {
            flex: 1;
            /* Changed to a slightly darker green background */
            background-color: #003300;
            background-image: linear-gradient(to bottom right, #003300, #003300);
            padding: 2rem;
            display: none;
        }

        @media (min-width: 768px) {
            .image-section {
                display: block;
            }
        }

        .image-section img {
            width: 100%;
            height: auto;
            object-fit: contain;
        }

        .form-section {
            flex: 1;
            padding: 2.5rem;
            background-color: #dee3e1;
        }

        .form-title {
            font-size: 1.875rem;
            font-weight: 700;
            /* Changed to green color */
            color: #003300;
            text-align: center;
            margin-bottom: 2rem;

        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            /* Changed to darker green */
            color: #065f46;
            margin-bottom: 0.5rem;
            margin-right: 0.5rem;
        }

        .input-field {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            outline: none;
            transition: border-color 0.2s;
        }

        .input-field:focus {
            /* Changed to green focus color */
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5, 150, 105, 0.1);
        }

        .button {
            width: 100%;
            padding: 0.75rem;
            border-radius: 0.5rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.2s;
        }

        .primary-button {
            /* Changed to green background */
            background-color: green;
            color: white;
            border: none;
        }

        .primary-button:hover {
            background-color: #047857;
        }

        .primary-button:disabled {
            background-color: #9ca3af;
            cursor: not-allowed;
        }

        .secondary-button {
            /* Light green background for secondary buttons */
            background-color: #d1fae5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .secondary-button:hover {
            background-color: #a7f3d0;
        }

        .alert {
            padding: 1rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
        }

        .alert-danger {
            background-color: #fee2e2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        #otpField {
            display: none;
            margin-top: 1rem;
        }

        .otp-wrapper {
            display: flex;
            gap: 0.5rem;
        }

        /* Added verification success style */
        .verified-button {
            background-color: #059669 !important;
            color: white !important;
            border: none !important;
        }

        .agreement-group {
            margin-bottom: 1.5rem;
        }

        .agreement-label {
            display: flex;
            align-items: start;
            gap: 0.5rem;
            cursor: pointer;
        }

        .agreement-checkbox {
            margin-top: 0.25rem;
        }

        .agreement-text {
            font-size: 0.875rem;
            color: #374151;
        }

        .agreement-link {
            color: #059669;
            text-decoration: underline;
        }

        .agreement-link:hover {
            color: #047857;
        }

    
</style>
@include('auth.modal.termsPolicyModal')

<div class="register-container">
    <div class="form-wrapper">
        <div class="image-section">
            <img src="{{ asset('landing/assets/img/tru-picture.png') }}" alt="Registration illustration">
        </div>
        
        <div class="form-section">
            <h2 class="form-title">Create Account</h2>
            
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Steps indicator -->
            <div class="steps-indicator">
                <div class="step-dot active" data-step="1"></div>
                <div class="step-dot" data-step="2"></div>
                <div class="step-dot" data-step="3"></div>
            </div>

            <form id="registerForm" method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Step 1: Personal Information -->
                <div class="step active" data-step="1">
                    <div class="input-group">
                        <label class="input-label" for="last_name">Last Name</label>
                        <input id="last_name" class="input-field" type="text" name="last_name" required value="{{ old('last_name') }}" placeholder="Enter your last name">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="first_name">First Name</label>
                        <input id="first_name" class="input-field" type="text" name="first_name" required value="{{ old('first_name') }}" placeholder="Enter your first name">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="middle_name">Middle Name (Optional)</label>
                        <input id="middle_name" class="input-field" type="text" name="middle_name" value="{{ old('middle_name') }}" placeholder="Enter your middle name">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="suffix">Suffix (Optional)</label>
                        <input id="suffix" class="input-field" type="text" name="suffix" value="{{ old('suffix') }}" placeholder="Jr., Sr., III, etc.">
                    </div>

                    <div class="step-buttons">
                        <button type="button" class="button primary-button step-button" onclick="nextStep(1)">Next</button>
                    </div>
                </div>

                <!-- Step 2: Contact Information -->
                <div class="step" data-step="2">
                    <div class="input-group">
                        <label class="input-label" for="applicant_type">Applicant Type</label>
                        <select id="applicant_type" class="input-field" name="applicant_type" required>
                            <option value="">Select applicant type</option>
                            <option value="operator" {{ old('applicant_type') == 'operator' ? 'selected' : '' }}>Operator</option>
                            <option value="driver" {{ old('applicant_type') == 'driver' ? 'selected' : '' }}>Driver</option>
                        </select>
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="email">Email Address (Optional)</label>
                        <input id="email" class="input-field" type="email" name="email" value="{{ old('email') }}" placeholder="your@email.com">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="phoneNumber">Phone Number</label>
                        <div class="otp-wrapper">
                            <input id="phoneNumber" class="input-field" type="text" name="phone_number" value="{{ old('phone_number') }}" placeholder="9XXXXXXXXX">
                            <button type="button" id="sendOtpButton" class="button secondary-button" style="width: auto;">Send OTP</button>
                        </div>
                    </div>

                    <div id="otpField" class="input-group">
                        <label class="input-label" for="otp">Enter OTP</label>
                        <div class="otp-wrapper">
                            <input id="otp" class="input-field" type="text" name="otp" placeholder="Enter OTP code">
                            <button type="button" id="verifyOtp" class="button secondary-button" style="width: auto;">Verify OTP</button>
                        </div>
                    </div>

                    <div class="step-buttons">
                        <button type="button" class="button secondary-button step-button" onclick="prevStep(2)">Previous</button>
                        <button type="button" class="button primary-button step-button" onclick="nextStep(2)">Next</button>
                    </div>
                </div>

                <!-- Step 3: Security -->
                <div class="step" data-step="3">
                    <div class="input-group">
                        <label class="input-label" for="password">Password</label>
                        <input id="password" class="input-field" type="password" name="password" required placeholder="Create a strong password">
                    </div>

                    <div class="input-group">
                        <label class="input-label" for="password_confirmation">Confirm Password</label>
                        <input id="password_confirmation" class="input-field" type="password" name="password_confirmation" required placeholder="Confirm your password">
                    </div>

                    <div class="agreement-group">
                        <label class="agreement-label">
                            <input type="checkbox" name="agreement" id="agreement" class="agreement-checkbox" required>
                            <span class="agreement-text">
                                I agree to the <a href="#" class="agreement-link" data-modal-target="termsModal">Terms of Service</a> and 
                                <a href="#" class="agreement-link" data-modal-target="privacyModal">Privacy Policy</a>
                            </span>
                        </label>
                    </div>

                    <input type="hidden" name="otp_verified" id="otp_verified" value="false">

                    <div class="step-buttons">
                        <button type="button" class="button secondary-button step-button" onclick="prevStep(3)">Previous</button>
                        <button type="submit" id="registerButton" class="button primary-button step-button" disabled>Create Account</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-app.js"></script>
<script src="https://www.gstatic.com/firebasejs/8.6.1/firebase-auth.js"></script>

<script>

function nextStep(currentStep) {
        const nextStepNum = currentStep + 1;
        
        // Basic validation for each step
        if (!validateStep(currentStep)) {
            return;
        }

        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${nextStepNum}"]`).classList.add('active');
        
        // Update step indicator
        document.querySelector(`.step-dot[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step-dot[data-step="${nextStepNum}"]`).classList.add('active');
    }

    function prevStep(currentStep) {
        const prevStepNum = currentStep - 1;
        
        document.querySelector(`.step[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step[data-step="${prevStepNum}"]`).classList.add('active');
        
        // Update step indicator
        document.querySelector(`.step-dot[data-step="${currentStep}"]`).classList.remove('active');
        document.querySelector(`.step-dot[data-step="${prevStepNum}"]`).classList.add('active');
    }

    function validateStep(step) {
        switch(step) {
            case 1:
                // Validate name fields
                const lastName = document.getElementById('last_name').value;
                const firstName = document.getElementById('first_name').value;
                if (!lastName || !firstName) {
                    alert('Please fill in required name fields');
                    return false;
                }
                return true;

            case 2:
                // Validate applicant type
                const applicantType = document.getElementById('applicant_type').value;
                if (!applicantType) {
                    alert('Please select an applicant type');
                    return false;
                }
                return true;

            default:
                return true;
        }
    }
    // Firebase configuration
    const firebaseConfig = {
        apiKey: "AIzaSyBzI4Iz_Sbp8iwadlU5FpC2OQpQYwzrK-8",
        authDomain: "permiso-auth.firebaseapp.com",
        projectId: "permiso-auth",
        storageBucket: "permiso-auth.appspot.com",
        messagingSenderId: "698788391833",
        appId: "1:698788391833:web:233f0cc1930c337d7a4108",
    };

    // Initialize Firebase
    firebase.initializeApp(firebaseConfig);

    // Recaptcha verifier
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sendOtpButton', {
        'size': 'invisible'
    });

    // Send OTP
    document.getElementById('sendOtpButton').addEventListener('click', function() {
        let phoneNumber = document.getElementById('phoneNumber').value.trim();
        const phoneRegex = /^[9]\d{9}$/;
        
        if (!phoneRegex.test(phoneNumber)) {
            alert("Please enter a valid 10-digit mobile number starting with 9");
            return;
        }

        const fullPhoneNumber = "+63" + phoneNumber;
        const appVerifier = window.recaptchaVerifier;
        
        // Disable button and show loading state
        this.disabled = true;
        this.textContent = 'Sending...';

        firebase.auth().signInWithPhoneNumber(fullPhoneNumber, appVerifier)
            .then(function(confirmationResult) {
                window.confirmationResult = confirmationResult;
                document.getElementById('otpField').style.display = 'block';
                alert("OTP has been sent to your phone.");
            })
            .catch(function(error) {
                console.error("Error sending OTP: ", error);
                alert("Error sending OTP: " + error.message);
            })
            .finally(() => {
                // Reset button state
                document.getElementById('sendOtpButton').disabled = false;
                document.getElementById('sendOtpButton').textContent = 'Send OTP';
            });
    });

    document.getElementById('agreement').addEventListener('change', function() {
        const registerButton = document.getElementById('registerButton');
        const otpVerified = document.getElementById('otp_verified').value === "true";
        
        // Enable submit button only if both OTP is verified and agreement is checked
        registerButton.disabled = !(this.checked && otpVerified);
    });

    // Verify OTP
    document.getElementById('verifyOtp').addEventListener('click', function() {
        const code = document.getElementById('otp').value;
        
        if (!code) {
            alert("Please enter the OTP code");
            return;
        }

        // Disable button and show loading state
        this.disabled = true;
        this.textContent = 'Verifying...';

        window.confirmationResult.confirm(code)
        .then(function(result) {
                document.getElementById('otp_verified').value = "true";
                
                // Check both OTP verification and agreement checkbox
                const agreementChecked = document.getElementById('agreement').checked;
                document.getElementById('registerButton').disabled = !agreementChecked;

                alert("Phone number verified successfully!");
                
                // Update UI to show verification success
                document.getElementById('otpField').style.display = 'none';
                document.getElementById('sendOtpButton').textContent = '✓ Verified';
                document.getElementById('sendOtpButton').disabled = true;
                document.getElementById('sendOtpButton').classList.add('verified-button');
            })
            .catch(function(error) {
                console.error("Error verifying OTP: ", error);
                alert("Error verifying OTP: " + error.message);
            })
            .finally(() => {
                document.getElementById('verifyOtp').disabled = false;
                document.getElementById('verifyOtp').textContent = 'Verify OTP';
            });
    });
</script>
@endsection