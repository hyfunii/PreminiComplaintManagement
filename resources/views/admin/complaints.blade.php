@extends('layouts.app')
@section('content')

<!-- Complaints Table -->
<div class="relative overflow-x-auto shadow-md sm:rounded-lg">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    Username
                </th>
                <th scope="col" class="px-6 py-3">
                    Complaint Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Category
                </th>
                <th scope="col" class="px-6 py-3">
                    Complaint Date
                </th>
                <th scope="col" class="px-6 py-3">
                    Progress
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Andi
                </th>
                <td class="px-6 py-4">
                    Streetlight not working
                </td>
                <td class="px-6 py-4">
                    Infrastructure
                </td>
                <td class="px-6 py-4">
                    Oct 12, 2024
                </td>
                <td class="px-6 py-4 text-red-600">Not Processed</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/andi_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Budi
                </th>
                <td class="px-6 py-4">
                    Pothole in the road
                </td>
                <td class="px-6 py-4">
                    Infrastructure
                </td>
                <td class="px-6 py-4">
                    Oct 13, 2024
                </td>
                <td class="px-6 py-4 text-orange-600">Under Review</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/budi_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Siti
                </th>
                <td class="px-6 py-4">
                    Garbage pile up
                </td>
                <td class="px-6 py-4">
                    Sanitation
                </td>
                <td class="px-6 py-4">
                    Oct 14, 2024
                </td>
                <td class="px-6 py-4 text-green-600">Completed</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/siti_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Rina
                </th>
                <td class="px-6 py-4">
                    Broken bench in park
                </td>
                <td class="px-6 py-4">
                    Infrastructure
                </td>
                <td class="px-6 py-4">
                    Oct 15, 2024
                </td>
                <td class="px-6 py-4 text-red-600">Not Processed</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/rina_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Joko
                </th>
                <td class="px-6 py-4">
                    Water leakage
                </td>
                <td class="px-6 py-4">
                    Sanitation
                </td>
                <td class="px-6 py-4">
                    Oct 16, 2024
                </td>
                <td class="px-6 py-4 text-orange-600">Under Review</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/joko_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Nia
                </th>
                <td class="px-6 py-4">
                    Damaged road sign
                </td>
                <td class="px-6 py-4">
                    Infrastructure
                </td>
                <td class="px-6 py-4">
                    Oct 17, 2024
                </td>
                <td class="px-6 py-4 text-green-600">Completed</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/nia_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Rudi
                </th>
                <td class="px-6 py-4">
                    Faulty traffic light
                </td>
                <td class="px-6 py-4">
                    Traffic
                </td>
                <td class="px-6 py-4">
                    Oct 18, 2024
                </td>
                <td class="px-6 py-4 text-red-600">Not Processed</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/rudi_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Siti Aisyah
                </th>
                <td class="px-6 py-4">
                    Flooding issue
                </td>
                <td class="px-6 py-4">
                    Sanitation
                </td>
                <td class="px-6 py-4">
                    Oct 19, 2024
                </td>
                <td class="px-6 py-4 text-orange-600">Under Review</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/siti_aisyah_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    Tono
                </th>
                <td class="px-6 py-4">
                    Broken fence
                </td>
                <td class="px-6 py-4">
                    Infrastructure
                </td>
                <td class="px-6 py-4">
                    Oct 20, 2024
                </td>
                <td class="px-6 py-4 text-green-600">Completed</td>
                <td class="px-6 py-4">
                    <a href="#" class="font-medium text-blue-600 dark:text-blue-500 hover:underline">Edit</a>
                    <button onclick="showImage('/path/to/tono_image.jpg')" class="font-medium text-green-600 dark:text-green-500 hover:underline ml-2">View Photo</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- Modal to display image -->
<div id="imageModal" class="hidden fixed top-0 left-0 w-full h-full bg-black bg-opacity-75 flex justify-center items-center">
    <div class="relative">
        <img id="complaintImage" class="max-w-full max-h-full" src="" alt="Complaint Proof">
        <button onclick="closeImage()" class="absolute top-2 right-2 bg-white px-2 py-1 text-black">Close</button>
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
