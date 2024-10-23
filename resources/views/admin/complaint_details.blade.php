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
                    <span class="text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
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
                <div class="mb-4">
                    <p><strong>Attached File:</strong></p>
                    <img src="{{ asset('storage/' . $complaint->file_path) }}" alt="Complaint File" class="w-full h-48 object-cover rounded-md">
                </div>
            @else
                <div class="mb-4">
                    <p><strong>Attached File:</strong> No document</p>
                </div>
            @endif

            <div class="flex justify-end mt-6">
                <a href="{{ route('complaints.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white py-2 px-4 rounded">Back</a>
            </div>
        </div>
    </div>
@endsection
