@extends('layouts.app')

@section('title','Add Status')
@section('content')
<div class="container">
    <h1>Disposal Statuses</h1>
    <a href="{{ route('disposal-statuses.create') }}" class="btn btn-primary">Add New Status</a>
    <a href="{{ route('disposals.index') }}" class="btn btn-primary float-end">Back</a>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-dark">
        <thead>
            <tr>
                <th>ID</th>
                <th>Status Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($statuses as $status)
                <tr>
                    <td>{{ $status->id }}</td>
                    <td>{{ $status->name }}</td>
                    <td>
                        <a href="{{ route('disposal-statuses.edit', $status) }}" class="btn btn-warning">Edit</a>
                        <form action="{{ route('disposal-statuses.destroy', $status) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" 
                             onclick="return confirmDelete( '{{ $status->name }}')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>


@endsection

<!-- JavaScript for Confirmation Dialog -->
<script>
    function confirmDelete(assetName, serialNumber) {
        // Construct the confirmation message
        const message = `Are you sure you want to delete this asset?\n\nAsset: ${assetName} - ${serialNumber}`;

        // Show the confirmation dialog
        return confirm(message);
    }
</script>

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