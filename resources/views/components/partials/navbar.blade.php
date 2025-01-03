{{-- 
<html>
        <head>
            <title>Dashboard</title>
            <script src="https://cdn.tailwindcss.com"></script>
            <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
        </head>
        <body class="bg-gray-100 font-sans leading-normal tracking-normal">
            <div class="flex">
                <!-- Sidebar -->
                <div class="w-64 bg-gray-800 h-screen">
                    <div class="p-4 text-white text-2xl font-bold">
                        <i class="fa fa-fax"></i>
                        Asset Management System
                    </div>
                    <nav class="mt-10">
                        <a class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-white" href="{{ url('/dashboard') }}">
                            <i class="fas fa-tachometer-alt"></i>
                            Dashboard
                        </a>
                        <div class="mt-5">
                            <a class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400" href="{{ url('Asset') }}">
                                <i class="fa fa-laptop"></i>
                                View Asset
                            </a>
                            <a class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400" href="{{ url('Asset/import') }}">
                                <i class="fa fa-file"></i>
                                Upload/Import Excel
                            </a>
                            {{-- <a class="block py-2.5 px-4 rounded transition duration-200 hover:bg-gray-700 hover:text-white text-gray-400" href="{{ url('Asset/import') }}">
                              Import Excel
                            </a> 
                        </div>
                    </nav>
                </div>
                        <div class="flex items-center">
                            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                          </div>
        </body>
    </html> --}}

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard - Asset Management System</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
        <script>
            function toggleSidebar() {
                const sidebar = document.getElementById('sidebar');
                const mainContent = document.getElementById('mainContent');
                const isCollapsed = sidebar.classList.contains('w-16');
                
                if (isCollapsed) {
                    sidebar.classList.remove('w-16');
                    sidebar.classList.add('w-64');
                    mainContent.classList.remove('ml-16');
                    mainContent.classList.add('ml-64');
                    // Show text
                    document.querySelectorAll('.nav-text').forEach(el => {
                        el.classList.remove('hidden');
                    });
                } else {
                    sidebar.classList.remove('w-64');
                    sidebar.classList.add('w-16');
                    mainContent.classList.remove('ml-64');
                    mainContent.classList.add('ml-16');
                    // Hide text
                    document.querySelectorAll('.nav-text').forEach(el => {
                        el.classList.add('hidden');
                    });
                }
            }
        </script>
    </head>
    <body class="bg-gray-100 font-sans leading-normal tracking-normal">
        <!-- Top Navigation Bar -->
        <div class="fixed top-0 right-0 left-0 bg-white shadow-sm h-16 z-50">
            <div class="flex justify-between items-center h-full px-4">
                <!-- Toggle Button -->
                <button onclick="toggleSidebar()" class="text-gray-600 hover:text-gray-800">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                
                <!-- Logout Button -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-200">
                        <i class="fas fa-sign-out-alt mr-2"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    
        <!-- Sidebar -->
        <div id="sidebar" class="fixed left-0 top-16 bottom-0 w-64 bg-gray-800 transition-all duration-300 ease-in-out">
            <!-- Navigation Menu -->
            <nav class="mt-6 px-2">
                <div class="space-y-2">
                    <!-- Dashboard Link -->
                    <a href="{{ url('/dashboard') }}" class="flex items-center px-4 py-3 text-white rounded-lg hover:bg-gray-700 transition-all duration-200 group">
                        <i class="fas fa-tachometer-alt w-6"></i>
                        <span class="ml-3 nav-text">Dashboard</span>
                    </a>
    
                    <!-- Asset Management Links -->
                    <a href="{{ url('Asset') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200 group">
                        <i class="fa fa-laptop w-6"></i>
                        <span class="ml-3 nav-text">View Asset</span>
                    </a>
                    
                    <a href="{{ url('Asset/import') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all duration-200 group">
                        <i class="fa fa-file w-6"></i>
                        <span class="ml-3 nav-text">Upload/Import Excel</span>
                    </a>
                </div>
            </nav>
        </div>
    
        <!-- Main Content Area -->
        <div id="mainContent" class="ml-64 mt-16 transition-all duration-300 ease-in-out">
            <div class="p-6">
                <!-- Content will be dynamically loaded here -->
                @yield('content')
            </div>
        </div>
    </body>
    </html>