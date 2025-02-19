@extends('layouts.app')

@section('title', 'View Department')

@section('content')
    <x-slot name="title">Staff Management</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center p-3">
                        <h4>Staff Management</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('staffs.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Staff
                            </a>
                
                            <!-- Make the export form align to the right -->
                            <form action="{{ route('staffs.export') }}" method="GET" class="d-flex ms-auto">
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
                </div>
                
                    
                    <div class="card mb-4">
                        <div class="card-header">
                            <h6 class="m-0 font-weight-bold">Search Filters</h6>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('staffs.index') }}" method="GET" class="mb-4">
                                <div class="row g-3">
                                    <!-- Search input -->
                                    <div class="col-md-4">
                                        <label for="search" class="form-label">Search</label>
                                        <input type="text" 
                                               class="form-control" 
                                               id="search" 
                                               name="search" 
                                               value="{{ $search }}" 
                                               placeholder="Name, Email, Staff No, NRIC, Position">
                                    </div>
                    
                                    <!-- Department dropdown -->
                                    <div class="col-md-3">
                                        <label for="department_id" class="form-label">Department</label>
                                        <select class="form-select" id="department_id" name="department_id">
                                            <option value="">All Departments</option>
                                            @foreach($departments as $department)
                                                <option value="{{ $department->id }}" {{ $departmentId == $department->id ? 'selected' : '' }}>
                                                    {{ $department->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                    
                                    <!-- Company dropdown -->
                                    <div class="col-md-3">
                                        <label for="company_id" class="form-label">Company</label>
                                        <select class="form-select" id="company_id" name="company_id">
                                            <option value="">All Companies</option>
                                            @foreach($companies as $company)
                                                <option value="{{ $company->id }}" {{ $companyId == $company->id ? 'selected' : '' }}>
                                                    {{ $company->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                    
                                    <div class="col-md-2">
                                        <label for="per_page" class="form-label">Show Entries</label>
                                        <select class="form-select" id="per_page" name="per_page" onchange="this.form.submit()">
                                            <option value="10" {{ request()->get('per_page', 50) == 10 ? 'selected' : '' }}>10</option>
                                            <option value="25" {{ request()->get('per_page', 50) == 25 ? 'selected' : '' }}>25</option>
                                            <option value="50" {{ request()->get('per_page', 50) == 50 ? 'selected' : '' }}>50</option>
                                            <option value="100" {{ request()->get('per_page', 50) == 100 ? 'selected' : '' }}>100</option>
                                        </select>
                                    </div>
                    
                                    <!-- Search and Reset buttons -->
                                    <div class="col-12 mt-3">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search me-2"></i>Search
                                        </button>
                                        <a href="{{ route('staffs.index') }}" class="btn btn-secondary ms-2">
                                            <i class="fas fa-undo me-2"></i>Reset
                                        </a>
                                    </div>
                                </div>
                            </form>
                    
                            <!-- Search results summary -->
                            <div class="mt-3">
                                <small class="text-muted">
                                    Showing {{ $staff->firstItem() ?? 0 }} to {{ $staff->lastItem() ?? 0 }} of {{ $staff->total() }} entries
                                    @if($search || $departmentId || $companyId)
                                        (filtered from {{ $staff->total() }} total records)
                                    @endif
                                </small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Your existing staff table -->
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>Staff No</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>NRIC</th>
                                    <th>Position</th>
                                    <th>Department</th>
                                    <th>Company</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($staff as $staffMember)
                                <tr>
                                    <td>{{ $staffMember->staff_no }}</td>
                                    <td>{{ $staffMember->name }}</td>
                                    <td>{{ $staffMember->email }}</td>
                                    <td>{{ $staffMember->nric_no }}</td>
                                    <td>{{ $staffMember->position }}</td>
                                    <td>{{ $staffMember->department->name ?? 'N/A' }}</td>
                                    <td>{{ $staffMember->company->name ?? 'N/A' }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('staffs.edit', $staffMember->id) }}" 
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('staffs.destroy', $staffMember->id) }}" method="POST" style="display: inline-block;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                onclick="return confirmDelete('{{ $staffMember->name }}', '{{ $staffMember->nric_no }}')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No staff members found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                        <div class="d-flex justify-content-center mt-3">
                            {{ $staff->links('pagination::bootstrap-5') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<!-- JavaScript for Confirmation Dialog -->
<script>
    function confirmDelete(assetName, serialNumber) {
        // Construct the confirmation message
        const message = `Are you sure you want to delete this Staff?\n\nStaff Information: ${assetName} - ${serialNumber}`;

        // Show the confirmation dialog
        return confirm(message);
    }
</script>

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
