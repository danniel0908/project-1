<style>
.container {
    min-height: 100vh;
    background-color: #f9fafb;
    padding: 2rem 1rem;
}

.ticket-form-wrapper {
    max-width: 48rem;
    margin: 0 auto;
}

.ticket-form-card {
    background-color: white;
    border-radius: 8px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    padding: 1.5rem;
}

h1 {
    font-size: 1.5rem;
    font-weight: bold;
    color: #111827;
    margin-bottom: 1.5rem;
}

.error-container {
    background-color: #fef2f2;
    border-left: 4px solid #f87171;
    padding: 1rem;
    margin-bottom: 1.5rem;
}

.error-content {
    display: flex;
    align-items: flex-start;
}

.error-icon {
    flex-shrink: 0;
    width: 1.25rem;
    height: 1.25rem;
    color: #f87171;
}

.error-list {
    margin-left: 0.75rem;
    list-style-type: disc;
    list-style-position: inside;
    font-size: 0.875rem;
    color: #dc2626;
}

.form-group {
    margin-bottom: 1.5rem;
}

label {
    display: block;
    font-size: 0.875rem;
    font-weight: 500;
    color: #374151;
    margin-bottom: 0.5rem;
}

input[type="text"],
textarea,
select {
    width: 100%;
    padding: 0.5rem;
    border: 1px solid #d1d5db;
    border-radius: 6px;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
    font-size: 0.875rem;
}

input[type="text"]:focus,
textarea:focus,
select:focus {
    outline: none;
    border-color: #6366f1;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
}

.file-upload-area {
    border: 2px dashed #d1d5db;
    border-radius: 6px;
    padding: 1.25rem;
    text-align: center;
    cursor: pointer;
    transition: border-color 0.2s;
}

.file-upload-area:hover {
    border-color: #6366f1;
}

.upload-icon {
    width: 3rem;
    height: 3rem;
    color: #9ca3af;
    margin: 0 auto;
}

.upload-text {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 0.25rem;
    margin-top: 0.5rem;
    font-size: 0.875rem;
    color: #4b5563;
}

.upload-button {
    color: #6366f1;
    font-weight: 500;
    cursor: pointer;
}

.upload-button:hover {
    color: #4f46e5;
}

.upload-hint {
    font-size: 0.75rem;
    color: #6b7280;
    margin-top: 0.25rem;
}

.hidden {
    display: none;
}

#file-list {
    margin-top: 0.5rem;
}

#file-list div {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.875rem;
    color: #4b5563;
    margin-top: 0.25rem;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
}

button[type="submit"] {
    background-color: #6366f1;
    color: white;
    font-size: 0.875rem;
    font-weight: 500;
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.2s;
}

button[type="submit"]:hover {
    background-color: #4f46e5;
}

button[type="submit"]:focus {
    outline: none;
    box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.5);
}
</style>

@extends('users.layout')

@section('content')
<div class="dashboard-body" id="dashboardBody">

