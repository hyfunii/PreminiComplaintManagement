@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Complaint Details</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold mb-4">Complaint: {{ $complaint->title }}</h2>

            <div class="mb-4">
                <p><strong>Submitted by:</strong> {{ $complaint->user->name }}</p>
            </div>

            <div class="mb-4">
                <p><strong>Category:</strong> {{ $complaint->category->name }}</p>
            </div>

            <div class="mb-4">
                <p><strong>Status:</strong>
                    <span
                        class="text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                        {{ $complaint->status->name }}
                    </span>
                </p>
            </div>

            <div class="mb-4">
                <p><strong>Description:</strong></p>
                <p class="text-gray-600">{{ $complaint->description }}</p>
            </div>

            <div class="mb-4">
                <p><strong>Submitted on:</strong> {{ $complaint->created_at->format('M d, Y') }}</p>
            </div>

            @if ($complaint->file_path && file_exists(public_path('storage/' . $complaint->file_path)))
                <div class="relative max-w-3xl w-1/2 p-4 bg-white rounded-lg shadow-lg mb-4">
                    <p><strong>Attached File:</strong></p>
                    <div class="flex items-center">
                        <img id="complaintImage" src="{{ asset('storage/' . $complaint->file_path) }}" alt="Complaint File"
                            class="w-full h-auto object-contain">

                        <div class="flex flex-col space-y-2 ml-4 m-4">
                            <a href="{{ asset('storage/' . $complaint->file_path) }}" download
                                class="flex items-center p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v8m0 0l-4-4m4 4l4-4M21 15v2a2 2 0 01-2 2H5a2 2 0 01-2-2v-2" />
                                </svg>
                            </a>

                            <button id="fullscreenBtn"
                                class="flex items-center p-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 8H4a2 2 0 00-2 2v4a2 2 0 002 2h4m12-12h4a2 2 0 012 2v4a2 2 0 01-2 2h-4m-8 4h4m-4 0v-4m-4 0h4m0 0V4" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @else
                <div class="mb-4">
                    <p><strong>Attached File:</strong> No document</p>
                </div>
            @endif

            <div class="flex justify-end mt-6">
                <a href="{{ route('complaints.index') }}"
                    class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">Back</a>
            </div>
        </div>
    </div>
@endsection
