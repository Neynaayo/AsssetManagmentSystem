<?php
use Carbon\Carbon;
?>
@extends('layouts.app')

@section('title', 'View Disposals')

@section('content')
    <x-slot name="title">Disposals Asset</x-slot>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
              @if (session('status'))
                <div class="alert alert-success">{{ session('status') }}</div>
             @endif 
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Disposals Asset</h4>
                        <div>
                            <a href="{{ route('disposals.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Add Disposals
                            </a>
                            <a href="{{ route('disposal-statuses.index') }}" class="btn btn-secondary ms-2">
                                <i class="fas fa-tag"></i> Add Disposal Status
                            </a>
                            <form action="{{ route('disposals.export') }}" method="GET" class="d-inline-block">
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
                    
                    <div class="card mb-4">
                        <div class="card-body">
                          <form method="GET" action="{{ route('disposals.index') }}" class="row g-3">
                            <!-- Search Input -->
                            <div class="col-md-6 col-lg-3">
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="fas fa-search"></i>
                                </span>
                                <input 
                                  type="text" 
                                  name="search" 
                                  value="{{ request('search') }}" 
                                  class="form-control" 
                                  placeholder="Search assets..."
                                >
                              </div>
                            </div>
                      
                            <!-- Disposal Status Filter -->
                            <div class="col-md-6 col-lg-3">
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="fas fa-tag"></i>
                                </span>
                                <select name="disposal_status_id" class="form-select">
                                  <option value="">All Disposal Statuses</option>
                                  @foreach ($statuses as $status)
                                    <option value="{{ $status->id }}" {{ request('disposal_status_id') == $status->id ? 'selected' : '' }}>
                                      {{ $status->name }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                      
                            <!-- Year Filter -->
                            <div class="col-md-6 col-lg-3">
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="fas fa-calendar-year"></i>
                                </span>
                                <select name="year" class="form-select">
                                  <option value="">All Years</option>
                                  @foreach ($years as $year)
                                    <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                                      {{ $year }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                      
                            <!-- Month Filter -->
                            <div class="col-md-6 col-lg-3">
                              <div class="input-group">
                                <span class="input-group-text">
                                  <i class="fas fa-calendar-alt"></i>
                                </span>
                                <select name="month" class="form-select">
                                  <option value="">All Months</option>
                                  @foreach ($months as $key => $month)
                                    <option value="{{ $key }}" {{ request('month') == $key ? 'selected' : '' }}>
                                      {{ $month }}
                                    </option>
                                  @endforeach
                                </select>
                              </div>
                            </div>
                      
                            <!-- Filter Button -->
                            <div class="col-12">
                              <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                  <i class="fas fa-filter me-1"></i> Apply Filters
                                </button>
                                <a href="{{ route('disposals.index') }}" class="btn btn-secondary">
                                  <i class="fas fa-undo me-1"></i> Reset
                                </a>
                              </div>
                            </div>

                      

                       

                        <!-- Pagination and Entries Section -->
                        <div class="col-md-4">
                          <div class="input-group">
                                <label for="perPage" class="me-2">Show:</label>
                                  <select id="perPage" name="per_page" class="form-select" onchange="this.form.submit()">
                                      <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                      <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                      <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                      <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                  </select>
            
                            </div>
                            <div>
                                {{ $disposals->links() }}
                            </div>
                        </div>
                      </form>

                        <!-- Asset Table -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped align-middle text-center">
                                <thead class="table-dark">
                                    <tr>
                                        <th>No</th>
                                        <th>Brand</th>
                                        <th>Model</th>
                                        <th>Asset Name</th>
                                        <th>Location</th>
                                        <th>Serial Number</th>
                                        <th>Spec</th>
                                        <th>Date Disposals</th>
                                        <th>Disposal Status</th>
                                        <th>Remark</th>
                                        <th>Action</th>

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($disposals as $index => $disposal)
                                        @php
                                            $untilDateLoan = \Carbon\Carbon::parse($disposal->until_date_loan);
                                            $isOverdue = $untilDateLoan->isPast();
                                        @endphp
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $disposal->asset->brand }}</td>
                                            <td>{{ $disposal->asset->model }}</td>
                                            <td>{{ $disposal->asset->asset_name }}</td>
                                            <td>{{ $disposal->asset->location }}</td>
                                            <td>{{ $disposal->asset->serial_number }}</td>
                                            <td>{{ $disposal->asset->spec }}</td>
                                            <td>{{ $disposal->date_loan }}</td>
                                            <td>{{ $disposal->disposalStatus->name ?? 'N/A' }}</td>
                                            <td>{{ $disposal->remark }}</td>
                                            <td>
                                                <a href="{{ route('disposals.edit', $disposal->id) }}" class="btn btn-outline-success btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('disposals.destroy', $disposal->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger btn-sm"
                                                     onclick="return confirmDelete('{{ $disposal->asset->asset_name }}', '{{ $disposal->asset->serial_number }}')">
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
                            {{ $disposals->links('pagination::bootstrap-5') }}
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

  .input-group-text {
    background-color: #f8f9fa;
    border-right: none;
  }

  .input-group .form-control,
  .input-group .form-select {
    border-left: none;
  }

  .input-group .form-control:focus,
  .input-group .form-select:focus {
    border-color: #dee2e6;
    box-shadow: none;
  }

  .input-group:hover .input-group-text,
  .input-group:hover .form-control,
  .input-group:hover .form-select {
    border-color: #adb5bd;
  }

  .btn {
    padding: 0.5rem 1rem;
    transition: all 0.2s;
  }

  .btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
