@extends('layouts.app')

@section('title', 'Edit Asset')

@section('content')
    <x-slot name="title">
       Edit Asset
    </x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                {{-- <!-- Success Modal -->
                @if (session('status'))
                    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="successModalLabel">Success</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    {{ session('status') }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">OK</button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif --}}
                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
             @endif
                <!-- Edit Form -->
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Asset
                            <a href="{{ route('assets.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assets.update', $assets->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="{{ $assets->location }}" />
                                @error('location') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Asset Name</label>
                                <input type="text" name="asset_name" class="form-control" value="{{ $assets->asset_name }}" />
                                @error('asset_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Serial Number</label>
                                <input type="text" name="serial_number" class="form-control" value="{{ $assets->serial_number }}" />
                                @error('serial_number') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Asset No</label>
                                <input type="text" name="asset_no" class="form-control" value="{{ $assets->asset_no }}" />    
                                @error('asset_no') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Type</label>
                                <input type="text" name="type" class="form-control" value="{{ $assets->type }}" />    
                                @error('type') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Brand </label>
                                <input type="text" name="brand" class="form-control" value="{{$assets->brand }}"/>
                                @error('brand') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Model </label>
                                <input type="text" name="model" class="form-control" value="{{$assets->model }}"/>
                                @error('model') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Spec</label>
                                <input type="text" name="spec" class="form-control" value="{{ $assets->spec }}" />    
                                @error('spec') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label>User</label>
                                <input type="text" name="user_id" class="form-control" value="{{ $assets->user_id }}" />    
                                @error('user_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}
                            <!-- Current Owner Input -->
                                <<div class="mb-3">
                                    <label for="current_owner_name">Current Owner Name</label>
                                    <input type="text" name="current_owner_name" class="form-control" 
                                           value="{{ old('current_owner_name', $assets->currentOwner->name ?? '') }}" required>
                                    @error('current_owner_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="current_owner_email">Current Owner Email</label>
                                    <input type="email" name="current_owner_email" class="form-control" 
                                           value="{{ old('current_owner_email', $assets->currentOwner->email ?? '') }}">
                                    @error('current_owner_email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="prev_owner_name">Previous Owner Name</label>
                                    <input type="text" name="prev_owner_name" class="form-control" 
                                           value="{{ old('prev_owner_name', $assets->previousOwner->name ?? '') }}">
                                    @error('prev_owner_name') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label for="prev_owner_email">Previous Owner Email</label>
                                    <input type="email" name="prev_owner_email" class="form-control" 
                                           value="{{ old('prev_owner_email', $assets->previousOwner->email ?? '') }}">
                                    @error('prev_owner_email') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                
                            <div class="mb-3">
                                <label>Department</label>
                                <select name="department_id" class="form-control select2">
                                    <option></option> <!-- Blank option for placeholder support -->
                                    @foreach ($department as $item)
                                        <option value="{{ $item->id }}" {{ old('department_id', $assets->department_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>                            

                            {{-- <div class="mb-3">
                                <label>Previous Owner</label>
                                <input type="text" name="previous_user_id" class="form-control" value="{{ $assets->previous_user_id }}" />    
                                @error('previous_user_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label>Domain</label>
                                <input type="text" name="domain" class="form-control" value="{{ $assets->domain }}" />    
                                @error('domain') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Company</label>
                                <select name="company_id" class="form-control select2">
                                    <option></option> <!-- Blank option for placeholder support -->
                                    @foreach ($company as $item)
                                        <option value="{{ $item->id }}" {{ old('company_id', $assets->company_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            

                            <div class="mb-3">
                                <label>Paid By</label>
                                <input type="text" name="paid_by" class="form-control" value="{{ $assets->paid_by }}" />    
                                @error('paid_by') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Condition</label>
                                <input type="text" name="conditions" class="form-control" value="{{ $assets->conditions }}" />    
                                @error('conditions') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Remark</label>
                                <textarea name="remark" class="form-control">{{ $assets->remark }}</textarea>
                                @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </form>  
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Select2 scripts -->
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                width: '100%',
                placeholder: "Select an option",
                allowClear: true,
                dropdownAutoWidth: true,
                dropdownCssClass: "custom-select2-dropdown",
            });
        });
    </script>
    <!-- Trigger Modal Script -->
    @if (session('status'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                successModal.show();
            });
        </script>
    @endif

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
        .custom-select2-dropdown .select2-results__option {
            padding: 8px;
        }
        .custom-select2-dropdown .select2-results__option--highlighted {
            background-color: #d3d3d3;
            color: #000;
        }
    </style>
@endsection
