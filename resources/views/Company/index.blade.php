@extends('layouts.app')

@section('title', 'View Company')

@section('content')
    <x-slot name="title">Company Management</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <!-- Card -->
                <div class="card shadow-sm">
                    <!-- Card Header -->
                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">Company Management</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('companies.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Company
                            </a>
                            <form action="{{ route('companies.export') }}" method="GET" class="d-inline-block">
                                <div class="input-group">
                                    <select name="type" class="form-select">
                                        <option value="">Select type</option>
                                        <option value="xlsx">XLSX</option>
                                        <option value="csv">CSV</option>
                                        <option value="xls">XLS</option>
                                    </select>
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-download"></i> Export
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Card Body -->
                    <div class="card-body">
                        <!-- Search and Filter Section -->
                        <form action="{{ route('companies.index') }}" method="GET" class="mb-4">
                            <div class="row g-3">
                                <!-- Search Bar -->
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Company..." class="form-control">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                                    </div>
                                </div>

                                <!-- Show Entries Dropdown -->
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <label for="perPage" class="input-group-text">Show:</label>
                                        <select id="perPage" name="per_page" class="form-select" onchange="this.form.submit()">
                                            <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <!-- Company Table -->
                        <div class="table-responsive">
                            <table class="table table-hover table-striped align-middle">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Code</th>
                                        <th>Name</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $index => $company)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $company->code }}</td>
                                            <td>{{ $company->name }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('companies.destroy', $company->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this company?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $companies->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            border-bottom: 1px solid #e0e0e0;
        }
        .alert {
            border-radius: 8px;
        }
        .table {
            border-collapse: collapse;
        }
        .table-bordered th, 
        .table-bordered td {
            border: 1px solid #dee2e6;
            vertical-align: middle;
            text-align: center;
        }
        .table thead th {
            font-size: 14px;
            font-weight: bold;
            white-space: nowrap;
            background-color: #343a40;
            color: #fff;
            border: 1px solid #454d55;
            text-transform: capitalize;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f8f9fa;
        }
        .table-hover tbody tr:hover {
            background-color: #e9ecef;
        }
        td, th {
            padding: 12px;
            font-size: 14px;
        }
        .table-responsive {
            margin-top: 20px;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            overflow-x: auto;
            background-color: #ffffff;
        }
    </style>
@endsection