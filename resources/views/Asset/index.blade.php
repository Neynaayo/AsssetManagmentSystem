@extends('layouts.app')

@section('title', 'View Asset')

@section('content')
    <x-slot name="title">Asset Management</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card-custom shadow-sm">
                    <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">Asset Management</h4>
                        <div class="d-flex gap-2">
                            <div>
                            <a href="{{ route('assets.create') }}" class="btn-custom btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Asset
                            </a>
                            </div>
                            <form action="{{ route('assets.export') }}" method="GET" class="d-inline-block">
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
                        </div>
                    </div>
                    
                    <div class="card-body">
                       <!-- Search and Filter Section -->
                       <form action="{{ route('assets.index') }}" method="GET" class="mb-4">
                        <div class="row">
                            <!-- Search Bar -->
                            <div class="col-md-4">
                                <div class="input-group mb-3">
                                    <input 
                                        type="text" 
                                        name="search" 
                                        value="{{ request('search') }}" 
                                        placeholder="Search assets..." 
                                        class="form-control">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-search"></i> Search
                                    </button>
                                </div>
                            </div>
                    
                            <!-- Department Dropdown -->
                            <div class="col-md-4">
                                <select name="department_id" class="form-select" onchange="this.form.submit()">
                                    <option value="">All Departments</option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}" 
                                            {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                    
                            <!-- Show Entries Dropdown -->
                            <div class="col-md-4">
                                <div class="form-inline">
                                    <label for="perPage" class="me-2">Show:</label>
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
                            <table class="table table-hover table-striped align-middle">
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
                                                <a href="{{ route('assets.edit', $asset->id) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <a href="{{ route('assets.destroy', $asset->id) }}" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{ route('assets.qrCode', $asset->id) }}" class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-qrcode"></i> Show
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- Pagination -->
                    {{-- <div class="d-flex justify-content-between align-items-center mt-4">
                        <div>
                            <p>Showing {{ $assets->firstItem() }} to {{ $assets->lastItem() }} of {{ $assets->total() }} entries</p>
                        </div>
                        <div>
                            {{ $assets->appends(request()->input())->links() }}
                        </div>
                    </div> --}}
                    <div class="d-flex justify-content-center mt-3">
                        {{ $assets->appends(request()->query())->links('pagination::bootstrap-5') }}
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
</style>
@endsection
