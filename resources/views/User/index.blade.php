@extends('layouts.app')

@section('title', 'View User')

@section('content')
    <x-slot name="title">User Management</x-slot>

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
                    <div class="card-header d-flex justify-content-between align-items-center p-3">
                        <h4 class="mb-0">User Management</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add User
                            </a>
                            <form action="{{ route('users.export') }}" method="GET" class="d-inline-block">
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
                        <!-- Search Form -->
                        <form action="{{ route('users.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search User..." class="form-control">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>

                        

                       <!-- Pagination and Entries Section -->
                        <div class="d-flex justify-content-between mb-3">
                            <div class="form-inline">
                                <label for="perPage" class="me-2">Show:</label>
                                <form id="perPageForm" action="{{ route('users.index') }}" method="GET" class="form-inline">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <select id="perPage" name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit();">
                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                        <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                    </select>
                                </form>
                            </div>
                            <div>
                                {{ $users->links('pagination::bootstrap-5') }}
                            </div>
                        </div>

                        <!-- User Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Role</th>
                                        <th>Department</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>{{ $user->role ? $user->role->name : 'N/A' }}</td>
                                            <td>{{ $user->department->name ?? 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('users.edit', $user->id) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                    onclick="return confirmDelete('{{ $user->name }}', '{{ $user->role->name}}')">
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
                            {{ $users->links('pagination::bootstrap-5') }}
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
        const message = `Are you sure you want to delete this User?\n\nUser Details: ${assetName} - ${serialNumber}`;

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
