@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
    <x-slot name="title">
       Edit Staff information
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>  
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Staff
                            <a href="{{ route('staffs.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('staffs.update', $staff->id) }}" method="POST">
                            @csrf 
                            @method('PUT')

                            <div class="mb-3">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $staff->name }}" />    
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Email</label>
                                <input type="text" name="email" class="form-control" value="{{ $staff->email }}" />    
                                @error('email') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Staff No</label>
                                <input type="text" name="staff_no" class="form-control" value="{{ $staff->staff_no }}" />    
                                @error('staff_no') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Nric No</label>
                                <input type="text" name="nric_no" class="form-control" value="{{ $staff->nric_no }}" />    
                                @error('nric_no') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Department</label>
                                <select name="department_id" class="form-control select2">
                                    <option></option> <!-- Blank option for placeholder support -->
                                    @foreach ($departments as $item)
                                        <option value="{{ $item->id }}" {{ old('department_id', $staff->department_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> 

                            <div class="mb-3">
                                <label>Company</label>
                                <select name="company_id" class="form-control select2">
                                    <option></option> <!-- Blank option for placeholder support -->
                                    @foreach ($companies as $item)
                                        <option value="{{ $item->id }}" {{ old('company_id', $staff->company_id) == $item->id ? 'selected' : '' }}>
                                            {{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('company_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Position</label>
                                <input type="text" name="position" class="form-control" value="{{ $staff->position }}" />    
                                @error('position') <span class="text-danger">{{ $message }}</span> @enderror
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
