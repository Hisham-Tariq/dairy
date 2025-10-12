@extends('layouts.app')

@section('title', 'Record Purchase')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 mb-2">Record Purchase</h1>
                <p class="text-secondary-600">Add a new purchase record for products brought from the store.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('brought-products.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Brought Products
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl mx-auto">
        <form method="POST" action="{{ route('brought-products.store') }}">
            @csrf
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-secondary-900">Purchase Details</h3>
                            <p class="text-sm text-secondary-500">Record the purchase information</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="product_id" class="form-label">Product</label>
                        <select id="product_id" name="product_id" required class="form-input @error('product_id') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror">
                            <option value="">Select a product</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="quantity" class="form-label">Quantity</label>
                        <input type="number" id="quantity" name="quantity" value="{{ old('quantity') }}" required min="1" class="form-input @error('quantity') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Enter quantity">
                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div>
                        <label for="comments" class="form-label">Comments (Optional)</label>
                        <textarea id="comments" name="comments" rows="4" class="form-input @error('comments') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Add any additional notes or comments...">{{ old('comments') }}</textarea>
                        @error('comments')
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
                <a href="{{ route('brought-products.index') }}" class="btn btn-secondary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Record Purchase
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
