@extends('layouts.app')

@section('title', 'View Company')

@section('content')
    <x-slot name="title">Company Management</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Company Management</h4>
                        <div>
                            <a href="{{ route('companies.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Company
                            </a>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <!-- Search Form -->
                        <form action="{{ route('companies.index') }}" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search Company..." class="form-control">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-search"></i> Search
                                </button>
                            </div>
                        </form>

                        <form action="{{ route('companies.export') }}" method="GET" class="d-inline-block">
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
                                <form id="perPageForm" action="{{ route('companies.index') }}" method="GET" class="form-inline">
                                    <input type="hidden" name="search" value="{{ request('search') }}">
                                    <select id="perPage" name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit();">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                            </div>
                            <div>
                                {{ $companies->links() }}
                            </div>
                        </div>

                        <!-- Asset Table -->
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
                                                <a href="{{ route('companies.edit', $company->id) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('companies.destroy', $company->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Are you sure you want to delete this company?')">
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
                            {{ $companies->links('pagination::bootstrap-5') }}
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
</style>