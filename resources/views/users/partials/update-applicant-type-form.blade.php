<div class="profile-section">
    <div class="section-header">
        <h2>Update Applicant Type</h2>
        <p class="section-description">
            Update your application type as either an operator or driver.
        </p>
    </div>

    <div class="form-container">
        <form method="post" action="{{ route('profile.update.applicant-type') }}" class="form-group">
            @csrf
            @method('patch')
            
            <div class="form-group">
                <label for="applicant_type">Applicant Type</label>
                <select 
                    name="applicant_type" 
                    id="applicant_type" 
                    class="form-control @error('applicant_type') is-invalid @enderror"
                >
                    <option value="">Select applicant type</option>
                    <option value="operator" {{ old('applicant_type', $user->applicant_type) === 'operator' ? 'selected' : '' }}>
                        Operator
                    </option>
                    <option value="driver" {{ old('applicant_type', $user->applicant_type) === 'driver' ? 'selected' : '' }}>
                        Driver
                    </option>
                </select>
                @error('applicant_type')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</div>