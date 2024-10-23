@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Response List</h1>

        <form action="{{ route('response.search') }}" method="GET" class="max-w-md mx-auto mb-4 ml-0">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" name="query" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search responses..." required />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2">Search</button>
            </div>
        </form>

        <table class="min-w-full bg-white border border-gray-200 shadow-md w-full max-w-[1000px] mb-8">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Complaint</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Responded by</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Response</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Complaint Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($responses as $response)
                    <tr class="border-t">
                        <td class="px-6 py-4 text-gray-700">{{ $response->complaint->user->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $response->complaint->title }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $response->admin->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $response->response_text }}</td>
                        <td
                            class="px-6 py-4 text-{{ $response->complaint->status->name == 'Not Processed' ? 'red' : ($response->complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                            {{ $response->complaint->status->name }}
                        </td>
                        <td class="px-6 py-4 text-gray-700">
                            <a href="{{ route('response.detail', $response->id) }}"
                                class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">Details</a>
                            <a href="{{ route('response.cancel', $response->id) }}"
                                class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">Cancel</a>
                            <a href="{{ route('response.done', $response->id) }}"
                                class="bg-green-500 hover:bg-green-700 text-white font-semibold py-1 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">Done</a>
                        </td>                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="text-xl font-bold mb-4">Done Complaints</h2>
        <table class="min-w-full bg-white border border-gray-200 shadow-md w-full max-w-[1000px]">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">User</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Complaint</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Responded by</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Response</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Complaint Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($doneResponses as $response)
                    <tr class="border-t">
                        <td class="px-6 py-4 text-gray-700">{{ $response->complaint->user->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $response->complaint->title }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $response->admin->name }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $response->response_text }}</td>
                        <td
                            class="px-6 py-4 text-{{ $response->complaint->status->name == 'Not Processed' ? 'red' : ($response->complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                            {{ $response->complaint->status->name }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
