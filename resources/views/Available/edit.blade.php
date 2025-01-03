@extends('layouts.app')

@section('title', 'Edit Available Asset')

@section('content')
    <x-slot name="title">
       Edit available Asset
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>  
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Available Asset
                            <a href="{{ route('availables.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('availables.update', $available->id) }}" method="POST">
                            @csrf 
                            @method('PUT')

                            <div class="mb-3">
                                <label>Asset</label>
                                <select name="asset_id" class="form-control select2">
                                    <option value="">Select Existing Asset</option>
                                    @foreach($asset as $assets)
                                        <option value="{{ $assets->id }}" 
                                            {{ $available->asset_id == $assets->id ? 'selected' : '' }}>
                                            {{ $assets->asset_name }} - ({{ $assets->serial_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('asset_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Or Add New Asset</label>
                                <input type="text" name="manual_asset_name" class="form-control" placeholder="Asset Name" value="{{ old('manual_asset_name') }}" />
                                <input type="text" name="manual_brand" class="form-control mt-2" placeholder="Brand" value="{{ old('manual_brand') }}" />
                                <input type="text" name="manual_model" class="form-control mt-2" placeholder="Model" value="{{ old('manual_model') }}" />
                                <input type="text" name="manual_location" class="form-control mt-2" placeholder="Location" value="{{ old('manual_location') }}" />
                                <input type="text" name="manual_serial_number" class="form-control mt-2" placeholder="Serial Number" value="{{ old('manual_serial_number') }}" />
                                <input type="text" name="manual_spec" class="form-control mt-2" placeholder="Specifications" value="{{ old('manual_spec') }}" />
                                @error('manual_asset_name') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

        
                            <div class="mb-3">
                                <label>remark</label>
                                <input type="text" name="remark" class="form-control" value="{{ $available->remark }}" />    
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

    <!-- Include Flatpickr CSS -->
<link href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" rel="stylesheet">

<!-- Include Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <!-- jQuery and Select2 scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
        // Initialize Flatpickr for all elements with class `flatpickr`
        flatpickr('.flatpickr', {
            enableTime: false, // Disable time selection
            dateFormat: "Y-m-d", // Set date format (e.g., 2024-10-24)
            defaultDate: null, // Optional: prefill with today's date if value is empty
        });
    });
        $(document).ready(function() {
            $('.select2').select2({
                widtH: '100%',
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
            color: #000; nn
        }
        .flatpickr {
            background-color: #f9f9f9;
            border: 1px solid #ced4da;
            border-radius: 4px;
            padding: 8px 12px;
            font-size: 16px;
        }
        .flatpickr:hover {
            border-color: #80bdff;
            outline: none;
        }

    </style>
@endsection
