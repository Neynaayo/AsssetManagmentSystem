@extends('layouts.app')

@section('title', isset($user) ? 'Edit User' : 'Create User')

@section('content')
    <x-slot name="title">
        {{ isset($user) ? 'Edit User' : 'Add New User' }}
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>{{ isset($user) ? 'Edit User' : 'Add New User' }}
                            <a href="{{ route('users.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" 
                              action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}">
                            @csrf
                            @if(isset($user))
                                @method('PUT')
                            @endif

                            <!-- Display validation errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <!-- Name Field -->
                            <div class="mb-3">
                                <label for="name">Name</label>
                                <input type="text" 
                                       id="name" 
                                       name="name" 
                                       class="form-control" 
                                       value="{{ $user->name ?? old('name') }}" 
                                       required>
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Email Field -->
                            <div class="mb-3">
                                <label for="email">Email</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control" 
                                       value="{{ $user->email ?? old('email') }}" 
                                       required>
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Role Field -->
                            <div class="mb-3">
                                <label for="roleid">Role</label>
                                <select id="roleid" name="roleid" class="form-control">
                                    <option value="1" {{ (isset($user) && $user->roleid == 1) ? 'selected' : '' }}>Super Admin</option>
                                    <option value="2" {{ (isset($user) && $user->roleid == 2) ? 'selected' : '' }}>Admin</option>
                                </select>
                                @error('roleid') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Department Field -->
                            <div class="mb-3">
                                <label for="department_id">Department</label>
                                <select id="department_id" name="department_id" class="form-control select2">
                                    <option value="">Select Department</option>
                                    @foreach ($department as $dept)
                                        <option value="{{ $dept->id }}" 
                                                {{ (isset($user) && $user->department_id == $dept->id) ? 'selected' : '' }}>
                                            {{ $dept->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <!-- Password Fields -->
                            @if(!isset($user))
                                <div class="mb-3">
                                    <label for="password">Password</label>
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           class="form-control" 
                                           required>
                                    @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" 
                                           id="password_confirmation" 
                                           name="password_confirmation" 
                                           class="form-control" 
                                           required>
                                    @error('password_confirmation') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                            @endif

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">
                                    {{ isset($user) ? 'Update User' : 'Add User' }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Select2 scripts -->
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                width: '100%',
                placeholder: "Select an option",
                allowClear: true,
            });
        });
    </script>

    <!-- Custom Styles -->
    <style>
        .select2-container .select2-selection--single {
            height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px;
        }
    </style>
@endsection
