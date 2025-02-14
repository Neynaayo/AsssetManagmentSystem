<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asset Management System')</title>
    

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        :root {
            --sidebar-width: 250px;
            --baby-blue: #89CFF0;
            --baby-blue-dark: #07354e;
        }
        
        .navbar {
            height: 60px;
            background: linear-gradient(to right, var(--baby-blue), var(--baby-blue-dark)) !important;
        }
        
        .navbar .btn-outline-light {
            border-color: rgba(255, 255, 255, 0.5);
        }
        
        #sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, var(--baby-blue) 0%, var(--baby-blue-dark) 100%);
            transition: margin-left 0.3s ease-in-out;
            z-index: 1000;
        }

        .company-logo {
            width: 200px;
            padding: 20px;
            margin: 0 auto;
            display: block;
        }
        
        #sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            border-radius: 5px;
        }
        
        #sidebar .dropdown-menu {
            background: var(--baby-blue-dark);
            border: none;
            margin-top: 0;
            border-radius: 0;
        }
        
        #sidebar .dropdown-item:hover {
            background-color: rgba(255, 255, 255, 0.2);
        }
        
        #mainContent {
            transition: margin-left 0.3s ease-in-out;
            background-color: #f8f9fc;
        }
        
        .card {
            border: none;
            box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.15);
        }
        
        .card-header {
            background: white;
            font-weight: bold;
            color: var(--baby-blue);
        }
        
        .dropdown-submenu {
            position: relative;
        }
        
        .dropdown-submenu .dropdown-menu {
            top: 0;
            left: 100%;
            margin-left: 0.1rem;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        .pagination li {
            display: inline-block; /* Ensures buttons are inline */
            margin: 0 2px; /* Adds spacing between buttons */
        }

        .pagination .page-link {
            display: inline-block;
            padding: 8px 12px; /* Adjust padding for consistent size */
            font-size: 14px;
            border: 1px solid #ddd; /* Add border for consistency */
            color: #007bff;
            border-radius: 4px;
            text-decoration: none;
            width: auto;
            height: auto;
        }

        .pagination .page-link svg {
            width: 16px;
            height: 16px; /* Ensure icons are small */
        }

        .pagination {
            justify-content: center; /* Center pagination */
        }

        .pagination .page-link:hover {
            background-color: #f8f9fa;
            border-color: #007bff;
        }

        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
            color: white;
        }
    </style>
