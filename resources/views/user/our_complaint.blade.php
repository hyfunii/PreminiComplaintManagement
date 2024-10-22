@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">My Complaints</h1>

        @if (session('success'))
            <div id="toast-bottom-left"
                class="fixed flex items-center w-full max-w-xs p-4 space-x-4 text-gray-500 bg-white divide-x rtl:divide-x-reverse divide-gray-200 rounded-lg shadow bottom-5 left-5 dark:text-gray-400 dark:divide-gray-700 dark:bg-gray-800"
                role="alert">
                <div class="text-sm font-normal">Top left positioning.</div>
            </div>
        @endif

        @if ($complaints->isEmpty())
            <p class="text-gray-600">You have not submitted any complaints yet.</p>
        @else
            <div class="bg-white shadow-md rounded-lg p-4 max-h-80 overflow-y-auto">
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
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="mt-6 flex justify-end">
            <a href="{{ route('complaints.index') }}"
                class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">
                Create Complaint
            </a>
        </div>
    </div>
@endsection
