@extends('layouts.app')

@section('title', 'Edit Dairy Production')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 mb-2">Edit Dairy Production</h1>
                <p class="text-secondary-600">Update the production batch details.</p>
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
        <form method="POST" action="{{ route('dairy-productions.update', $dairyProduction) }}" id="productionForm">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="space-y-6">
                    <!-- Product Selection -->
                    <div>
                        <label for="product_id" class="form-label">Product</label>
                        <select id="product_id" name="product_id" required class="form-input @error('product_id') border-red-500 @enderror">
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-temp="{{ $product->temperature }}" data-time="{{ $product->time }}" {{ old('product_id', $dairyProduction->product_id) == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Baking Temperature & Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="baking_temp" class="form-label">Baking Temperature (°C)</label>
                            <input type="number" step="0.01" id="baking_temp" name="baking_temp" value="{{ old('baking_temp', $dairyProduction->baking_temp) }}" required readonly class="form-input bg-gray-50 @error('baking_temp') border-red-500 @enderror">
                            @error('baking_temp')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="baking_time" class="form-label">Baking Time (minutes)</label>
                            <input type="number" id="baking_time" name="baking_time" value="{{ old('baking_time', $dairyProduction->baking_time) }}" required readonly class="form-input bg-gray-50 @error('baking_time') border-red-500 @enderror">
                            @error('baking_time')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Mixer Selection -->
                    <div>
                        <label for="mixer_id" class="form-label">Mixer</label>
                        <select id="mixer_id" name="mixer_id" required class="form-input @error('mixer_id') border-red-500 @enderror">
                            <option value="">Select a mixer</option>
                            @foreach($mixers as $mixer)
                                <option value="{{ $mixer->id }}" {{ old('mixer_id', $dairyProduction->mixer_id) == $mixer->id ? 'selected' : '' }}>
                                    {{ $mixer->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('mixer_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Supervisor Selection -->
                    <div>
                        <label for="supervisor_id" class="form-label">Packing Line Supervisor</label>
                        <select id="supervisor_id" name="supervisor_id" required class="form-input @error('supervisor_id') border-red-500 @enderror">
                            <option value="">Select a supervisor</option>
                            @foreach($supervisors as $supervisor)
                                <option value="{{ $supervisor->id }}" {{ old('supervisor_id', $dairyProduction->supervisor_id) == $supervisor->id ? 'selected' : '' }}>
                                    {{ $supervisor->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('supervisor_id')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Number of Trays -->
                    <div>
                        <label for="number_of_trays" class="form-label">Number of Trays</label>
                        <input type="number" id="number_of_trays" name="number_of_trays" value="{{ old('number_of_trays', $dairyProduction->number_of_trays) }}" required min="1" class="form-input @error('number_of_trays') border-red-500 @enderror">
                        <p class="mt-1 text-sm text-secondary-500">Current batch: {{ $dairyProduction->batch_number }}</p>
                        @error('number_of_trays')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Prep & Deposit Helpers -->
                    <div>
                        <div class="flex items-center justify-between mb-3">
                            <label class="form-label mb-0">Prep & Deposit Helpers</label>
                            <button type="button" id="addHelper" class="btn btn-primary btn-sm">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Add Helper
                            </button>
                        </div>
                        <div id="helpersContainer" class="space-y-3">
                            @foreach($dairyProduction->helpers as $index => $helper)
                                <div class="flex gap-3 items-start helper-row">
                                    <div class="flex-1">
                                        <select name="helpers[{{ $index }}][worker_id]" required class="form-input">
                                            <option value="">Select helper</option>
                                            @foreach($helpers as $h)
                                                <option value="{{ $h->id }}" {{ $helper->worker_id == $h->id ? 'selected' : '' }}>
                                                    {{ $h->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="w-32">
                                        <input type="number" name="helpers[{{ $index }}][table_number]" value="{{ $helper->table_number }}" placeholder="Table #" class="form-input" min="1">
                                    </div>
                                    <button type="button" class="btn btn-danger btn-sm mt-1 remove-helper">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
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
                    Update Production
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
    const addHelperBtn = document.getElementById('addHelper');
    const helpersContainer = document.getElementById('helpersContainer');
    let helperIndex = {{ $dairyProduction->helpers->count() }};

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

    // Add helper row
    addHelperBtn.addEventListener('click', function() {
        const helperRow = document.createElement('div');
        helperRow.className = 'flex gap-3 items-start helper-row';
        helperRow.innerHTML = `
            <div class="flex-1">
                <select name="helpers[${helperIndex}][worker_id]" required class="form-input">
                    <option value="">Select helper</option>
                    @foreach($helpers as $helper)
                        <option value="{{ $helper->id }}">{{ $helper->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-32">
                <input type="number" name="helpers[${helperIndex}][table_number]" placeholder="Table #" class="form-input" min="1">
            </div>
            <button type="button" class="btn btn-danger btn-sm mt-1 remove-helper">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                </svg>
            </button>
        `;
        helpersContainer.appendChild(helperRow);
        helperIndex++;
    });

    // Remove helper row
    helpersContainer.addEventListener('click', function(e) {
        if (e.target.closest('.remove-helper')) {
            e.target.closest('.helper-row').remove();
        }
    });
});
</script>
@endsection
