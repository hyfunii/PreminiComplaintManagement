@extends('layouts.app')
@section('content')
    <div class="p-4">
        <div class="p-4 rounded-lg dark:border-gray-700 mt-14">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops! </strong>
                    <span class="block sm:inline">{{ implode('', $errors->all(':message')) }}</span>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-xl font-bold mb-6">Respond to Complaint</h1>

                <form action="{{ route('responses.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="responder_name" class="block text-sm font-medium text-gray-700">Responding as:</label>
                        <input type="text" id="responder_name" name="responder_name"
                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="complaint_title" class="block text-sm font-medium text-gray-700">Complaint
                            Title:</label>
                        <input type="text" id="complaint_title" name="complaint_title"
                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                            value="{{ $complaint->title }}" readonly>
                    </div>

                    <div class="mb-4">
                        <label for="complaint_description" class="block text-sm font-medium text-gray-700">Complaint
                            Description:</label>
                        <textarea id="complaint_description" name="complaint_description"
                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md" rows="4" readonly>{{ $complaint->description }}</textarea>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Attached Document:</label>
                        @if ($complaint->file_path)
                            <img src="{{ asset('storage/' . $complaint->file_path) }}" alt="Attached Document"
                                class="mt-2 w-full h-auto rounded-md" />
                        @else
                            <p class="mt-2 text-gray-600">No document</p>
                        @endif
                    </div>

                    <div class="mb-4">
                        <label for="response_text" class="block text-sm font-medium text-gray-700">Response:</label>
                        <textarea id="response_text" name="response_text"
                            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md" rows="4" required></textarea>
                    </div>

                    <input type="hidden" name="admin_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="complaint_id" value="{{ $complaint->id }}">

                    <div class="flex justify-end">
                        <a href="{{ route('complaints.index') }}"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-2 rounded">Cancel</a>
                        <button type="submit"
                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 m-2 rounded">
                            Save Response
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
