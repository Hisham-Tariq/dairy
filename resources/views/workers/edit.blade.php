@extends('layouts.app')

@section('title', 'Edit Worker')

@section('content')
<div class="p-6">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-3xl font-bold text-secondary-900 mb-2">Edit Worker</h1>
                <p class="text-secondary-600">Update team member information for your dairy management system.</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <a href="{{ route('workers.index') }}" class="btn btn-secondary">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Workers
                </a>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="card max-w-2xl mx-auto">
        <form method="POST" action="{{ route('workers.update', $worker) }}">
            @csrf
            @method('PUT')
            <div class="p-6">
                <div class="mb-6">
                    <div class="flex items-center mb-4">
                        <div class="flex-shrink-0 h-12 w-12 bg-success-100 rounded-lg flex items-center justify-center">
                            <svg class="h-6 w-6 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-medium text-secondary-900">Worker Information</h3>
                            <p class="text-sm text-secondary-500">Update the details for {{ $worker->name }}</p>
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="name" class="form-label">Worker Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $worker->name) }}" required class="form-input @error('name') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Enter worker name">
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
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $worker->department_id) == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
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
                        <label for="skills" class="form-label">Skills</label>
                        <textarea id="skills" name="skills" rows="3" class="form-input @error('skills') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror" placeholder="Enter worker skills separated by commas">{{ old('skills', $worker->skills) }}</textarea>
                        @error('skills')
                            <p class="mt-2 text-sm text-red-600">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                </svg>
                                {{ $message }}
                            </p>
                        @enderror
                        <p class="mt-2 text-sm text-secondary-500">Enter worker skills separated by commas (e.g., milking, feeding, equipment maintenance)</p>
                    </div>

                    <div class="bg-secondary-50 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex items-center h-5">
                                <input id="is_supervisor" name="is_supervisor" type="checkbox" value="1" {{ old('is_supervisor', $worker->is_supervisor) ? 'checked' : '' }} class="h-4 w-4 text-primary-600 border-secondary-300 rounded focus:ring-primary-500">
                            </div>
                            <div class="ml-3">
                                <label for="is_supervisor" class="text-sm font-medium text-secondary-900">Supervisor Role</label>
                                <p class="text-sm text-secondary-500">Check if this worker will have supervisor responsibilities and team leadership duties</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-secondary-50 px-6 py-4 flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0 rounded-b-xl">
                <a href="{{ route('workers.index') }}" class="btn btn-secondary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                    Cancel
                </a>
                <button type="submit" class="btn btn-primary w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Update Worker
                </button>
            </div>
        </form>
    </div>
</div>
@endsection