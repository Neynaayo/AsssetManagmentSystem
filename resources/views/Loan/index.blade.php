<?php
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('title', 'View Loan')

@section('content')
    <x-slot name="title">Loan Asset</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Loan Asset</h4>
                        <div>
                            <a href="{{ route('loans.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Loan
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="{{ route('loans.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Loan..." class="form-control">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>

                        <form action="{{ route('loans.export') }}" method="GET" class="d-inline-block">
                            <div class="input-group">
                                <select name="type" class="form-select">
                                    <option value="">Select type</option>
                                    <option value="xlsx">XLSX</option>
                                    <option value="csv">CSV</option>
                                    <option value="xls">XLS</option>
                                </select>
                                <button type="submit" class="btn-custom btn-success">
                                    <i class="fas fa-download"></i> Export
                                </button>
                            </div>
                        </form>

                        <!-- Pagination and Entries Section -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-inline">
                                <label for="perPage" class="me-2">Show:</label>
                                <form id="perPageForm" action="{{ route('loans.index') }}" method="GET" class="form-inline">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <select id="perPage" name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit();">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div>
                                {{ $loans->links() }}
                            </div>
                        </div>

                        <!-- Asset Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Asset Name</th>
                                        <th>Location</th>
                                        <th>Serial Number</th>
                                        <th>Spec</th>
                                        <th>Loan By</th>
                                        <th>Date Loan</th>
                                        <th>Until date Loan</th>
                                        <th>Remark</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($loans as $index => $loan)
                                        @php
                                            $untilDateLoan = \Carbon\Carbon::parse($loan->until_date_loan);
                                            $isOverdue = $untilDateLoan->isPast();
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $loan->asset->brand }}</td>
                                            <td>{{ $loan->asset->model }}</td>
                                            <td>{{ $loan->asset->asset_name }}</td>
                                            <td>{{ $loan->asset->location }}</td>
                                            <td>{{ $loan->asset->serial_number }}</td>
                                            <td>{{ $loan->asset->spec }}</td>
                                            <td>{{ $loan->loanedByStaff->name ?? 'N/A' }}</td>
                                            <td>{{ $loan->date_loan }}</td>
                                            <td class="{{ $isOverdue ? 'text-danger' : 'text-success' }}">
                                                {{ $loan->until_date_loan }}
                                            </td>
                                            <td>{{ $loan->remark }}</td>
                                            <td>
                                                <a href="{{ route('loans.edit', $loan->id) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('loans.destroy', $loan->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this loan?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>  
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>                                
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $loans->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- Custom CSS for Styling -->
<style>
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: #f9f9f9;
    }
    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }
    .btn {
        transition: all 0.3s;
    }
    .btn:hover {
        transform: scale(1.05);
    }
    .form-select, .form-control {
        max-width: 200px;
    }
    .text-danger {
    color: red !important;
    font-weight: bold;
}
.text-success {
    color: green !important;
    font-weight: bold;
}

</style>
