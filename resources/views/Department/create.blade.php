@extends('layouts.app')

@section('title', 'Create Department')

@section('content')
    <x-slot name="title">
        Add Department
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Add Department
                            <a href="{{ route('departments.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.store')}}" method="POST">
                            @csrf

                            {{-- <div class="mb-3">
                                <label>No</label>
                                <input type="text" name="no" class="form-control" value="{{ old('no') }}"/>
                                @error('no') <span class="text-danger">{{ $message }}</span>@enderror
                            </div> --}}

                            <div class="mb-3">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" value="{{ old('code') }}"/>
                                @error('code') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                            <div class="mb-3">
                                <label>Department Name</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name') }}"/>
                                @error('name') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>

                           
                            {{-- <div class="mb-3">
                                <label>Department</label>
                                <select name="Department" class="form-control select2">
                                    <option></option> <!-- Blank option for placeholder support -->
                                    @foreach ($Department as $item)
                                        <option value="{{ $item->id }}" {{ old('Department') == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('Department') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}

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
