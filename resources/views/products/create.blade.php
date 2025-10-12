@extends('layouts.app')

@section('title', 'Create Product')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 mb-2">Create Product</h1>
                <p class="text-secondary-600">Add a new product to your dairy management system.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('products.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Products
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl mx-auto">
        <form method="POST" action="{{ route('products.store') }}">
            @csrf
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 bg-primary-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-secondary-900">Product Information</h3>
                            <p class="text-sm text-secondary-500">Enter the details for the new product</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="name" class="form-label">Product Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required class="form-input @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Enter product name">
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="department_id" class="form-label">Department</label>
                        <select id="department_id" name="department_id" required class="form-input @error('department_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select a department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="temperature" class="form-label">Temperature (°C)</label>
                        <input type="number" step="0.01" id="temperature" name="temperature" value="{{ old('temperature') }}" required class="form-input @error('temperature') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Enter temperature">
                        @error('temperature')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="time" class="form-label">Time (minutes)</label>
                        <input type="number" id="time" name="time" value="{{ old('time') }}" required class="form-input @error('time') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Enter time in minutes">
                        @error('time')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="production_type" class="form-label">Production Type</label>
                        <select id="production_type" name="production_type" required class="form-input @error('production_type') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select production type</option>
                            <option value="handmade" {{ old('production_type') == 'handmade' ? 'selected' : '' }}>Handmade</option>
                            <option value="machine" {{ old('production_type') == 'machine' ? 'selected' : '' }}>Machine</option>
                        </select>
                        @error('production_type')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="bg-secondary-50 px-6 py-4 flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0 rounded-b-xl">
                <a href="{{ route('products.index') }}" class="btn btn-secondary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create Product
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
