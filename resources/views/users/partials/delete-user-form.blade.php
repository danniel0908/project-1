<!-- profile/partials/delete-user-form.blade.php -->
<section class="profile-section">
    <header class="section-header">
        <h2 class="text-danger">Delete Account</h2>
        <p class="section-description">Once your account is deleted, all of its resources and data will be permanently deleted.</p>
    </header>

    <form method="post" action="{{ route('profile.destroy') }}" class="form-container">
        @csrf
        @method('delete')

        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" id="password" 
                   class="form-control"
                   placeholder="Enter your password to confirm" required />
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-danger"
                onclick="return confirm('Are you sure you want to delete your account? This action cannot be undone.')">
            Delete Account
        </button>
    </form>
</section>