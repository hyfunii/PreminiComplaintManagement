@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Complaint Details</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
            <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
            <p class="text-gray-600">Description: {{ $complaint->description }}</p>
            <p class="text-gray-600">Status:
                <span
                    class="text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                    {{ $complaint->status->name }}
                </span>
            </p>
            <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>
            @if ($complaint->file_path && file_exists(public_path('storage/' . $complaint->file_path)))
                <p><strong>Attached File:</strong></p>
                <div class="flex items-center max-w-3xl w-1/2 p-4">
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
            @else
                <div class="mb-4">
                    <p><strong>Attached File:</strong> No document Attached</p>
                </div>
            @endif

            <hr class="my-4">

            <h3 class="text-lg font-semibold text-gray-800">Admin Response:</h3>
            @if ($response)
                <p class="text-gray-600">Responded by: {{ $response->admin->name }}</p>
                <p class="text-gray-600">{{ $response->response_text }}</p>
            @else
                <p class="text-red-500">This complaint has not been responded to yet.</p>
            @endif
        </div>
        <div class="mt-6 flex justify-end">
            <a href="{{ route('complaints.dashboard') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">
                Back
            </a>
        </div>
    </div>
@endsection
