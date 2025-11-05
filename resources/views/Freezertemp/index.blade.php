@extends('layouts.app')

@section('title', 'Freezer Temperature Records')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 mb-2">Freezer Temperature Records</h1>
                <p class="text-secondary-600">Monitor and record freezer temperatures for raw products.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button onclick="openCreateModal()" class="btn btn-primary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Record Temperature
                </button>
            </div>
        </div>
    </div>

    <!-- Search & Filter -->
    <div class="card p-6 mb-6">
        <form method="GET" action="{{ route('Freezertemp.index') }}">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                <div class="sm:col-span-2">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-secondary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by product or recorder..." class="form-input pl-10">
                    </div>
                </div>
                <div class="flex gap-3">
                    <input type="date" name="date" value="{{ request('date') }}" class="form-input">
                    <button type="submit" class="btn btn-primary whitespace-nowrap">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Table -->
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-secondary-200">
                <thead class="bg-secondary-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Date & Time
                        </th>
                    
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Temperature
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Recorded By
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Notes
                        </th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-secondary-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-secondary-200">
                    @forelse ($temperatures as $temp)
                        <tr class="hover:bg-secondary-50 transition-colors duration-200">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-secondary-900">
                                    {{ \Carbon\Carbon::parse($temp->recorded_at)->format('M d, Y') }}
                                </div>
                                <div class="text-sm text-secondary-500">
                                    {{ \Carbon\Carbon::parse($temp->recorded_at)->format('h:i A') }}
                                </div>
                            </td>
                       
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                    {{ $temp->temperature <= 0 ? 'bg-green-100 text-green-800' : ($temp->temperature <= 5 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 8h6m-5 0a3 3 0 110 6H9l3 3m-3-6h6m6 1a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    {{ $temp->temperature }}°C
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-8 w-8 bg-primary-100 rounded-full flex items-center justify-center">
                                        <span class="text-xs font-medium text-primary-600">
                                            {{ strtoupper(substr($temp->recordedBy->name, 0, 2)) }}
                                        </span>
                                    </div>
                                    <div class="ml-3">
                                        <div class="text-sm font-medium text-secondary-900">{{ $temp->recordedBy->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-secondary-500 max-w-xs truncate">
                                    {{ $temp->notes ?? 'No notes' }}
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex items-center justify-end space-x-2">
                                    <button onclick='openEditModal(@json($temp))' class="btn btn-secondary">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                        </svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('Freezertemp.destroy', $temp) }}" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this record?')">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center">
                                <div class="flex flex-col items-center">
                                    <svg class="w-12 h-12 text-secondary-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    <p class="text-secondary-500 text-sm font-medium">No temperature records found</p>
                                    <p class="text-secondary-400 text-xs mt-1">Start recording freezer temperatures</p>
                                    <button onclick="openCreateModal()" class="btn btn-primary mt-3">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                        Record Temperature
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Pagination -->
    @if ($temperatures->hasPages())
        <div class="mt-6 flex items-center justify-between">
            <div class="flex-1 flex justify-between sm:hidden">
                {{ $temperatures->links() }}
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                <div>
                    <p class="text-sm text-secondary-700">
                        Showing <span class="font-medium">{{ $temperatures->firstItem() }}</span> to <span class="font-medium">{{ $temperatures->lastItem() }}</span> of <span class="font-medium">{{ $temperatures->total() }}</span> results
                    </p>
                </div>
                <div>
                    {{ $temperatures->links() }}
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Modal -->
<div id="tempModal" class="hidden" style="position: fixed; inset: 0; z-index: 50; overflow-y: auto; background-color: rgba(0, 0, 0, 0.75);">
    <div style="display: flex; align-items: center; justify-content: center; min-height: 100vh; padding: 1rem;">
        <div style="background-color: white; border-radius: 0.5rem; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04); max-width: 42rem; width: 100%; max-height: 85vh; overflow-y: auto;">
            <form id="tempForm" method="POST">
                @csrf
                <div id="methodField"></div>

                <div class="p-6 border-b border-secondary-200">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-medium text-secondary-900" id="modalTitle">Record Temperature</h3>
                        <button type="button" onclick="closeModal()" class="text-secondary-400 hover:text-secondary-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-6 space-y-4">
                

                    <div>
                        <label for="temperature" class="form-label">Temperature (°C)</label>
                        <input type="number" step="0.01" id="temperature" name="temperature" required class="form-input" placeholder="Enter temperature">
                    </div>

                    <div>
                        <label for="recorded_by" class="form-label">Recorded By</label>
                        <select id="recorded_by" name="recorded_by" required class="form-input">
                            <option value="">Select a worker</option>
                            @foreach($workers as $worker)
                                <option value="{{ $worker->id }}">{{ $worker->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="recorded_at" class="form-label">Date & Time</label>
                        <input type="datetime-local" id="recorded_at" name="recorded_at" required class="form-input">
                    </div>

                    <div>
                        <label for="notes" class="form-label">Notes (Optional)</label>
                        <textarea id="notes" name="notes" rows="3" class="form-input" placeholder="Add any additional notes..."></textarea>
                    </div>
                </div>

                <div class="bg-secondary-50 px-6 py-4 flex justify-end space-x-3 rounded-b-lg">
                    <button type="button" onclick="closeModal()" class="btn btn-secondary">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save Record</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Set current datetime on page load
document.addEventListener('DOMContentLoaded', function() {
    setCurrentDateTime();
});

function setCurrentDateTime() {
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const datetime = `${year}-${month}-${day}T${hours}:${minutes}`;
    document.getElementById('recorded_at').value = datetime;
}

function openCreateModal() {
    document.getElementById('modalTitle').textContent = 'Record Temperature';
    document.getElementById('tempForm').action = '{{ route('Freezertemp.store') }}';
    document.getElementById('methodField').innerHTML = '';
    document.getElementById('temperature').value = '';
    document.getElementById('recorded_by').value = '';
    document.getElementById('notes').value = '';
    setCurrentDateTime();

    document.getElementById('tempModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function openEditModal(temp) {
    document.getElementById('modalTitle').textContent = 'Edit Temperature Record';
    document.getElementById('tempForm').action = `/freezer-temperatures/${temp.id}`;
    document.getElementById('methodField').innerHTML = '@method("PUT")';
    document.getElementById('temperature').value = temp.temperature;
    document.getElementById('recorded_by').value = temp.recorded_by;
    document.getElementById('notes').value = temp.notes || '';
    
    // Format datetime for input
    const recordedAt = new Date(temp.recorded_at);
    const year = recordedAt.getFullYear();
    const month = String(recordedAt.getMonth() + 1).padStart(2, '0');
    const day = String(recordedAt.getDate()).padStart(2, '0');
    const hours = String(recordedAt.getHours()).padStart(2, '0');
    const minutes = String(recordedAt.getMinutes()).padStart(2, '0');
    document.getElementById('recorded_at').value = `${year}-${month}-${day}T${hours}:${minutes}`;

    document.getElementById('tempModal').classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    document.getElementById('tempModal').classList.add('hidden');
    document.body.style.overflow = '';
}

// Close modal on escape key
document.addEventListener('keydown', function(event) {
    if (event.key === 'Escape') {
        const modal = document.getElementById('tempModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeModal();
        }
    }
});

// Close modal on backdrop click
document.getElementById('tempModal').addEventListener('click', function(event) {
    if (event.target === this) {
        closeModal();
    }
});
</script>
@endsection