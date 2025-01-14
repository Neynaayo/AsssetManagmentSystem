@extends('layouts.app')

@section('title', 'Edit Disposals')

@section('content')
    <x-slot name="title">
       Edit Disposals
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>  
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Disposals
                            <a href="{{ route('disposals.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('disposals.update', $disposals->id) }}" method="POST">
                            @csrf 
                            @method('PUT')

                            <div class="mb-3">
                                <label>Asset</label>
                                <select name="asset_id" id="asset_id" class="form-control select2">
                                    <option value="">Select Existing Asset</option>
                                    @foreach($asset as $assets)
                                        <option value="{{ $assets->id }}" 
                                            {{ $disposals->asset_id == $assets->id ? 'selected' : '' }}
                                            data-brand="{{ $assets->brand }}"
                                            data-model="{{ $assets->model }}"
                                            data-location="{{ $assets->location }}"
                                            data-serial-number="{{ $assets->serial_number }}"
                                            data-spec="{{ $assets->spec }}">
                                            {{ $assets->asset_name }} - ({{ $assets->serial_number }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('asset_id') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div id="asset-fields" class="mb-3">
                                <label>Asset Details</label>
                                <input type="text" id="brand" class="form-control mt-2" placeholder="Brand" readonly>
                                <input type="text" id="model" class="form-control mt-2" placeholder="Model" readonly>
                                <input type="text" id="location" class="form-control mt-2" placeholder="Location" readonly>
                                <input type="text" id="serial_number" class="form-control mt-2" placeholder="Serial Number" readonly>
                                <input type="text" id="spec" class="form-control mt-2" placeholder="Specifications" readonly>
                            </div>


                            <div class="mb-3">
                                <label>Date Disposals</label>
                                <input type="text" id="date_loan" name="date_loan" class="form-control flatpickr" value="{{ $disposals->date_loan }}" />
                                @error('date_loan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="form-group">
                                <label for="disposal_status_id">Disposal Status</label>
                                <select name="disposal_status_id" id="disposal_status_id" class="form-control">
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" {{ (isset($disposals) && $disposals->disposal_status_id == $status->id) ? 'selected' : '' }}>
                                            {{ $status->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            

                            {{-- <div class="mb-3">
                                <label>Until Date disposals</label>
                                <input type="text" id="until_date_loan" name="until_date_loan" class="form-control flatpickr" value="{{ $disposals->until_date_loan }}" />
                                @error('until_date_loan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div> --}}

                            <div class="mb-3">
                                <label>remark</label>
                                <input type="text" name="remark" class="form-control" value="{{ $disposals->remark }}" />    
                                @error('remark') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <p class="text-muted small">
                                <i class="fas fa-info-circle"></i> If you want to edit Asset Details, please go to the 
                                <a href="{{ route('assets.edit', $disposals->asset_id) }}" class="text-primary text-decoration-underline">
                                    Asset Management
                                </a> section.
                            </p>


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
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const assetDropdown = document.getElementById('asset_id');
            const brandField = document.getElementById('brand');
            const modelField = document.getElementById('model');
            const locationField = document.getElementById('location');
            const serialNumberField = document.getElementById('serial_number');
            const specField = document.getElementById('spec');
    
            function updateAssetFields() {
                const selectedOption = assetDropdown.options[assetDropdown.selectedIndex];
                brandField.value = selectedOption.getAttribute('data-brand') || '';
                modelField.value = selectedOption.getAttribute('data-model') || '';
                locationField.value = selectedOption.getAttribute('data-location') || '';
                serialNumberField.value = selectedOption.getAttribute('data-serial-number') || '';
                specField.value = selectedOption.getAttribute('data-spec') || '';
            }
    
            assetDropdown.addEventListener('change', updateAssetFields);
    
            // Autofill fields on page load if an asset is already selected
            updateAssetFields();
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
