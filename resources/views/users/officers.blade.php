
@extends('layouts.app')

@section('title', 'TRU Admin List')

@section('content')
<div class="content-wrapper">
    <!-- Alert Messages -->
    @include('partials.alerts')

    
    
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
                    <th>Username</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach ($officers as $officer)
            <tr>
                        <td>{{ $officer->full_name }}</td>
                        <td>{{ $officer->email }}</td>
                        <td>{{ $officer->phone_number }}</td>
                        <td>
                            <button type="button" class="btn btn-sm btn-primary"
                                onclick="openEditDialog(
                                    '{{ $officer->id }}',
                                    '{{ $officer->first_name }}',
                                    '{{ $officer->middle_name }}',
                                    '{{ $officer->last_name }}',
                                    '{{ $officer->suffix }}',
                                    '{{ $officer->email }}',
                                    '{{ $officer->phone_number }}',
                                )">
                                Edit
                            </button>

                            <button type="button" class="btn btn-sm btn-danger"
                                onclick="openDeleteDialog('{{ $officer->id }}', '{{ $officer->full_name }}')">
                                Delete
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" class="btn btn-primary mb-3" onclick="openCreateDialog()">
        Create New Admin
    </button>

        <!-- Create Dialog -->
        <!-- Create Dialog -->
<dialog id="createDialog" class="modal-dialog">
    <div class="modal-content">
        <form action="{{ route('admins.store') }}" method="POST">
            @csrf
            <!-- Add this button where you want it to appear, perhaps near the table -->

            <div class="modal-body">
                <!-- First and Middle Name Row -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" name="first_name" class="form-control @error('first_name') is-invalid @enderror"
                               value="{{ old('first_name') }}" required>
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" name="middle_name" class="form-control @error('middle_name') is-invalid @enderror"
                               value="{{ old('middle_name') }}">
                        @error('middle_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Last Name and Suffix Row -->
                <div class="row">
                    <div class="col-md-9 mb-3">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" name="last_name" class="form-control @error('last_name') is-invalid @enderror"
                               value="{{ old('last_name') }}" required>
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-3 mb-3">
                        <label for="suffix" class="form-label">Suffix</label>
                        <input type="text" name="suffix" class="form-control @error('suffix') is-invalid @enderror"
                               value="{{ old('suffix') }}">
                        @error('suffix')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Username (phone_number field) -->
                <div class="mb-3">
                    <label for="phone_number" class="form-label">Username</label>
                    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
                           value="{{ old('phone_number') }}" required>
                    @error('phone_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="this.closest('dialog').close()" class="btn btn-secondary">Close</button>
                <button type="submit" class="btn btn-primary">Create Admin</button>
            </div>
        </form>
    </div>
</dialog>

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
                            <label for="edit_phone" class="form-label">Username</label>
                            <input type="text" name="phone_number" id="edit_phone"
                                   class="form-control @error('phone_number') is-invalid @enderror">
                            @error('phone_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
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
    function openEditDialog(id, firstName, middleName, lastName, suffix, email, phone) {
        const dialog = document.getElementById('editDialog');
        const form = document.getElementById('editForm');
        form.action = `/admins/${id}`;
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_first_name').value = firstName;
        document.getElementById('edit_middle_name').value = middleName;
        document.getElementById('edit_last_name').value = lastName;
        document.getElementById('edit_suffix').value = suffix;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_phone').value = phone;
        dialog.showModal();
    }

    function openDeleteDialog(id, name) {
        const dialog = document.getElementById('deleteDialog');
        const form = document.getElementById('deleteForm');
        form.action = `/admins/${id}`;
        document.getElementById('delete_name').textContent = name;
        dialog.showModal();
    }
</script>
<script>
function openCreateDialog() {
    const dialog = document.getElementById('createDialog');
    dialog.showModal();
}

// Handle validation errors
document.addEventListener('DOMContentLoaded', function() {
    @if ($errors->any() && old('_dialog') === 'create')
        openCreateDialog();
    @endif
});
</script>
@endsection
