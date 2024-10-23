@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h2 class="text-2xl font-bold mb-6">Complaints Data</h2>

        <form action="{{ route('complaints.search') }}" method="GET" class="max-w-md mx-auto mb-4 ml-0">
            <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
                <input type="search" name="query" id="default-search"
                    class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Search Complaints..." required />
                <button type="submit"
                    class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
            </div>
        </form>

        <div class="relative overflow-y-auto h-screen shadow-md sm:rounded-lg">
            <table class="min-w-full bg-white border border-gray-200 shadow-md w-full max-w-[1000px]">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Username</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Complaint Description</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Category</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Complaint Date</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Progress</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Doc</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($complaints as $complaint)
                        <tr class="border-b bg-white odd:bg-gray-50 even:bg-gray-100">
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{ $complaint->user->name }}
                            </th>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $complaint->description }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $complaint->category->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $complaint->created_at->format('M d, Y') }}
                            </td>
                            <td
                                class="px-6 py-4 text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                                {{ $complaint->status->name }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($complaint->file_path)
                                    <button onclick="showImage('{{ asset('storage/' . $complaint->file_path) }}')"
                                        class="text-green-600 hover:underline">
                                        Show
                                    </button>
                                @else
                                    <span class="text-gray-500">No Doc</span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                <a href="{{ route('responses.create', ['complaint_id' => $complaint->id]) }}"
                                    class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-4 rounded">Response</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal to display image -->
    <div id="imageModal"
        class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-75 flex justify-center items-center">
        <div class="relative">
            <img id="complaintImage" class="max-w-full max-h-full" src="" alt="Complaint Proof">
            <button onclick="closeImage()" class="absolute top-2 right-2 bg-white px-2 py-1 text-black">Close</button>
        </div>

        <!-- Modal to display image -->
        <div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center">
            <div class="relative max-w-3xl w-1/2 p-4 bg-white rounded-lg shadow-lg">
                <img id="complaintImage" class="w-full h-auto max-h-[80vh] object-contain" src=""
                    alt="Complaint Proof">
                <button onclick="closeImage()"
                    class="absolute top-2 right-2 bg-white px-2 py-1 text-black rounded-lg border border-gray-300">Close</button>
            </div>
        </div>

        <script>
            function showImage(imagePath) {
                var modal = document.getElementById('imageModal');
                var image = document.getElementById('complaintImage');
                image.src = imagePath;
                modal.classList.remove('hidden');
            }

            function closeImage() {
                var modal = document.getElementById('imageModal');
                modal.classList.add('hidden');
            }
        </script>
    @endsection
