
@extends('landing.layout')

@section('content')
<div class="register-container">
    <div class="form-wrapper">
        <div class="image-section">
            <img src="{{ asset('landing/assets/img/tru-picture.png') }}" alt="sign up image">
        </div>
        <div class="form-section">
            <h1 class="form-title">{{ __('messages.login_user') }}</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (request()->get('status') === 'password-reset')
                <div class="alert alert-success">
                    Your password has been reset successfully. Please login with your new password.
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="input-group">
                    <label for="phone" class="input-label">Phone Number</label>
                    <div class="relative">
                        <input id="phone" type="tel" class="input-field" name="phone" value="{{ old('phone') }}" required autofocus autocomplete="tel" placeholder="9XXXXXXXXX">
                    </div>
                </div>
                <div class="input-group">
                    <label for="password" class="input-label">Password</label>
                    <div class="relative">
                        <input id="password" type="password" class="input-field" name="password" required autocomplete="current-password" placeholder="Password">
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="flex items-center justify-between mb-4">
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded">
                        <label for="remember" class="ml-2 text-gray-700">{{ __('messages.remember_me') }}</label>
                    </div>
                </div>
                <button type="submit" class="button primary-button">Click to Login</button>
                <div class="mt-4 text-center">
                    <a href="{{ route('password.request') }}" class="text-green-600 hover:text-green-700" style="text-align: right;">Forgot Password?</a>
                    <p>Don't have an account? <a href="{{ route('register') }}" class="text-green-600 hover:text-green-700">Register Here</a></p>
                </div>
            </form>
        </div>
    </div>
</div>

<style>

.relative {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    padding: 5px;
}

.eye-icon {
    width: 18px;
    height: 18px;
    color: #065f46;
}

.toggle-password:hover .eye-icon {
    color: #059669;
}
.alert {
    padding: 1rem;
    margin-bottom: 1rem;
    border-radius: 0.5rem;
}

.alert-success {
    background-color: #d1fae5;
    border: 1px solid #059669;
    color: #065f46;
}
.alert-danger {
    background-color: #fee2e2;
    border: 1px solid #dc2626;
    color: #991b1b;
}
    .register-container {
    min-height: 100vh;
    background-color: #ecfdf5;
    background-image: linear-gradient(to bottom right, #ecfdf5, #d1fae5);
    display: flex;
    align-items: center; 
    justify-content: center;
    padding-bottom: 10rem; 
}

.form-section a.text-green-600 {
    color: #03851f;
    top: rem;
    right: 1rem; 
}


.form-section a.text-green-600:hover {
    color: #7bc23e;
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
        font-size: 2rem;
        font-weight: 700;
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

    .error {
        color: red;
        font-size: 12px;
        margin-top: -23px;
        margin-bottom: 10px;
        display: block;
    }
</style>

<script>
function togglePassword() {
    const passwordInput = document.getElementById('password');
    const toggleButton = document.querySelector('.toggle-password');
    
    if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        toggleButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 20 20" fill="currentColor">
                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
            </svg>
        `;
    } else {
        passwordInput.type = 'password';
        toggleButton.innerHTML = `
            <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" />
                <path d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
            </svg>
        `;
    }
}
</script>
@endsection