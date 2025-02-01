
<section class="profile-section">
    <header class="section-header">
        <h2>Profile Information</h2>
        <p class="section-description">Update your account's profile information and email address.</p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="form-container">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="first_name">First name</label>
            <input type="text" name="first_name" id="first_name" 
                   class="form-control"
                   value="{{ old('first_name', $user->first_name) }}" required autofocus />
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="last_name">Last name</label>
            <input type="text" name="last_name" id="last_name" 
                   class="form-control"
                   value="{{ old('last_name', $user->last_name) }}" required autofocus />
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="middle_name">Middle name</label>
            <input type="text" name="middle_name" id="middle_name" 
                   class="form-control"
                   value="{{ old('middle_name', $user->middle_name) }}"/>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="suffix">Suffix</label>
            <input type="text" name="suffix" id="suffix" 
                   class="form-control"
                   value="{{ old('suffix', $user->suffix) }}"/>
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <header class="section-header">
            <h3>Contact</h3>
        </header>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" 
                   class="form-control"
                   value="{{ old('email', $user->email) }}"/>
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="tel" name="phone_number" id="phone_number" 
                   class="form-control"
                   value="{{ old('phone_number', $user->phone_number) }}" />
            @error('phone')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" id="address" 
                   class="form-control"
                   value="{{ old('address', $user->address) }}" />
            @error('phone')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Save Changes</button>
    </form>
</section>