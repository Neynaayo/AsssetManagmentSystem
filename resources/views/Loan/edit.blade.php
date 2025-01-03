@extends('layouts.app')

@section('title', 'Edit Loan')

@section('content')
    <x-slot name="title">
        Edit Loan
    </x-slot>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card">
                    <div class="card-header">
                        <h4>Edit Loan
                            <a href="{{ route('loans.index') }}" class="btn btn-primary float-end">Back</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('loans.update', $loan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label>Asset</label>
                                <select name="asset_id" class="form-control select2">
                                    <option value="">Select Existing Asset</option>
                                    @foreach($asset as $assets)
                                        <option value="{{ $assets->id }}" 
                                            {{ $loan->asset_id == $assets->id ? 'selected' : '' }}>
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
                                <label>Loan By</label>
                                <select name="loan_by" class="form-control select2">
                                    <option value="">Select Existing Staff</option>
                                    @foreach($staff as $person)
                                        <option value="{{ $person->id }}" 
                                            {{ $loan->loan_by == $person->id ? 'selected' : '' }}>
                                            {{ $person->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('loan_by') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Or Add New Staff</label>
                                <input type="text" name="manual_loan_by" class="form-control" placeholder="Loan By (Name)" value="{{ old('manual_loan_by') }}" />
                                @error('manual_loan_by') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Date Loan</label>
                                <input type="text" id="date_loan" name="date_loan" class="form-control flatpickr" value="{{ $loan->date_loan }}" />
                                @error('date_loan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Until Date Loan</label>
                                <input type="text" id="until_date_loan" name="until_date_loan" class="form-control flatpickr" value="{{ $loan->until_date_loan }}" />
                                @error('until_date_loan') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>

                            <div class="mb-3">
                                <label>Remark</label>
                                <input type="text" name="remark" class="form-control" value="{{ $loan->remark }}" />
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

    <!-- Initialize Flatpickr -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            flatpickr('.flatpickr', {
                enableTime: false,
                dateFormat: "Y-m-d",
            });

            $('.select2').select2({
                width: '100%',
                placeholder: "Select an option",
                allowClear: true,
            });
        });
    </script>
@endsection