<div class="container">
    <div class="ticket-form-wrapper">
        <div class="ticket-form-card">
            <h1>Create Support Ticket</h1>
            
            @if ($errors->any())
                <div class="error-container">
                    <div class="error-content">
                        <div class="error-icon">
                            <svg viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                        </div>
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('tickets.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="subject">What issue are you experiencing? or any inquiries.</label>
                    <div class="subject-input-container">

                        <select name="subject" id="subject" required onchange="updateInquiryType()">
                            <option value="">Select Issue Type</option>
                            <!-- Account Issues - Admin -->
                            <optgroup label="Account Issues">
                                <option value="login_failed" data-type="account">Cannot Log In</option>
                                <option value="password_reset" data-type="account">Password Reset Problems</option>
                                <option value="account_locked" data-type="account">Account Locked/Suspended</option>
                            </optgroup>
                            
                            <!-- Application Process Issues - Admin -->
                            <optgroup label="Application Process">
                                <option value="form_error" data-type="technical">Form Submission Error</option>
                                <option value="upload_failed" data-type="technical">Document Upload Failed</option>
                                <option value="data_lost" data-type="technical">Lost Data During Submission</option>
                                <option value="incomplete_save" data-type="technical">Cannot Save Draft Application</option>
                            </optgroup>
                            
                            <!-- Technical Issues - Admin -->
                            <optgroup label="Technical Issues">
                                <option value="page_error" data-type="technical">Page Not Loading/Error Message</option>
                                <option value="browser_compatibility" data-type="technical">Browser Compatibility Issues</option>
                                <option value="slow_performance" data-type="technical">Slow Website Performance</option>
                            </optgroup>
                            
                            <!-- Status & Documents - Admin -->
                            <optgroup label="Status & Documents">
                                <option value="status_not_updating" data-type="technical">Application Status Not Updating</option>
                                <option value="missing_notification" data-type="technical">Not Receiving Notifications</option>
                                <option value="document_corrupt" data-type="technical">Corrupt/Unreadable Documents</option>
                                <option value="missing_documents" data-type="technical">Missing Documents</option>
                            </optgroup>

                            <!-- Violation Reports - TMU -->
                            <optgroup label="*Violation Reports">
                                <option value="content_violation" data-type="violation">Violation Inquiry</option>
                            </optgroup>
                            
                            <!-- Other -->
                            <optgroup label="Other">
                                <option value="feature_request" data-type="general">Feature Request/Suggestion</option>
                                <option value="others" data-type="general">Other Issue</option>
                            </optgroup>
                        </select>
                    </div>
                </div>

                <!-- Hidden inquiry_type field -->
                <input type="hidden" name="inquiry_type" id="inquiry_type">

                <div class="form-group">
                    <label for="description">Describe the Issue</label>
                    <textarea name="description" id="description" rows="4" required placeholder="Please provide details about the issue you're experiencing. Include what you were trying to do when the problem occurred, and any error messages you saw.">{{ old('description') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="priority">Priority</label>
                    <select name="priority" id="priority">
                        <option value="low" {{ old('priority') == 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ old('priority') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ old('priority') == 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ old('priority') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Screenshot/Evidence (Optional)</label>
                    <div class="file-upload-area">
                        <div class="upload-content">
                            <svg class="upload-icon" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <div class="upload-text">
                                <label for="attachments" class="upload-button">
                                    Upload files
                                    <input id="attachments" name="attachments[]" type="file" class="hidden" multiple>
                                </label>
                                <p>or drag and drop</p>
                            </div>
                            <p class="upload-hint">Upload screenshots or error messages (PNG, JPG, PDF up to 5MB)</p>
                        </div>
                    </div>
                    <div id="file-list"></div>
                </div>

                <div class="form-actions">
                    <button type="submit">Submit Ticket</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
function updateInquiryType() {
    const subjectSelect = document.getElementById('subject');
    const selectedOption = subjectSelect.options[subjectSelect.selectedIndex];
    const inquiryType = selectedOption.getAttribute('data-type');
    document.getElementById('inquiry_type').value = inquiryType;
}

// Your existing file upload JavaScript
document.getElementById('attachments').addEventListener('change', function(e) {
    const fileList = document.getElementById('file-list');
    fileList.innerHTML = '';
    
    [...this.files].forEach(file => {
        const size = (file.size / 1024 / 1024).toFixed(2);
        const item = document.createElement('div');
        
        const icon = document.createElement('svg');
        icon.style.width = '1.25rem';
        icon.style.height = '1.25rem';
        icon.style.color = '#9ca3af';
        icon.innerHTML = '<path fill="currentColor" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>';
        icon.setAttribute('viewBox', '0 0 24 24');
        
        const text = document.createElement('span');
        text.textContent = `${file.name} (${size}MB)`;
        
        item.appendChild(icon);
        item.appendChild(text);
        fileList.appendChild(item);
    });
});

// Call updateInquiryType on page load in case of form validation failure
document.addEventListener('DOMContentLoaded', updateInquiryType);
</script>
<script>
document.getElementById('attachments').addEventListener('change', function(e) {
    const fileList = document.getElementById('file-list');
    fileList.innerHTML = '';
    
    [...this.files].forEach(file => {
        const size = (file.size / 1024 / 1024).toFixed(2);
        const item = document.createElement('div');
        
        const icon = document.createElement('svg');
        icon.style.width = '1.25rem';
        icon.style.height = '1.25rem';
        icon.style.color = '#9ca3af';
        icon.innerHTML = '<path fill="currentColor" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>';
        icon.setAttribute('viewBox', '0 0 24 24');
        
        const text = document.createElement('span');
        text.textContent = `${file.name} (${size}MB)`;
        
        item.appendChild(icon);
        item.appendChild(text);
        fileList.appendChild(item);
    });
});
</script>

@endsection