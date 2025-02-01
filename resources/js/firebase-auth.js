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
            document.getElementById('continueButton').disabled = false;
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
            // Reset button state
            document.getElementById('verifyOtp').disabled = false;
            document.getElementById('verifyOtp').textContent = 'Verify OTP';
        });
});