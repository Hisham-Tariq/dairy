@extends('layouts.app')

@section('title', 'Create Dairy Production')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 mb-2">Create Dairy Production</h1>
                <p class="text-secondary-600">Create a new production batch with workers and details.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('dairy-productions.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Productions
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card max-w-4xl mx-auto">
        <form method="POST" action="{{ route('dairy-productions.store') }}" id="productionForm">
            @csrf
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Product Selection -->
                    <div>
                        <label for="product_id" class="form-label">Product</label>
                        <select id="product_id" name="product_id" required class="form-input @error('product_id') border-red-500 @enderror">
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-temp="{{ $product->temperature }}" data-time="{{ $product->time }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Baking Temperature & Time (Auto-filled) -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="baking_temp" class="form-label">Baking Temperature (°C)</label>
                            <input type="number" step="0.01" id="baking_temp" name="baking_temp" value="{{ old('baking_temp') }}" required readonly class="form-input bg-gray-50 @error('baking_temp') border-red-500 @enderror" placeholder="Auto-filled">
                            @error('baking_temp')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="baking_time" class="form-label">Baking Time (minutes)</label>
                            <input type="number" id="baking_time" name="baking_time" value="{{ old('baking_time') }}" required readonly class="form-input bg-gray-50 @error('baking_time') border-red-500 @enderror" placeholder="Auto-filled">
                            @error('baking_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Mixer Selection (Multiple) -->
                    <div>
                        <label class="form-label">Mixers (Select Multiple)</label>
                        <div class="relative">
                            <button type="button" id="mixerDropdownBtn" class="form-input w-full text-left flex justify-between items-center @error('mixer_ids') border-red-500 @enderror">
                                <span id="mixerSelectedText" class="text-gray-400">Select mixers...</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="mixerDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach($mixers as $mixer)
                                    <label class="flex items-center px-4 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="mixer_ids[]" value="{{ $mixer->id }}" class="mixer-checkbox mr-3 h-4 w-4 text-blue-600 rounded" {{ in_array($mixer->id, old('mixer_ids', [])) ? 'checked' : '' }}>
                                        <span>{{ $mixer->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('mixer_ids')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supervisor Selection -->
                    <div>
                        <label for="supervisor_id" class="form-label">Packing Line Supervisor</label>
                        <select id="supervisor_id" name="supervisor_id" required class="form-input @error('supervisor_id') border-red-500 @enderror">
                            <option value="">Select a supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}" {{ old('supervisor_id') == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supervisor_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Number of Trays, Total Bowls, Total Tables -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div>
                            <label for="number_of_trays" class="form-label">Number of Trays</label>
                            <input type="number" id="number_of_trays" name="number_of_trays" value="{{ old('number_of_trays') }}" required min="1" class="form-input @error('number_of_trays') border-red-500 @enderror" placeholder="Enter trays">
                            @error('number_of_trays')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="total_bowls" class="form-label">Total Bowls</label>
                            <input type="number" id="total_bowls" name="total_bowls" value="{{ old('total_bowls') }}" min="1" class="form-input @error('total_bowls') border-red-500 @enderror" placeholder="Enter bowls">
                            @error('total_bowls')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="total_tables" class="form-label">Total Tables</label>
                            <input type="number" id="total_tables" name="total_tables" value="{{ old('total_tables') }}" min="1" class="form-input @error('total_tables') border-red-500 @enderror" placeholder="Enter tables">
                            @error('total_tables')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <p class="text-sm text-secondary-500">Batch number will be auto-generated: YYYYMMDD + Tray count</p>

                    <!-- Packing Machine Workers (Multiple) -->
                    <!-- <div>
                        <label class="form-label">Packing Machine Workers (Select Multiple)</label>
                        <div class="relative">
                            <button type="button" id="packingWorkerDropdownBtn" class="form-input w-full text-left flex justify-between items-center @error('packing_worker_ids') border-red-500 @enderror">
                                <span id="packingWorkerSelectedText" class="text-gray-400">Select packing workers...</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        
                        </div>
                        @error('packing_worker_ids')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div> -->

                    <!-- Prep & Deposit Helpers (Multiple with Table Numbers) -->

                  


                    <div>
                        <label class="form-label">Prep & Deposit Helpers (Select Multiple)</label>
                        <div class="relative">
                            <button type="button" id="helperDropdownBtn" class="form-input w-full text-left flex justify-between items-center @error('helper_ids') border-red-500 @enderror">
                                <span id="helperSelectedText" class="text-gray-400">Select helpers...</span>
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="helperDropdown" class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-300 rounded-lg shadow-lg max-h-60 overflow-y-auto">
                                @foreach($helpers as $helper)
                                    <label class="flex items-center px-4 py-2 hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="helper_ids[]" value="{{ $helper->id }}" class="helper-checkbox mr-3 h-4 w-4 text-blue-600 rounded" data-name="{{ $helper->name }}" {{ in_array($helper->id, old('helper_ids', [])) ? 'checked' : '' }}>
                                        <span>{{ $helper->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        @error('helper_ids')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        
                        <!-- Selected Helpers with Table Numbers -->
                        <div id="selectedHelpersContainer" class="mt-4 space-y-2">
                            <!-- Selected helpers will appear here -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-secondary-50 px-6 py-4 flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0 rounded-b-xl">
                <a href="{{ route('dairy-productions.index') }}" class="btn btn-secondary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Production
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const bakingTempInput = document.getElementById('baking_temp');
    const bakingTimeInput = document.getElementById('baking_time');

    // Auto-fill temperature and time when product is selected
    productSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (selectedOption.value) {
            bakingTempInput.value = selectedOption.dataset.temp;
            bakingTimeInput.value = selectedOption.dataset.time;
        } else {
            bakingTempInput.value = '';
            bakingTimeInput.value = '';
        }
    });

    // Mixer Dropdown
    const mixerDropdownBtn = document.getElementById('mixerDropdownBtn');
    const mixerDropdown = document.getElementById('mixerDropdown');
    const mixerSelectedText = document.getElementById('mixerSelectedText');
    const mixerCheckboxes = document.querySelectorAll('.mixer-checkbox');

    mixerDropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        mixerDropdown.classList.toggle('hidden');
    });

    mixerCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateMixerText);
    });

    function updateMixerText() {
        const selected = Array.from(mixerCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.parentElement.textContent.trim());
        
        if (selected.length > 0) {
            mixerSelectedText.textContent = selected.join(', ');
            mixerSelectedText.classList.remove('text-gray-400');
        } else {
            mixerSelectedText.textContent = 'Select mixers...';
            mixerSelectedText.classList.add('text-gray-400');
        }
    }

    // Packing Worker Dropdown
    const packingWorkerDropdownBtn = document.getElementById('packingWorkerDropdownBtn');
    const packingWorkerDropdown = document.getElementById('packingWorkerDropdown');
    const packingWorkerSelectedText = document.getElementById('packingWorkerSelectedText');
    const packingWorkerCheckboxes = document.querySelectorAll('.packing-worker-checkbox');

    // packingWorkerDropdownBtn.addEventListener('click', function(e) {
    //     e.preventDefault();
    //     packingWorkerDropdown.classList.toggle('hidden');
    // });

    packingWorkerCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updatePackingWorkerText);
    });

    function updatePackingWorkerText() {
        const selected = Array.from(packingWorkerCheckboxes)
            .filter(cb => cb.checked)
            .map(cb => cb.parentElement.textContent.trim());
        
        if (selected.length > 0) {
            packingWorkerSelectedText.textContent = selected.join(', ');
            packingWorkerSelectedText.classList.remove('text-gray-400');
        } else {
            packingWorkerSelectedText.textContent = 'Select packing workers...';
            packingWorkerSelectedText.classList.add('text-gray-400');
        }
    }

    // Helper Dropdown with Table Numbers
    const helperDropdownBtn = document.getElementById('helperDropdownBtn');
    const helperDropdown = document.getElementById('helperDropdown');
    const helperSelectedText = document.getElementById('helperSelectedText');
    const helperCheckboxes = document.querySelectorAll('.helper-checkbox');
    const selectedHelpersContainer = document.getElementById('selectedHelpersContainer');

    helperDropdownBtn.addEventListener('click', function(e) {
        e.preventDefault();
        helperDropdown.classList.toggle('hidden');
    });

    helperCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateHelperSelection);
    });

    function updateHelperSelection() {
        const selected = Array.from(helperCheckboxes).filter(cb => cb.checked);
        
        if (selected.length > 0) {
            helperSelectedText.textContent = selected.map(cb => cb.dataset.name).join(', ');
            helperSelectedText.classList.remove('text-gray-400');
        } else {
            helperSelectedText.textContent = 'Select helpers...';
            helperSelectedText.classList.add('text-gray-400');
        }

        // Update table number inputs
        selectedHelpersContainer.innerHTML = '';
        selected.forEach(checkbox => {
            const helperDiv = document.createElement('div');
            helperDiv.className = 'flex items-center gap-3 p-3 bg-gray-50 rounded-lg';
            helperDiv.innerHTML = `
                <div class="flex-1 font-medium text-gray-700">${checkbox.dataset.name}</div>
                <div class="w-32">
                    <input type="number" name="helper_table_numbers[]" placeholder="Table #" class="form-input" min="1">
                </div>
            `;
            selectedHelpersContainer.appendChild(helperDiv);
        });
    }

    // Close dropdowns when clicking outside
    document.addEventListener('click', function(e) {
        if (!mixerDropdownBtn.contains(e.target) && !mixerDropdown.contains(e.target)) {
            mixerDropdown.classList.add('hidden');
        }
        if (!packingWorkerDropdownBtn.contains(e.target) && !packingWorkerDropdown.contains(e.target)) {
            packingWorkerDropdown.classList.add('hidden');
        }
        if (!helperDropdownBtn.contains(e.target) && !helperDropdown.contains(e.target)) {
            helperDropdown.classList.add('hidden');
        }
    });

    // Initialize text on page load (for old values)
    updateMixerText();
    updatePackingWorkerText();
    updateHelperSelection();
});
</script>
@endsection