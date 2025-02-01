
<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Forgot your password? Enter your phone number to receive an OTP code.') }}
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.verify') }}">
        @csrf
        <input type="hidden" id="otp_verified" name="otp_verified" value="false">

        <!-- Step 1: Phone Number and OTP -->
        <div id="step1">
            <div>
                <x-input-label for="phone_number" :value="__('Phone Number')" />
                <div class="flex gap-2">
                    <x-text-input id="phoneNumber" class="block mt-1 flex-1" type="text" 
                        name="phone_number" :value="old('phone_number')" required autofocus />
                    <x-secondary-button type="button" id="sendOtpButton" class="mt-1">
                        {{ __('Send OTP') }}
                    </x-secondary-button>
                </div>
                <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
            </div>

            <div id="otpField" class="mt-4" style="display: none;">
                <x-input-label for="otp" :value="__('OTP Code')" />
                <div class="flex gap-2">
                    <x-text-input id="otp" class="block mt-1 flex-1" type="text" name="otp" />
                    <x-secondary-button type="button" id="verifyOtp" class="mt-1">
                        {{ __('Verify OTP') }}
                    </x-secondary-button>
                </div>
            </div>
        </div>

        <!-- Step 2: New Password (Initially Hidden) -->
        <div id="step2" style="display: none;">
            <div class="mt-4">
                <x-input-label for="password" :value="__('New Password')" />
                <x-text-input id="password" class="block mt-1 w-full" 
                    type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                <x-text-input id="password_confirmation" class="block mt-1 w-full" 
                    type="password" name="password_confirmation" required />
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <x-primary-button>
                    {{ __('Reset Password') }}
                </x-primary-button>
            </div>
        </div>
    </form>
</x-guest-layout>

<!-- Firebase Scripts -->
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/9.6.1/firebase-auth-compat.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Firebase
    const firebaseConfig = {
        apiKey: "AIzaSyBzI4Iz_Sbp8iwadlU5FpC2OQpQYwzrK-8",
        authDomain: "permiso-auth.firebaseapp.com",
        projectId: "permiso-auth",
        storageBucket: "permiso-auth.appspot.com",
        messagingSenderId: "698788391833",
        appId: "1:698788391833:web:233f0cc1930c337d7a4108",
    };

    firebase.initializeApp(firebaseConfig);

    // Initialize Recaptcha verifier
    window.recaptchaVerifier = new firebase.auth.RecaptchaVerifier('sendOtpButton', {
        'size': 'invisible'
    });

    // Send OTP
    document.getElementById('sendOtpButton').addEventListener('click', function() {
        let phoneNumber = document.getElementById('phoneNumber').value.trim();
        
        // Remove any non-digit characters
        phoneNumber = phoneNumber.replace(/\D/g, '');
        
        // Check if number starts with 0, remove it
        if (phoneNumber.startsWith('0')) {
            phoneNumber = phoneNumber.substring(1);
        }
        
        // Validate the number format (9 digits after removing the leading 0)
        const phoneRegex = /^9\d{9}$/;
        
        if (!phoneRegex.test(phoneNumber)) {
            alert("Please enter a valid phone number in format 09XXXXXXXXX");
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
                // Show password reset form
                document.getElementById('step1').style.display = 'none';
                document.getElementById('step2').style.display = 'block';
                alert("Phone number verified successfully! Please set your new password.");
            })
            .catch(function(error) {
                console.error("Error verifying OTP: ", error);
                alert("Error verifying OTP: " + error.message);
            })
            .finally(() => {
                // Reset button state
                document.getElementById('verifyOtp').disabled = false;
                document.getElementById('verifyOtp').textContent = 'Verify OTP';
            });
    });

    // Phone number formatting
    document.getElementById('phoneNumber').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        
        // Ensure the number starts with 0 if user didn't enter it
        if (value.length > 0 && !value.startsWith('0')) {
            value = '0' + value;
        }
        
        // Limit to 11 digits (09XXXXXXXXX)
        if (value.length > 11) {
            value = value.slice(0, 11);
        }
        
        e.target.value = value;
    });

    const form = document.querySelector('form');
    form.addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (document.getElementById('step2').style.display === 'block') {
            const formData = new FormData(this);
            
            try {
                const response = await fetch('/reset-password', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        phone_number: formData.get('phone_number'),
                        password: formData.get('password'),
                        password_confirmation: formData.get('password_confirmation'),
                        otp_verified: formData.get('otp_verified')
                    })
                });

                const result = await response.json();
                
                if (result.success) {
                    window.location.href = '/login?status=password-reset';
                } else {
                    alert(result.errors ? Object.values(result.errors).flat()[0] : 'Password reset failed');
                }
            } catch (error) {
                alert('Error resetting password. Please try again.');
            }
        }
    });
});
</script>