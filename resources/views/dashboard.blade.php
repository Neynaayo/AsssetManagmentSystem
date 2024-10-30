{{-- <x-app-layout> --}}
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}
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
                        </div>
                    </nav>
                </div>
                <!-- Main content -->
                <div class="flex-1 flex flex-col">
                    <!-- Top bar -->
                    <div class="flex justify-between items-center bg-white p-4 shadow">
                        <div class="flex items-center">
                            <p class="text-xl font-semibold">Dashboard</p>
                        </div>
                        <div class="flex items-center">
                            <form method="POST" action="{{ route('logout') }}" class="ml-auto">
                                @csrf
                                <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition duration-200">
                                    <i class="fas fa-sign-out-alt mr-2"></i>Logout
                                </button>
                            </form>
                        </div>
                    </div>
                    <!-- Breadcrumb -->
                    <div class="bg-gray-100 p-4">
                        <p class="text-gray-600">
                            Home / Dashboard
                        </p>
                    </div>
                    <!-- Dashboard content -->
                    <div class="p-4">
                        <div class="max-w-sm mx-auto">
                            <div class="bg-blue-600 text-white p-6 rounded-lg shadow-md">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-3xl font-bold">{{ $assetCount ?? 0 }}</p>
                                        <p class="text-lg mt-1">Total Assets</p>
                                    </div>
                                    <div class="text-4xl">
                                        <i class="fa fa-laptop"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-gray-100 p-4 text-center">
                <p class="text-gray-600">
                    Asset Management System
                </p>
            </footer>
        </body>
    </html>


{{-- </x-app-layout> --}}
