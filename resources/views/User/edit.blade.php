@extends('layouts.app')

@section('title', 'Edit User')

@section('content')
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit User
                            <a href="{{ route('users.index') }}" class="btn btn-primary float-end mb-4">Back to User</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form id="userEditForm" action="{{ route('users.update', $user->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $user->name }}" />
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" value="{{ $user->email }}" />
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Department Dropdown -->
                            <div class="mb-3">
                                <label>Department</label>
                                <select name="department_id" class="form-select select2">
                                    <option value="">Select Department</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}"
                                            {{ $user->department_id == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Role Dropdown -->
                            <div class="mb-3">
                                <label>Role</label>
                                <select name="roleid" class="form-select select2">
                                    <option value="">Select Role</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}"
                                            {{ $user->roleid == $role->id ? 'selected' : '' }}>
                                            {{ $role->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('roleid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password Update -->
                            <div class="mb-3">
                                <label for="password">New Password</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="Enter new password" />
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password_confirmation">Confirm New Password</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Confirm new password" />
                                @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="mb-3">
                                <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#confirmModal">
                                    Update User
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="confirmModalLabel">Confirm Update</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to update this user's information, including their password (if provided)?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="document.getElementById('userEditForm').submit();">Yes, Update</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Select an option",
                allowClear: true,
                dropdownAutoWidth: true,
            });
        });
    </script>

    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
            color: #495057;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
    </style>
@endsection
