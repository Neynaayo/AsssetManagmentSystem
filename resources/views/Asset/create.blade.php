@extends('layouts.app')

@section('title', 'Create Asset')

@section('content')
    <x-slot name="title">
        Add Asset
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Add Asset
                            <a href="{{ route('assets.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assets.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Location</label>
                                <input type="text" name="location" class="form-control" value="{{ old('location') }}"/>
                                @error('location') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Asset Name</label>
                                <input type="text" name="asset_name" class="form-control" value="{{ old('asset_name') }}"/>
                                @error('asset_name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Serial Number</label>
                                <input type="text" name="serial_number" class="form-control" value="{{ old('serial_number') }}"/>
                                @error('serial_number') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Asset Number </label>
                                <input type="text" name="asset_no" class="form-control" value="{{ old('asset_no') }}"/>
                                @error('asset_no') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Type</label>
                                <input type="text" name="type" class="form-control" value="{{ old('type') }}"/>
                                @error('type') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Brand </label>
                                <input type="text" name="brand" class="form-control" value="{{ old('brand') }}"/>
                                @error('brand') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Model </label>
                                <input type="text" name="model" class="form-control" value="{{ old('model') }}"/>
                                @error('model') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Spec</label>
                                <input type="text" name="spec" class="form-control" value="{{ old('spec') }}"/>
                                @error('spec') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                           <!-- Current Owner Input -->
                            <div class="mb-3">
                                <label for="current_owner_name">Current Owner Name</label>
                                <input type="text" name="current_owner_name" class="form-control" value="{{ old('current_owner_name') }}" />
                                @error('current_owner_name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <!-- Previous Owner Input -->
                            <div class="mb-3">
                                <label for="prev_owner_name">Previous Owner Name</label>
                                <input type="text" name="prev_owner_name" class="form-control" value="{{ old('prev_owner_name') }}" />
                                @error('prev_owner_name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Department</label>
                                <select name="department_id" class="form-control select2">
                                    <option></option>
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}" {{ old('department_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            {{-- <div class="mb-3">
                                <label>Previous Owner</label>
                                <input type="text" name="previous_owner" class="form-control" value="{{ old('previous_owner') }}"/>
                                @error('previous_owner') <span class="text-danger">{{ $message }}</span>@enderror
                            </div> --}}

                            <div class="mb-3">
                                <label>Domain</label>
                                <input type="text" name="domain" class="form-control" value="{{ old('domain') }}"/>
                                @error('domain') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Company</label>
                                <select name="company_id" class="form-control select2">
                                    <option></option>
                                    @foreach ($companies as $item)
                                        <option value="{{ $item->id }}" {{ old('company_id') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Paid By</label>
                                <input type="text" name="paid_by" class="form-control" value="{{ old('paid_by') }}"/>
                                @error('paid_by') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Condition</label>
                                <input type="text" name="conditions" class="form-control" value="{{ old('conditions') }}"/>
                                @error('conditions') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Remark</label>
                                <textarea name="remark" class="form-control">{{ old('remark') }}</textarea>
                                @error('remark') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Save</button>
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
                placeholder: "Select an option",  // Placeholder text
                allowClear: true,                 // Allows clearing the selection
                maximumSelectionLength: 1,        // Limit to single selection
                dropdownAutoWidth: true,          // Auto-width for dropdown content
                dropdownCssClass: "custom-select2-dropdown", // Custom class for styling
            });
        });
    </script>
    
    <style>
         .select2-container .select2-selection--single {
        height: 38px; /* Adjust height for better alignment with other form fields */
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 38px; /* Center text vertically */
            color: #495057; /* Text color */
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 38px; /* Center arrow vertically */
        }
        /* Custom styles for the Select2 dropdown */
        .custom-select2-dropdown .select2-results__option {
            padding: 8px; /* Adjust padding for readability */
        }
    
        .custom-select2-dropdown .select2-results__option--highlighted {
            background-color: #d3d3d3; /* Highlight color for better visibility */
            color: #000;               /* Text color */
        }
    </style>
    
@endsection
