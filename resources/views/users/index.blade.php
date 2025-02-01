@extends('layouts.app')

@section('title', 'User List')

@section('content')
<div class="content-wrapper">
    <!-- Alert Messages -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                @if (old('_dialog') === 'edit')
                    openEditDialog(
                        '{{ old("id") }}',
                        '{{ old("first_name") }}',
                        '{{ old("middle_name") }}',
                        '{{ old("last_name") }}',
                        '{{ old("suffix") }}',
                        '{{ old("email") }}',
                        '{{ old("phone_number") }}',
                        '{{ old("role") }}',
                        '{{ old("applicant_type") }}'
                    );
                @endif
            });
        </script>
    @endif

    <!-- Content Header -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Users</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <!-- Main content -->
    <section class="content">
        <!-- Users Table -->
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Phone Number</th>
                    <th>Role</th>
                    <th>Applicant Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->full_name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->phone_number }}</td>
                        <td>{{ ucfirst($user->role) }}</td>
                        <td>{{ ucfirst($user->applicant_type) }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="openEditDialog(
                                    '{{ $user->id }}',
                                    '{{ $user->first_name }}',
                                    '{{ $user->middle_name }}',
                                    '{{ $user->last_name }}',
                                    '{{ $user->suffix }}',
                                    '{{ $user->email }}',
                                    '{{ $user->phone_number }}',
                                    '{{ $user->applicant_type }}'
                                )">
                                Edit
                            </button>

                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="openDeleteDialog('{{ $user->id }}', '{{ $user->full_name }}')">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Edit Dialog -->
        <dialog id="editDialog" class="modal-dialog">
            <div class="modal-content">
                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="_dialog" value="edit">
                    <input type="hidden" name="id" id="edit_id">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" onclick="this.closest('dialog').close()" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="edit_first_name" class="form-label">First Name</label>
                                <input type="text" name="first_name" id="edit_first_name"
                                       class="form-control @error('first_name') is-invalid @enderror" required>
                                @error('first_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="edit_middle_name" class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" id="edit_middle_name"
                                       class="form-control @error('middle_name') is-invalid @enderror">
                                @error('middle_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-9 mb-3">
                                <label for="edit_last_name" class="form-label">Last Name</label>
                                <input type="text" name="last_name" id="edit_last_name"
                                       class="form-control @error('last_name') is-invalid @enderror" required>
                                @error('last_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="edit_suffix" class="form-label">Suffix</label>
                                <input type="text" name="suffix" id="edit_suffix"
                                       class="form-control @error('suffix') is-invalid @enderror">
                                @error('suffix')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" name="email" id="edit_email"
                                   class="form-control @error('email') is-invalid @enderror" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="edit_phone" class="form-label">Phone Number</label>
                            <input type="text" name="phone_number" id="edit_phone"
                                   class="form-control @error('phone_number') is-invalid @enderror">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="row">
                          
                            <div class="col-md-6 mb-3">
                                <label for="edit_applicant_type" class="form-label">Applicant Type</label>
                                <select name="applicant_type" id="edit_applicant_type" 
                                        class="form-control @error('applicant_type') is-invalid @enderror" required>
                                    <option value="">Select Type</option>
                                    <option value="operator">Operator</option>
                                    <option value="driver">Driver</option>
                                </select>
                                @error('applicant_type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="this.closest('dialog').close()" class="btn btn-secondary">Close</button>
                        <button type="submit" class="btn btn-primary">Update User</button>
                    </div>
                </form>
            </div>
        </dialog>

        <!-- Delete Dialog -->
        <dialog id="deleteDialog" class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Delete User</h5>
                        <button type="button" onclick="this.closest('dialog').close()" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure you want to delete <span id="delete_name"></span>?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" onclick="this.closest('dialog').close()" class="btn btn-secondary">Cancel</button>
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
            </div>
        </dialog>
    </section>
</div>

<style>
    dialog {
        border: none;
        border-radius: 6px;
        padding: 0;
        max-width: 500px;
    }

    dialog::backdrop {
        background-color: rgba(0, 0, 0, 0.5);
    }

    .modal-dialog {
        margin: 1.75rem auto;
    }
</style>

<script>
    function openEditDialog(id, firstName, middleName, lastName, suffix, email, phone, applicantType) {
        const dialog = document.getElementById('editDialog');
        const form = document.getElementById('editForm');
        form.action = `/users/${id}`;
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_first_name').value = firstName;
        document.getElementById('edit_middle_name').value = middleName;
        document.getElementById('edit_last_name').value = lastName;
        document.getElementById('edit_suffix').value = suffix;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone;
        document.getElementById('edit_applicant_type').value = applicantType;
        dialog.showModal();
    }

    function openDeleteDialog(id, name) {
        const dialog = document.getElementById('deleteDialog');
        const form = document.getElementById('deleteForm');
        form.action = `/users/${id}`;
        document.getElementById('delete_name').textContent = name;
        dialog.showModal();
    }
</script>
@endsection