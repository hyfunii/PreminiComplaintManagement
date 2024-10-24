@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="w-full max-w-lg mx-auto bg-white p-8 shadow-md rounded-lg">
            <h1 class="text-2xl font-bold mb-6">File a Complaint</h1>

            @if (session('success'))
                <div id="toast-top-left"
                    class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow top-5 left-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800"
                    role="alert">
                    <div class="text-sm font-normal">Top left positioning.</div>
                </div>
            @elseif (session('error'))
                <div id="toast-bottom-left"
                    class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow bottom-5 left-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800 z-50"
                    role="alert">
                    <div
                        class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-orange-500 bg-orange-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Check icon</span>
                    </div>
                    <div class="text-sm font-normal">{{ session('error') }}</div>
                </div>
            @endif

            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-bold mb-2">Name:</label>
                    <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" readonly
                        class="w-full p-2 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                </div>

                <div class="mb-4">
                    <label for="category_id" class="block text-gray-700 font-bold mb-2">Category:</label>
                    <select name="category_id" id="category_id"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('category_id') border-red-500 @enderror">
                        <option value="">Select Category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="title" class="block text-gray-700 font-bold mb-2">Complaint Title:</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('title') border-red-500 @enderror"
                        placeholder="Enter complaint title">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="description" class="block text-gray-700 font-bold mb-2">Complaint Description:</label>
                    <textarea name="description" id="description" rows="4"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('description') border-red-500 @enderror"
                        placeholder="Describe your complaint">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="file_path" class="block text-gray-700 font-bold mb-2">Document (Optional):</label>
                    <input type="file" name="file_path" id="file_path" accept=".png, .jpg, .jpeg"
                        class="w-full p-2 border border-gray-300 rounded-lg @error('file_path') border-red-500 @enderror">
                    <p class="text-gray-600 text-sm mt-1">Allowed formats: PNG, JPG, JPEG</p>
                    @error('file_path')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end mt-6">
                    <button type="submit"
                        class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">
                        Submit Complaint
                    </button>
                    <a href="{{ route('complaints.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded ml-2 text-center">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