</head>
<body class="bg-light">
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-light" type="button" onclick="toggleSidebar()">
                <i class="fas fa-bars"></i>
            </button>
            <span class="navbar-brand ms-3">Asset Management System</span>
            <form method="POST" action="{{ route('logout') }}" class="ms-auto">
                @csrf
                <button type="submit" class="btn btn-light">
                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Sidebar -->
    @if (!isset($hideSidebar) || !$hideSidebar)
    <div id="sidebar" class="position-fixed vh-100" style="top: 60px;">
        <!-- Company Logo -->
        <img src="{{ asset('images/Puncak_Niaga_Holdings_Logo.png') }}" alt="Company Logo" class="company-logo">
        <nav class="nav flex-column mt-4">
            <!-- Dashboard Link -->
            <a href="{{ route('dashboard') }}" class="nav-link text-white px-3 py-2 mb-2">
                <i class="fas fa-tachometer-alt me-2"></i> Dashboard
            </a>

            <!-- Asset Management Dropdown -->
            <div class="nav-item dropdown mb-2">
                <button class="btn text-white dropdown-toggle w-100 text-start px-3 py-2" 
                        type="button" data-bs-toggle="dropdown">
                    <i class="fa fa-box me-2"></i> Asset Management
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a href="{{ route('assets.index') }}" class="dropdown-item text-white">View Asset</a></li>
                    @if (Auth::user()->roleid == 1)
                        <li><a href="{{ route('companies.index') }}" class="dropdown-item text-white">View Company</a></li>
                        <li><a href="{{ route('departments.index') }}" class="dropdown-item text-white">View Department</a></li>
                    @endif
                </ul>
            </div>

            <!-- Asset History Dropdown -->
            @if (Auth::user()->roleid == 1 || Auth::user()->roleid == 3)
            <div class="nav-item dropdown mb-2">
                <button class="btn text-white dropdown-toggle w-100 text-start px-3 py-2" 
                        type="button" data-bs-toggle="dropdown">
                    <i class="fa fa-history me-2"></i> Asset History
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a href="{{ route('loans.index') }}" class="dropdown-item text-white">Loan Asset</a></li>
                    <li><a href="{{ route('availables.index') }}" class="dropdown-item text-white">Available Asset</a></li>
                    <li><a href="{{ route('disposals.index') }}" class="dropdown-item text-white">Disposal Asset</a></li>
                </ul>
            </div>
            @endif

            <!-- Upload Excel Data Dropdown -->
            <div class="nav-item dropdown mb-2">
                <button class="btn text-white dropdown-toggle w-100 text-start px-3 py-2" 
                        type="button" data-bs-toggle="dropdown">
                    <i class="fa fa-file me-2"></i> Upload Excel Data
                </button>
                <ul class="dropdown-menu w-100">
                    <li><a href="{{ route('assets.import') }}" class="dropdown-item text-white">Asset Data Excel</a></li>

                    @if (Auth::user()->roleid == 1 || Auth::user()->roleid == 3)
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle text-white" href="#">
                            Asset History Excel
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('availables.import') }}" class="dropdown-item text-white">Available Asset Excel</a></li>
                            <li><a href="{{ route('loans.import') }}" class="dropdown-item text-white">Loan Asset Excel</a></li>
                            <li><a href="{{ route('disposals.import') }}" class="dropdown-item text-white">Disposal Asset Excel</a></li>
                        </ul>
                    </li>
                    @endif

                    @if (Auth::user()->roleid == 1 )
                    <li class="dropdown-submenu">
                        <a class="dropdown-item dropdown-toggle text-white" href="#">
                            Organization Data
                        </a>
                        <ul class="dropdown-menu">
                            <li><a href="{{ route('staffs.import') }}" class="dropdown-item text-white">Staff Data Excel</a></li>
                            <li><a href="{{ route('departments.import') }}" class="dropdown-item text-white">Department Excel</a></li>
                            <li><a href="{{ route('companies.import') }}" class="dropdown-item text-white">Company Excel</a></li>
                        </ul>
                    </li>
                    @endif
                </ul>
            </div>
            @if (Auth::user()->roleid == 1)
            <!-- User Management -->
            <a href="{{ route('users.index') }}" class="nav-link text-white px-3 py-2 mb-2">
                <i class="fa fa-user me-2"></i> User Management
            </a>

            <!-- Staff Management -->
            <a href="{{ route('staffs.index') }}" class="nav-link text-white px-3 py-2">
                <i class="fa fa-user me-2"></i> Staff Management
            </a>
            @endif
        </nav>
    </div>
    @endif
    <!-- Main Content Area -->
    <div id="mainContent" class="ms-250 mt-5 p-4" style="margin-left:  {{ isset($hideSidebar) && $hideSidebar ? '0' : 'var(--sidebar-width)' }};">
        <div class="container-fluid">
            @if(session('success'))
                <div class="alert alert-success shadow-sm mb-4">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger shadow-sm mb-4">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                </div>
            @endif

            <div class="card">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold">@yield('title', 'Content Title')</h6>
                </div>
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom Scripts -->
    <script>
        // Sidebar Toggle Function
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            if (sidebar.style.marginLeft === "-250px") {
                sidebar.style.marginLeft = "0";
                mainContent.style.marginLeft = "var(--sidebar-width)";
            } else {
                sidebar.style.marginLeft = "-250px";
                mainContent.style.marginLeft = "0";
            }
        }

        // Initialize nested dropdowns
        document.addEventListener('DOMContentLoaded', function() {
            const dropdownSubmenus = document.querySelectorAll('.dropdown-submenu');
            
            dropdownSubmenus.forEach(function(dropdownSubmenu) {
                const toggle = dropdownSubmenu.querySelector('.dropdown-toggle');
                const menu = dropdownSubmenu.querySelector('.dropdown-menu');
                
                toggle.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    
                    // Close all other submenus
                    dropdownSubmenus.forEach(function(other) {
                        if (other !== dropdownSubmenu) {
                            other.querySelector('.dropdown-menu').classList.remove('show');
                        }
                    });
                    
                    menu.classList.toggle('show');
                });
            });
            
            // Close submenus when clicking outside
            document.addEventListener('click', function() {
                dropdownSubmenus.forEach(function(submenu) {
                    submenu.querySelector('.dropdown-menu').classList.remove('show');
                });
            });
        });
    </script>
</body>
</html>