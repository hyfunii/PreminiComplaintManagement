@extends('layouts.app')
@section('content')


    <div class="p-4 sm:ml-64">
        <div class="p-4 rounded-lg dark:border-gray-700 mt-14">
            {{-- Display error messages if any --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <strong class="font-bold">Oops! </strong>
                    <span class="block sm:inline">{{ implode('', $errors->all(':message')) }}</span>
                </div>
            @endif

            <div class="bg-white shadow-md rounded-lg p-6">
                <h1 class="text-xl font-bold mb-6">Respond to Complaint</h1>

                {{-- Form to save the response --}}
                <form action="{{ route('responses.store') }}" method="POST">
                    @csrf

                    {{-- Display logged-in admin's name --}}
                    <div class="mb-4">
                        <label for="responder_name" class="block text-sm font-medium text-gray-700">Responding as:</label>
                        <input type="text" id="responder_name" name="responder_name"
                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                            value="{{ Auth::user()->name }}" readonly>
                    </div>

                    {{-- Display selected complaint title --}}
                    <div class="mb-4">
                        <label for="complaint_title" class="block text-sm font-medium text-gray-700">Complaint
                            Title:</label>
                        <input type="text" id="complaint_title" name="complaint_title"
                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md"
                            value="{{ $complaint->title }}" readonly>
                    </div>

                    {{-- Display selected complaint description --}}
                    <div class="mb-4">
                        <label for="complaint_description" class="block text-sm font-medium text-gray-700">Complaint
                            Description:</label>
                        <textarea id="complaint_description" name="complaint_description"
                            class="block w-full px-3 py-2 bg-gray-100 border border-gray-300 rounded-md" rows="4" readonly>{{ $complaint->description }}</textarea>
                    </div>

                    {{-- Admin's response input --}}
                    <div class="mb-4">
                        <label for="response_text" class="block text-sm font-medium text-gray-700">Response:</label>
                        <textarea id="response_text" name="response_text"
                            class="block w-full px-3 py-2 bg-white border border-gray-300 rounded-md" rows="4" required></textarea>
                    </div>

                    {{-- Hidden fields for admin and complaint IDs --}}
                    <input type="hidden" name="admin_id" value="{{ Auth::user()->id }}">
                    <input type="hidden" name="complaint_id" value="{{ $complaint->id }}">

                    {{-- Save button --}}
                    <div class="flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Save Response
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
