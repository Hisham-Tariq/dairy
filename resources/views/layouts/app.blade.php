<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dairy Management')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-secondary-50 h-full">
    <div class="min-h-screen lg:flex">
        @auth
            <!-- Mobile header -->
            <div class="lg:hidden sticky top-0 z-30 bg-white border-b border-secondary-200">
                <div class="flex items-center justify-between px-4 py-3">
                    <!-- Hamburger button -->
                    <button onclick="toggleSidebar()" class="text-secondary-700 hover:text-secondary-900 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 p-2 rounded-lg">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>

                    <!-- Logo -->
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h1 class="ml-2 text-lg font-semibold text-secondary-900">DairyPro</h1>
                    </div>

                    <!-- Sign out button -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger text-sm py-1.5 px-3">
                            Sign out
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar backdrop for mobile -->
            <div id="sidebarBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" onclick="closeSidebar()"></div>

            <!-- Sidebar -->
            <aside id="sidebar" class="fixed inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 lg:relative transition-transform duration-300 ease-in-out z-50 w-64 lg:flex-shrink-0">
                <div class="flex flex-col h-full bg-white border-r border-secondary-200 lg:sticky lg:top-0 lg:h-screen">
                    <!-- Logo (desktop only) -->
                    <div class="hidden lg:flex items-center flex-shrink-0 px-4 py-5 mb-2">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-lg">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h1 class="text-lg font-bold text-secondary-900">DairyPro</h1>
                                <p class="text-xs text-secondary-500">Management</p>
                            </div>
                        </div>
                    </div>

                    <!-- Close button (mobile only) -->
                    <div class="lg:hidden flex items-center justify-between px-4 py-3 border-b border-secondary-200">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 flex items-center justify-center w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <span class="ml-2 text-lg font-semibold text-secondary-900">Menu</span>
                        </div>
                        <button onclick="closeSidebar()" class="text-secondary-400 hover:text-secondary-600 p-2">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-3 py-4 space-y-1 overflow-y-auto">
                        <a href="{{ route('dashboard') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dashboard') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dashboard') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('departments.index') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('departments.*') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('departments.*') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                            Departments
                        </a>

                        <a href="{{ route('workers.index') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('workers.*') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('workers.*') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            Workers
                        </a>

                        <a href="{{ route('products.index') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('products.*') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('products.*') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Products
                        </a>

                        <a href="{{ route('dairy-productions.index') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('dairy-productions.*') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('dairy-productions.*') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                            </svg>
                            Dairy Production
                        </a>

                        <a href="{{ route('produced-products.index') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('produced-products.*') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('produced-products.*') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Produced Products
                        </a>

                        <a href="{{ route('brought-products.index') }}" onclick="handleNavClick(event)" class="group flex items-center px-3 py-2.5 text-sm font-medium rounded-lg {{ request()->routeIs('brought-products.*') ? 'bg-blue-50 text-blue-600' : 'text-secondary-700 hover:bg-secondary-50' }} transition-colors duration-200">
                            <svg class="mr-3 h-5 w-5 {{ request()->routeIs('brought-products.*') ? 'text-blue-600' : 'text-secondary-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                            Brought Products
                        </a>
                    </nav>

                    <!-- User section -->
                    <div class="flex-shrink-0 border-t border-secondary-200 p-4">
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <button type="submit" class="group flex w-full items-center px-3 py-2.5 text-sm font-medium text-secondary-700 rounded-lg hover:bg-secondary-50 transition-colors duration-200">
                                <svg class="mr-3 h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                </svg>
                                Sign out
                            </button>
                        </form>
                    </div>
                </div>
            </aside>

            <!-- Main content -->
            <main class="flex-1 min-h-screen overflow-x-hidden">
                @if(session('success'))
                    <div class="animate-slide-up">
                        <div class="bg-success-50 border-l-4 border-success-400 p-4 m-4">
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-success-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                <p class="text-sm text-success-700 font-medium">{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                @yield('content')
            </main>
        @endauth

        @guest
            @yield('content')
        @endguest
    </div>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            if (sidebar.classList.contains('-translate-x-full')) {
                openSidebar();
            } else {
                closeSidebar();
            }
        }

        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            sidebar.classList.remove('-translate-x-full');
            backdrop.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');

            sidebar.classList.add('-translate-x-full');
            backdrop.classList.add('hidden');
            document.body.style.overflow = '';
        }

        function handleNavClick(event) {
            // On mobile, close sidebar when navigation link is clicked
            if (window.innerWidth < 1024) {
                closeSidebar();
            }
        }

        // Close sidebar when clicking outside on mobile
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');

            // Close sidebar on escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !sidebar.classList.contains('-translate-x-full')) {
                    closeSidebar();
                }
            });

            // Close sidebar on window resize to desktop
            window.addEventListener('resize', function() {
                if (window.innerWidth >= 1024) {
                    closeSidebar();
                }
            });
        });
    </script>
</body>
</html>
