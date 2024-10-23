@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold mb-6">My Complaints</h1>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('complaints.index') }}"
                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105 mb-3">
                    Create Complaint
                </a>
            </div>
        </div>

        {{-- @if (session('success'))
            <div id="toast-bottom-left"
                class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow bottom-5 left-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800 z-50"
                role="alert">
                <!-- Icon -->
                <div
                    class="inline-flex items-center justify-center flex-shrink-0 w-8 h-8 text-green-500 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-200">
                    <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                        viewBox="0 0 20 20">
                        <path
                            d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                    </svg>
                    <span class="sr-only">Check icon</span>
                </div>
                <!-- Success Message -->
                <div class="text-sm font-normal">{{ session('success') }}</div>
            </div>
        @endif --}}

        @if ($complaints->isEmpty())
            <p class="text-gray-600">You have not submitted any complaints yet.</p>
        @else
            <ul class="list-disc list-inside space-y-4">
                @foreach ($complaints as $complaint)
                    <li
                        class="bg-gray-100 shadow-md rounded-lg p-4 transition duration-200 ease-in-out transform hover:scale-105 hover:bg-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
                        <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
                        <p class="text-gray-600">Status:
                            <span
                                class="text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                                {{ $complaint->status->name }}
                            </span>
                        </p>
                        <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>

                        <button onclick="openModal('{{ $complaint->id }}')"
                            class="mt-2 inline-block bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">
                            Edit
                        </button>

                        <a href="{{ route('our_response', $complaint->id) }}"
                            class="mt-2 inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">
                            View Details
                        </a>

                        <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST"
                            class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="mt-2 bg-red-500 hover:bg-red-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105"
                                onclick="return confirm('Are you sure you want to cancel this complaint?')">
                                Cancel Complaint
                            </button>
                        </form>
                    </li>

                    <div id="editModal{{ $complaint->id }}" class="fixed z-10 inset-0 overflow-y-auto hidden">
                        <div class="flex items-center justify-center min-h-screen">
                            <div class="relative bg-white w-full max-w-lg mx-auto p-8 rounded shadow-lg">
                                <button onclick="closeModal('{{ $complaint->id }}')"
                                    class="absolute top-2 right-2 text-gray-600">&times;</button>

                                <h2 class="text-xl font-semibold mb-4">Edit Complaint</h2>
                                <form action="{{ route('complaints.update', $complaint->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-4">
                                        <label for="title{{ $complaint->id }}"
                                            class="block text-sm font-medium text-gray-700">Title</label>
                                        <input type="text" name="title" id="title{{ $complaint->id }}"
                                            value="{{ $complaint->title }}"
                                            class="w-full p-2 border border-gray-300 rounded">
                                    </div>
                                    <div class="mb-4">
                                        <label for="description{{ $complaint->id }}"
                                            class="block text-sm font-medium text-gray-700">Description</label>
                                        <textarea name="description" id="description{{ $complaint->id }}" rows="4"
                                            class="w-full p-2 border border-gray-300 rounded">{{ $complaint->description }}</textarea>
                                    </div>
                                    <div class="mb-4">
                                        <label for="category_id{{ $complaint->id }}"
                                            class="block text-sm font-medium text-gray-700">Category</label>
                                        <select name="category_id" id="category_id{{ $complaint->id }}"
                                            class="w-full p-2 border border-gray-300 rounded">
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $complaint->category_id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="flex justify-end">
                                        <button type="submit"
                                            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
        @endif

    </div>

    <script>
        function openModal(id) {
            document.getElementById('editModal' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('editModal' + id).classList.add('hidden');
        }
    </script>
@endsection
