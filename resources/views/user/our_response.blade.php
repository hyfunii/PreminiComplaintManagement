@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Complaint Details</h1>

        <div class="bg-white shadow-md rounded-lg p-6">
            <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
            <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
            <p class="text-gray-600">Description: {{ $complaint->description }}</p>
            <p class="text-gray-600">Status: 
                <span class="text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                    {{ $complaint->status->name }}
                </span>
            </p>
            <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>

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
