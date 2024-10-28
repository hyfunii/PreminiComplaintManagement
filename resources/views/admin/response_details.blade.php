@extends('layouts.app')


@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Response Details</h1>
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="border-b pb-4 mb-4">
                <h2 class="text-xl font-semibold">{{ $response->complaint->title }}</h2>
            </div>
            <div class="mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Responded by:</h5>
                <p class="text-gray-700">{{ $response->admin->name }}</p>
            </div>

            <div class="mb-4">
                <h5 class="text-lg font-semibold text-gray-800">Response:</h5>
                <p class="text-gray-700">{{ $response->response_text }}</p>
            </div>
            @if ($response->complaint->file_path && file_exists(public_path('storage/' . $response->complaint->file_path)))
                <p><strong>Attached File:</strong></p>
                <div class="flex items-center max-w-3xl w-1/2 p-4">
                    <img id="complaintImage" src="{{ asset('storage/' . $response->complaint->file_path) }}" alt="Complaint File"
                        class="w-full h-auto object-contain">

                    <div class="flex flex-col space-y-2 ml-4 m-4">
                        <a href="{{ asset('storage/' . $response->complaint->file_path) }}" download
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

            <a href="{{ route('response.index') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
                Back to Response List
            </a>
        </div>
    </div>
@endsection
