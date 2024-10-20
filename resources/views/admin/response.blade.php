@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Response List</h1>
        <table class="min-w-full bg-white border border-gray-200 shadow-md">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-700">No</th>
                    <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-700">Complaint</th>
                    <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-700">Responded by (Admin)</th>
                    <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-700">Response</th>
                    <th class="px-4 py-2 border text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($responses as $key => $response)
                    <tr class="border-t">
                        <td class="px-4 py-2 border text-sm text-gray-700">{{ $key + 1 }}</td>
                        <td class="px-4 py-2 border text-sm text-gray-700">{{ $response->complaint->title }}</td>
                        <td class="px-4 py-2 border text-sm text-gray-700">{{ $response->admin->name }}</td>
                        <td class="px-4 py-2 border text-sm text-gray-700">{{ $response->response_text }}</td>
                        <td class="px-4 py-2 border text-center">
                            <a href="{{ route('response.detail', $response->id) }}"
                                class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-4 rounded">Details</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
