<!-- profile/partials/update-password-form.blade.php -->
<section class="profile-section">
    <header class="section-header">
        <h2>Update Password</h2>
        <p class="section-description">Ensure your account is using a long, random password to stay secure.</p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="form-container">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" name="current_password" id="current_password" 
                   class="form-control" required />
            @error('current_password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">New Password</label>
            <input type="password" name="password" id="password" 
                   class="form-control" required />
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" 
                   class="form-control" required />
        </div>

        <button type="submit" class="btn btn-primary">Update Password</button>
    </form>
</section>
