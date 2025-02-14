<?php
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('title', 'View Available')

@section('content')
    <x-slot name="title">Asset Available</x-slot>

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
                   <div class="card-header bg-white d-flex justify-content-between align-items-center p-3">
                       <h4 class="mb-0">Available Asset</h4>
                        <div class="d-flex gap-2">
                            <a href="{{ route('availables.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Asset for Available
                            </a>
                            <form action="{{ route('availables.export') }}" method="GET" class="d-inline-block">
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
                        <form action="{{ route('availables.index') }}" method="GET" class="mb-4">
                            <div class="row g-3">
                                <div class="col-md-8">
                                    <div class="input-group">
                                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search available asset..." class="form-control">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-search"></i> Search
                                        </button>
                            </div>
                        </div>

                        

                        <!-- Pagination and Entries Section -->
                        <div class="col-md-4">
                            <div class="input-group">
                                <label for="perPage" class="me-2">Show:</label>
                                    <select id="perPage" name="per_page" class="form-select" onchange="document.getElementById('perPageForm').submit();">
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
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Asset Name</th>
                                        <th>Location</th>
                                        <th>Serial Number</th>
                                        <th>Spec</th>
                                        <th>Remark</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($available as $index => $availables)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $availables->asset->brand }}</td>
                                            <td>{{ $availables->asset->model }}</td>
                                            <td>{{ $availables->asset->asset_name }}</td>
                                            <td>{{ $availables->asset->location }}</td>
                                            <td>{{ $availables->asset->serial_number }}</td>
                                            <td>{{ $availables->asset->spec }}</td>
                                            <td>{{ $availables->remark }}</td>
                                            <td>
                                                <a href="{{ route('availables.edit', $availables->id) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('availables.destroy', $availables->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm" 
                                                    onclick="return confirmDelete('{{ $availables->asset->asset_name }}', '{{ $availables->asset->serial_number }}')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>                                
                            </table>
                        </div>
                        <div class="d-flex justify-content-center mt-4">
                        {{ $available->appends(request()->query())->links('pagination::bootstrap-5') }}
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Confirmation Dialog -->
    <script>
        function confirmDelete(assetName, serialNumber) {
            // Construct the confirmation message
            const message = `Are you sure you want to delete this asset?\n\nAsset: ${assetName} - ${serialNumber}`;

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
    .text-danger {
    color: red !important;
    font-weight: bold;
    }
    .text-success {
        color: green !important;
        font-weight: bold;
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

