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
        <a href="{{ route('response.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 px-4 rounded">
            Back to Response List
        </a>
    </div>
</div>
@endsection
