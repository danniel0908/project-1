<style>
    .profile-section {
    margin-bottom: 2rem;
    padding: 1.5rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.section-header {
    margin-bottom: 1.5rem;
}

.section-header h2 {
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.section-description {
    color: #666;
    font-size: 0.9rem;
}

.form-container {
    max-width: 600px;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
}

.form-control {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.form-control:focus {
    outline: none;
    border-color: #4a90e2;
    box-shadow: 0 0 0 2px rgba(74, 144, 226, 0.2);
}

textarea.form-control {
    min-height: 100px;
    resize: vertical;
}

.error-message {
    display: block;
    color: #dc3545;
    font-size: 0.875rem;
    margin-top: 0.25rem;
}

.btn {
    display: inline-block;
    padding: 0.5rem 1rem;
    font-size: 1rem;
    font-weight: 500;
    text-align: center;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    transition: background-color 0.2s;
}

.btn-primary {
    background-color: #4a90e2;
    color: white;
}

.btn-primary:hover {
    background-color: #357abd;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-danger:hover {
    background-color: #c82333;
}

.text-danger {
    color: #dc3545;
}
</style>

@extends('users.layout')

@section('content')
<div class="dashboard-body" id="dashboardBody">
        <section class="content">
            <div class="border">
                <div class="current-time">
                    <p>
                        @include('users.partials.update-profile-information-form')
                    </p>
                </div>
            </div>
            <div class="border">
                <div class="current-time">
                    <p>
                        @include('users.partials.update-applicant-type-form')
                    </p>
                </div>
            </div>
            <div class="border">
                <div class="current-time">
                    <p>
                        @include('users.partials.update-password-form')
                    </p>
                </div>
            </div>
            <div class="border">
                <div class="current-time">
                    <p>
                        @include('users.partials.delete-user-form')
                    </p>
                </div>
            </div>


        </section>
        @include('users.footer')
</div>
@endsection










