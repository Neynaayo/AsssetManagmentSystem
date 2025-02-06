@extends('layouts.app')

@section('title', 'View Asset')

@section('content')
    <x-slot name="title">Asset Management</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('status') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">Asset Management</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('assets.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Asset
                            </a>
                            <form action="{{ route('assets.export') }}" method="GET" class="d-inline-block">
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

                    <div class="card-body">
                        <!-- Search and Filter Section -->
                        <form action="{{ route('assets.index') }}" method="GET" class="mb-4">
                            <div class="row g-3">
                                <!-- Search Bar -->
                                <div class="col-md-4">
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search assets..." class="form-control">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>

                                <!-- Department Dropdown -->
                                <div class="col-md-4">
                                    <select name="department_id" class="form-select" onchange="this.form.submit()">
                                        <option value="">All Departments</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                                {{ $department->name }}
                                            </option>
                                        @endforeach
                                    </select>
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

                        <!-- Asset Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Location</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Type</th>
                                        <th>Serial Number</th>
                                        <th>Spec</th>
                                        <th>Department</th>
                                        <th>User</th>
                                        <th>Previous Owner</th>
                                        <th>Domain</th>
                                        <th>Company</th>
                                        <th>Paid By</th>
                                        <th>Condition</th>
                                        <th>Remark</th>
                                        <th>Action</th>
                                        <th>QR-Code</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($assets as $index => $asset)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $asset->location }}</td>
                                            <td>{{ $asset->brand }}</td>
                                            <td>{{ $asset->model }}</td>
                                            <td>{{ $asset->type }}</td>
                                            <td>{{ $asset->serial_number }}</td>
                                            <td>{{ $asset->spec }}</td>
                                            <td>{{ $asset->department->name ?? 'N/A' }}</td>
                                            <td>{{ $asset->currentOwner->name ?? 'N/A' }}</td>
                                            <td>{{ $asset->previousOwner->name ?? 'N/A' }}</td>
                                            <td>{{ $asset->domain }}</td>
                                            <td>{{ $asset->company->name ?? 'N/A' }}</td>
                                            <td>{{ $asset->paid_by }}</td>
                                            <td>{{ $asset->conditions }}</td>
                                            <td>{{ $asset->remark }}</td>
                                            <td>
                                                <div class="d-flex gap-2">
                                                    <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-sm btn-outline-success">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this asset?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{ route('assets.qrCode', $asset->id) }}" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-qrcode"></i> Show
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-4">
                            {{ $assets->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Custom CSS for Styling -->
    <style>
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