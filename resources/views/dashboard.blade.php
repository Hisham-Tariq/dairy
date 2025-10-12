@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="p-6 dark:bg-secondary-900 transition-colors duration-200">
    <!-- Header -->
    <div class="mb-8 animate-fade-in">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 dark:text-white mb-2">Dashboard</h1>
                <p class="text-secondary-600 dark:text-secondary-400">Welcome back! Here's an overview of your dairy management system.</p>
            </div>
            <div class="hidden md:flex items-center space-x-3">
                <div class="bg-white dark:bg-secondary-800 rounded-lg shadow px-4 py-3 border border-secondary-200 dark:border-secondary-700">
                    <p class="text-xs text-secondary-500 dark:text-secondary-400 font-medium uppercase tracking-wider">Today</p>
                    <p class="text-lg font-semibold text-secondary-900 dark:text-white">{{ now()->format('M d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Departments Card -->
        <div class="bg-white dark:bg-secondary-800 rounded-lg shadow hover:shadow-lg transition-all duration-200 border border-secondary-200 dark:border-secondary-700 animate-slide-up" style="animation-delay: 0.1s;">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Total Departments</p>
                                <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ $departmentsCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-3 bg-secondary-50 dark:bg-secondary-900 border-t border-secondary-100 dark:border-secondary-700">
                <a href="{{ route('departments.index') }}" class="text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium flex items-center group">
                    View all
                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Workers Card -->
        <div class="bg-white dark:bg-secondary-800 rounded-lg shadow hover:shadow-lg transition-all duration-200 border border-secondary-200 dark:border-secondary-700 animate-slide-up" style="animation-delay: 0.2s;">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-green-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Total Workers</p>
                                <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ $workersCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-3 bg-secondary-50 dark:bg-secondary-900 border-t border-secondary-100 dark:border-secondary-700">
                <a href="{{ route('workers.index') }}" class="text-sm text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 font-medium flex items-center group">
                    View all
                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>

        <!-- Supervisors Card -->
        <div class="bg-white dark:bg-secondary-800 rounded-lg shadow hover:shadow-lg transition-all duration-200 border border-secondary-200 dark:border-secondary-700 animate-slide-up" style="animation-delay: 0.3s;">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-secondary-600 dark:text-secondary-400">Supervisors</p>
                                <p class="text-2xl font-bold text-secondary-900 dark:text-white">{{ $supervisorsCount }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-6 py-3 bg-secondary-50 dark:bg-secondary-900 border-t border-secondary-100 dark:border-secondary-700">
                <a href="{{ route('workers.index') }}" class="text-sm text-purple-600 dark:text-purple-400 hover:text-purple-700 dark:hover:text-purple-300 font-medium flex items-center group">
                    View all
                    <svg class="ml-2 w-4 h-4 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Quick Actions & Info Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Quick Actions -->
        <div class="bg-white dark:bg-secondary-800 rounded-lg shadow p-6 animate-slide-up border border-secondary-200 dark:border-secondary-700" style="animation-delay: 0.4s;">
            <h3 class="text-lg font-semibold text-secondary-900 dark:text-white mb-4">Quick Actions</h3>
            <div class="space-y-3">
                <button onclick="openDepartmentModal()" class="w-full flex items-center p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors group">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div class="ml-3 text-left">
                        <p class="text-sm font-medium text-secondary-900 dark:text-white">Add New Department</p>
                        <p class="text-xs text-secondary-500 dark:text-secondary-400">Create a new department</p>
                    </div>
                </button>

                <button onclick="openWorkerModal()" class="w-full flex items-center p-3 bg-green-50 dark:bg-green-900/20 rounded-lg hover:bg-green-100 dark:hover:bg-green-900/30 transition-colors group">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-500 rounded-lg flex items-center justify-center">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="ml-3 text-left">
                        <p class="text-sm font-medium text-secondary-900 dark:text-white">Add New Worker</p>
                        <p class="text-xs text-secondary-500 dark:text-secondary-400">Register a new staff member</p>
                    </div>
                </button>
            </div>
        </div>

        <!-- System Info -->
        <div class="bg-white dark:bg-secondary-800 rounded-lg shadow p-6 animate-slide-up border border-secondary-200 dark:border-secondary-700" style="animation-delay: 0.5s;">
            <h3 class="text-lg font-semibold text-secondary-900 dark:text-white mb-4">System Overview</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between p-3 bg-secondary-50 dark:bg-secondary-900 rounded-lg">
                    <span class="text-sm text-secondary-600 dark:text-secondary-400">System Status</span>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-400">
                        <svg class="w-2 h-2 mr-1 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                            <circle cx="10" cy="10" r="10"></circle>
                        </svg>
                        Operational
                    </span>
                </div>

                <div class="flex items-center justify-between p-3 bg-secondary-50 dark:bg-secondary-900 rounded-lg">
                    <span class="text-sm text-secondary-600 dark:text-secondary-400">Database</span>
                    <span class="text-sm font-medium text-secondary-900 dark:text-white">SQLite</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-secondary-50 dark:bg-secondary-900 rounded-lg">
                    <span class="text-sm text-secondary-600 dark:text-secondary-400">Laravel Version</span>
                    <span class="text-sm font-medium text-secondary-900 dark:text-white">12.32.5</span>
                </div>

                <div class="flex items-center justify-between p-3 bg-secondary-50 dark:bg-secondary-900 rounded-lg">
                    <span class="text-sm text-secondary-600 dark:text-secondary-400">Last Updated</span>
                    <span class="text-sm font-medium text-secondary-900 dark:text-white">{{ now()->format('M d, Y H:i') }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Placeholder -->
    <div class="mt-6 bg-white dark:bg-secondary-800 rounded-lg shadow p-6 animate-slide-up border border-secondary-200 dark:border-secondary-700" style="animation-delay: 0.6s;">
        <h3 class="text-lg font-semibold text-secondary-900 dark:text-white mb-4">Recent Activity</h3>
        <div class="text-center py-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-secondary-100 dark:bg-secondary-900 rounded-lg mb-4">
                <svg class="w-8 h-8 text-secondary-400 dark:text-secondary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <p class="text-secondary-500 dark:text-secondary-400 text-sm">No recent activity to display</p>
            <p class="text-secondary-400 dark:text-secondary-500 text-xs mt-1">Activity will appear here as you use the system</p>
        </div>
    </div>
</div>

<!-- Department Modal -->
<div id="departmentModal" class="hidden fixed inset-0 bg-black/50 dark:bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-secondary-800 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
        <form method="POST" action="{{ route('departments.store') }}">
            @csrf
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-200 dark:border-secondary-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-white">Create Department</h3>
                        <p class="text-sm text-secondary-500 dark:text-secondary-400">Add a new department</p>
                    </div>
                </div>
                <button type="button" onclick="closeDepartmentModal()" class="text-secondary-400 hover:text-secondary-600 dark:hover:text-secondary-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6">
                <div>
                    <label for="department_name" class="block text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-1">Department Name</label>
                    <input type="text" id="department_name" name="name" required class="block w-full px-3 py-2 border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-900 text-secondary-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-blue-500 dark:focus:border-blue-400" placeholder="Enter department name">
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 bg-secondary-50 dark:bg-secondary-900 border-t border-secondary-200 dark:border-secondary-700">
                <button type="button" onclick="closeDepartmentModal()" class="px-4 py-2 text-sm font-medium text-secondary-700 dark:text-secondary-300 bg-white dark:bg-secondary-800 border border-secondary-300 dark:border-secondary-600 rounded-lg hover:bg-secondary-50 dark:hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    Create Department
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Worker Modal -->
<div id="workerModal" class="hidden fixed inset-0 bg-black/50 dark:bg-black/70 z-50 flex items-center justify-center p-4">
    <div class="bg-white dark:bg-secondary-800 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
        <form method="POST" action="{{ route('workers.store') }}">
            @csrf
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-6 border-b border-secondary-200 dark:border-secondary-700">
                <div class="flex items-center">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/30 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-lg font-semibold text-secondary-900 dark:text-white">Create Worker</h3>
                        <p class="text-sm text-secondary-500 dark:text-secondary-400">Add a new team member</p>
                    </div>
                </div>
                <button type="button" onclick="closeWorkerModal()" class="text-secondary-400 hover:text-secondary-600 dark:hover:text-secondary-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-6 space-y-4">
                <div>
                    <label for="worker_name" class="block text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-1">Worker Name</label>
                    <input type="text" id="worker_name" name="name" required class="block w-full px-3 py-2 border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-900 text-secondary-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400" placeholder="Enter worker name">
                </div>

                <div>
                    <label for="worker_department_id" class="block text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-1">Department</label>
                    <select id="worker_department_id" name="department_id" required class="block w-full px-3 py-2 border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-900 text-secondary-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400">
                        <option value="">Select a department</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}">{{ $department->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="worker_skills" class="block text-sm font-medium text-secondary-700 dark:text-secondary-300 mb-1">Skills</label>
                    <textarea id="worker_skills" name="skills" rows="3" class="block w-full px-3 py-2 border border-secondary-300 dark:border-secondary-600 rounded-lg bg-white dark:bg-secondary-900 text-secondary-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400 focus:border-green-500 dark:focus:border-green-400" placeholder="Enter skills separated by commas"></textarea>
                    <p class="mt-1 text-xs text-secondary-500 dark:text-secondary-400">Enter worker skills separated by commas (e.g., milking, feeding, equipment maintenance)</p>
                </div>

                <div class="bg-secondary-50 dark:bg-secondary-900 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex items-center h-5">
                            <input id="worker_is_supervisor" name="is_supervisor" type="checkbox" value="1" class="h-4 w-4 text-green-600 dark:text-green-500 border-secondary-300 dark:border-secondary-600 rounded focus:ring-green-500 dark:focus:ring-green-400">
                        </div>
                        <div class="ml-3">
                            <label for="worker_is_supervisor" class="text-sm font-medium text-secondary-900 dark:text-white">Supervisor Role</label>
                            <p class="text-sm text-secondary-500 dark:text-secondary-400">Check if this worker will have supervisor responsibilities</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="flex items-center justify-end gap-3 p-6 bg-secondary-50 dark:bg-secondary-900 border-t border-secondary-200 dark:border-secondary-700">
                <button type="button" onclick="closeWorkerModal()" class="px-4 py-2 text-sm font-medium text-secondary-700 dark:text-secondary-300 bg-white dark:bg-secondary-800 border border-secondary-300 dark:border-secondary-600 rounded-lg hover:bg-secondary-50 dark:hover:bg-secondary-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-green-600 hover:bg-green-700 dark:bg-green-500 dark:hover:bg-green-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500">
                    Create Worker
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function openDepartmentModal() {
        document.getElementById('departmentModal').classList.remove('hidden');
    }

    function closeDepartmentModal() {
        document.getElementById('departmentModal').classList.add('hidden');
    }

    function openWorkerModal() {
        document.getElementById('workerModal').classList.remove('hidden');
    }

    function closeWorkerModal() {
        document.getElementById('workerModal').classList.add('hidden');
    }

    // Close modals when clicking outside
    document.getElementById('departmentModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeDepartmentModal();
        }
    });

    document.getElementById('workerModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closeWorkerModal();
        }
    });

    // Close modals with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeDepartmentModal();
            closeWorkerModal();
        }
    });
</script>
@endsection