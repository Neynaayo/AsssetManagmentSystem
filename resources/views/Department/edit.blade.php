@extends('layouts.app')

@section('title', 'Edit Department')

@section('content')
    <x-slot name="title">
       Edit Department
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>  
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Department
                            <a href="{{ route('departments.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('departments.update', $department->id) }}" method="POST">
                            @csrf 
                            @method('PUT')

                            {{-- <div class="mb-3">
                                <label>No</label>
                                <input type="text" name="no" class="form-control" value="{{ $department->no }}" />    
                                @error('no') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label>Code</label>
                                <input type="text" name="code" class="form-control" value="{{ $department->code }}" />    
                                @error('code') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Department Name</label>
                                <input type="text" name="name" class="form-control" value="{{ $department->name }}" />    
                                @error('name') <span class="text-danger">{{ $message }}</span> @enderror
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
