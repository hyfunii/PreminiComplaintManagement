@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">My Complaints</h1>

        @if ($complaints->isEmpty())
            <p class="text-gray-600">You have not submitted any complaints yet.</p>
        @else
            <!-- Complaints list in a scrollable box -->
            <div class="bg-white shadow-md rounded-lg p-4 max-h-80 overflow-y-auto">
                <ul class="list-disc list-inside space-y-4">
                    @foreach ($complaints as $complaint)
                        <li class="bg-gray-100 shadow-md rounded-lg p-4 transition duration-200 ease-in-out transform hover:scale-105 hover:bg-gray-200">
                            <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
                            <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
                            <p class="text-gray-600">Status:
                                <span
                                    class="text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                                    {{ $complaint->status->name }}
                                </span>
                            </p>
                            <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>
                            <a href="{{ route('our_response', $complaint->id) }}"
                                class="mt-2 inline-block bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">
                                View Details
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Button to create new complaint -->
        <div class="mt-6 flex justify-end">
            <a href="{{ route('complaints.index') }}" 
               class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">
                Create Complaint
            </a>
        </div>
    </div>
@endsection
