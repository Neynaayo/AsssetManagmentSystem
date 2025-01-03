<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Asset Management System')</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <style>
        :root {
            --baby-blue: #89CFF0;
            --baby-blue-dark: #07354e;
        }
        
        .navbar {
            height: 60px;
            background: linear-gradient(to right, var(--baby-blue), var(--baby-blue-dark)) !important;
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
    </style>
</head>
<body class="bg-light">
    <!-- Top Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <span class="navbar-brand ms-3">Asset Management System</span>
        </div>
    </nav>

    <!-- Main Content Area -->
    <div id="mainContent" class="mt-5 p-4">
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
</body>
</html>