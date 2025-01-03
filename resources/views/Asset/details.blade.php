@extends($noSidebar ? 'layouts.app_no_sidebar' : 'layouts.app')
@section('title', 'Asset Details')

@section('content')
<div class="container mt-5">
    <!-- Header -->
    <h4 class="text-center text-primary mb-4">{{ $asset->asset_name }} Details</h4>

    <!-- Asset Details Table -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0">Asset Details</h5>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th class="bg-light">Location</th>
                    <td>{{ $asset->location }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Asset Name</th>
                    <td>{{ $asset->asset_name }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Serial Number</th>
                    <td>{{ $asset->serial_number }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Type</th>
                    <td>{{ $asset->type }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Department</th>
                    <td>{{ $asset->department->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Spec</th>
                    <td>{{ $asset->spec }}</td>
                </tr>
                <tr>
                    <th class="bg-light">User</th>
                    <td>{{ $asset->currentOwner->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Previous User</th>
                    <td>{{ $asset->previousOwner->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <th class="bg-light">Condition</th>
                    <td>{{ $asset->conditions }}</td>
                </tr>
            </table>

            <!-- Back Button -->
            <div class="text-center mt-4">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
