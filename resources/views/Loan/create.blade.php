@extends('layouts.app')

@section('title', 'Create Loan')

@section('content')
    <x-slot name="title">
        Add Loan
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Add Loan
                            <a href="{{ route('loans.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('loans.store') }}" method="POST">
                            @csrf

                            <div class="mb-3">
                                <label>Asset</label>
                                <select name="asset_id" class="form-control select2">
                                    <option value="">Select Existing Asset</option>
                                    @foreach($asset as $assets)
                                        <option value="{{ $assets->id }}">{{ $assets->asset_name }} - ({{ $assets->serial_number }})</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label>Or Add New Asset</label>
                                <input type="text" name="manual_asset_name" class="form-control" placeholder="Asset Name" />
                                <input type="text" name="manual_brand" class="form-control mt-2" placeholder="Brand" />
                                <input type="text" name="manual_model" class="form-control mt-2" placeholder="Model" />
                                <input type="text" name="manual_location" class="form-control mt-2" placeholder="Location" />
                                <input type="text" name="manual_serial_number" class="form-control mt-2" placeholder="Serial Number" />
                                <input type="text" name="manual_spec" class="form-control mt-2" placeholder="Spec" />
                            </div>
                            
                            
                            <div class="mb-3">
                                <label>Loan By</label>
                                <select name="loan_by" class="form-control select2">
                                    <option value="">Select Existing Staff</option>
                                    @foreach($staff as $person)
                                        <option value="{{ $person->id }}">{{ $person->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label>Or Add New Staff</label>
                                <input type="text" name="manual_loan_by" class="form-control" placeholder="Loan By (Name)" />
                            </div>                            
                            

                
                            <div class="mb-3">
                                <label>Date Loan</label>
                                <input type="date" 
                                name="date_loan" 
                                class="form-control" 
                                value="{{ old('date_loan') }}" 
                                id="date_loan" 
                                placeholder="YYYY-MM-DD" />
                                @error('date_loan') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            
                            <div class="mb-3">
                                <label>Until Date Loan</label>
                                <input type="date" 
                                name="until_date_loan" 
                                class="form-control" 
                                value="{{ old('until_date_loan') }}" 
                                id="until_date_loan" 
                                placeholder="YYYY-MM-DD" />
                                @error('until_date_loan') <span class="text-danger">{{ $message }}</span>@enderror
                            </div>
                            

                            <div class="mb-3">
                                <label>Remark</label>
                                <input type="text" name="remark" class="form-control" value="{{ old('remark') }}"/>
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

        document.addEventListener('DOMContentLoaded', function () {
        const dateFields = ['date_loan', 'until_date_loan'];

        dateFields.forEach(fieldId => {
            const field = document.getElementById(fieldId);

            field.addEventListener('blur', function () {
                const inputDate = field.value;
                if (inputDate) {
                    // Try to parse the entered date
                    const parsedDate = new Date(inputDate);

                    // Check if it's a valid date
                    if (!isNaN(parsedDate)) {
                        // Format it as YYYY-MM-DD
                        const formattedDate = parsedDate.toISOString().split('T')[0];
                        field.value = formattedDate;
                    } else {
                        alert('Please enter a valid date in YYYY-MM-DD format.');
                        field.value = ''; // Clear invalid input
                    }
                }
            });
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
