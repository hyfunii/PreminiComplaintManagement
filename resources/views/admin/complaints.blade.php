@extends('layouts.app')

@section('content')

<!-- Complaints Table -->
<div class="container mx-auto py-8">
    <h2 class="text-2xl font-bold mb-6">Complaints Data</h2>
    <div class="relative overflow-x-auto shadow-md rounded-lg">
        <table class="min-w-full bg-white border border-gray-200 shadow-md">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left">Username</th>
                    <th scope="col" class="px-6 py-3 text-left">Complaint Description</th>
                    <th scope="col" class="px-6 py-3 text-left">Category</th>
                    <th scope="col" class="px-6 py-3 text-left">Complaint Date</th>
                    <th scope="col" class="px-6 py-3 text-left">Progress</th>
                    <th scope="col" class="px-6 py-3 text-left">Doc</th>
                    <th scope="col" class="px-6 py-3 text-left">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $complaint)
                <tr class="border-b bg-white odd:bg-gray-50 even:bg-gray-100">
                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
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
                    <td class="px-6 py-4 text-{{ $complaint->status->name == 'Not Processed' ? 'red' : ($complaint->status->name == 'Under Review' ? 'orange' : 'green') }}-600">
                        {{ $complaint->status->name }}
                    </td>
                    <td class="px-6 py-4">
                        @if ($complaint->file_path)
                            <button onclick="showImage('{{ asset('storage/' . $complaint->file_path) }}')" class="text-green-600 hover:underline">
                                Show
                            </button>
                        @else
                            <span class="text-gray-500">No Doc</span>
                        @endif
                    </td>
                    <td class="px-6 py-4">
                        <a href="#" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold py-1 px-4 rounded">Response</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal to display image -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 flex justify-center items-center">
    <div class="relative max-w-3xl w-1/2 p-4 bg-white rounded-lg shadow-lg">
        <img id="complaintImage" class="w-full h-auto max-h-[80vh] object-contain" src="" alt="Complaint Proof">
        <button onclick="closeImage()" class="absolute top-2 right-2 bg-white px-2 py-1 text-black rounded-lg border border-gray-300">Close</button>
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
