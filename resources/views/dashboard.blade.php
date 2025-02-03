@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid px-4">
    <h2 class="mb-4 text-gray-800">Asset Management Dashboard</h2>

    <!-- Stats Cards Row 1 -->
    <div class="row g-4 mb-4">
        <!-- Total Assets Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Total Assets</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalAssets }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Departments Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Departments</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalDepartments }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-building fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Floors Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Floors</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalFloors }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-layer-group fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Companies Card -->
        <div class="col-xl-3 col-md-6">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Companies</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalCompanies }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-city fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!-- Stats Cards Row 2 -->
<div class="row g-4 mb-4">
    @if(Auth::user()->roleid == 1)
        <!-- Loans Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-success text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Loans</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $loanCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hand-holding fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Disposals Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-danger text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Disposals</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $disposalCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-trash-alt fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Available Card -->
        <div class="col-xl-4 col-md-6">
            <div class="card bg-primary text-white shadow h-100">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-uppercase mb-1">Available</div>
                            <div class="h5 mb-0 font-weight-bold">{{ $availableCount }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-circle fa-2x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
    <!-- Charts Row -->
    <div class="row g-4">
        <!-- Department Chart -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Assets by Department</h6>
                </div>
                <div class="card-body">
                    <canvas id="assetsByDepartmentChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Floor Chart -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Assets by Floor</h6>
                </div>
                <div class="card-body">
                    <canvas id="assetsByFloorChart"></canvas>
                </div>
            </div>
        </div>

        <!-- Company Chart -->
        <div class="col-xl-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Assets by Company</h6>
                </div>
                <div class="card-body">
                    <canvas id="assetsByCompanyChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Card Styles */
.card {
    border: none;
    border-radius: 0.35rem;
    transition: transform 0.2s;
}

.card:hover {
    transform: translateY(-2px);
}

.border-left-primary {
    border-left: 0.25rem solid #4e73df !important;
}

.border-left-success {
    border-left: 0.25rem solid #1cc88a !important;
}

.border-left-info {
    border-left: 0.25rem solid #36b9cc !important;
}

.border-left-warning {
    border-left: 0.25rem solid #f6c23e !important;
}

/* Text Styles */
.text-xs {
    font-size: 0.7rem;
}

.text-gray-300 {
    color: #dddfeb !important;
}

.text-gray-800 {
    color: #5a5c69 !important;
}

/* Chart Card Styles */
.card-header {
    background-color: #f8f9fc;
    border-bottom: 1px solid #e3e6f0;
}

/* Responsive Padding */
@media (max-width: 768px) {
    .container-fluid {
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }
}

/* Card Animation */
.card {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Convert PHP data to JavaScript
    const departmentData = @json($assetsByDepartment);
    const floorData = @json($assetsByFloor);
    const companyData = @json($assetsByCompany);

    // Function to generate random colors
    function generateColors(count) {
        const colors = [
            '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
            '#858796', '#5a5c69', '#2e59d9', '#17a673', '#2c9faf'
        ];
        return colors.slice(0, count);
    }

    // Function to process data for charts
    const processData = (data) => ({
        labels: data.map(item => item.name),
        values: data.map(item => item.value)
    });

    const department = processData(departmentData);
    const floor = processData(floorData);
    const company = processData(companyData);

    // Function to create a Doughnut Chart
    const createDoughnutChart = (ctx, labels, data, title) => {
        const colors = generateColors(data.length);
        return new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: colors,
                    borderWidth: 1,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: { size: 11 }
                        }
                    }
                }
            }
        });
    };

    // Set chart canvas height
    const chartCanvases = document.querySelectorAll('canvas');
    chartCanvases.forEach(canvas => {
        canvas.style.height = '300px';
    });

    // Create Charts
    createDoughnutChart(document.getElementById('assetsByDepartmentChart'), 
                       department.labels, department.values, 'Assets by Department');
    createDoughnutChart(document.getElementById('assetsByFloorChart'), 
                       floor.labels, floor.values, 'Assets by Floor');
    createDoughnutChart(document.getElementById('assetsByCompanyChart'), 
                       company.labels, company.values, 'Assets by Company');
</script>
@endsection