@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="default-styled-tab" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg text-purple-600 border-purple-600" id="my-complaints-tab" type="button" role="tab" aria-controls="my-complaints" aria-selected="true">My Complaints</button>
                </li>
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 hover:text-gray-600" id="processed-complaints-tab" type="button" role="tab" aria-controls="processed-complaints" aria-selected="false">Processed</button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 hover:text-gray-600" id="completed-complaints-tab" type="button" role="tab" aria-controls="completed-complaints" aria-selected="false">Completed</button>
                </li>
            </ul>
            <div class="mt-6 flex justify-end">
                <a href="{{ route('complaints.index') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105 m-2">
                    Create Complaint
                </a>
            </div>
        </div>

        <div id="default-styled-tab-content">
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="my-complaints" role="tabpanel"
                aria-labelledby="my-complaints-tab">
                @if ($myComplaints->isEmpty())
                    <p class="text-gray-600">You have not submitted any complaints yet.</p>
                @else
                    <ul class="list-disc list-inside space-y-4">
                        @foreach ($myComplaints as $complaint)
                            <li class="bg-gray-100 shadow-md rounded-lg p-4">
                                <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
                                <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
                                <p class="text-gray-600">Status: <span
                                        class="text-red-600">{{ $complaint->status->name }}</span></p>
                                <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>

                                <a href="{{ route('our_response', $complaint->id) }}"
                                    class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">View
                                    Details</a>

                                <button onclick="openModal('{{ $complaint->id }}')"
                                    class="mt-2 bg-yellow-400 hover:bg-yellow-700 text-white py-2 px-4 rounded">Edit</button>

                                <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST"
                                    class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="mt-2 bg-red-500 hover:bg-red-700 text-white py-2 px-4 rounded"
                                        onclick="return confirm('Are you sure you want to cancel this complaint?')">Cancel
                                        Complaint</button>
                                </form>
                            </li>

                            <div id="editModal{{ $complaint->id }}"
                                class="hidden overflow-y-auto fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative bg-white w-full max-w-lg mx-auto p-8 rounded shadow-lg">
                                    <button onclick="closeModal('{{ $complaint->id }}')"
                                        class="absolute top-2 right-2 text-gray-600">&times;</button>
                                    <h2 class="text-xl font-semibold mb-4">Edit Complaint</h2>
                                    <form action="{{ route('complaints.update', $complaint->id) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-4">
                                            <label for="title{{ $complaint->id }}"
                                                class="block text-sm font-medium text-gray-700">Title</label>
                                            <input type="text" name="title" id="title{{ $complaint->id }}"
                                                value="{{ $complaint->title }}"
                                                class="w-full p-2 border border-gray-300 rounded">
                                        </div>
                                        <div class="mb-4">
                                            <label for="description{{ $complaint->id }}"
                                                class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea name="description" id="description{{ $complaint->id }}" rows="4"
                                                class="w-full p-2 border border-gray-300 rounded">{{ $complaint->description }}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="category_id{{ $complaint->id }}"
                                                class="block text-sm font-medium text-gray-700">Category</label>
                                            <select name="category_id" id="category_id{{ $complaint->id }}"
                                                class="w-full p-2 border border-gray-300 rounded">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $complaint->category_id ? 'selected' : '' }}>
                                                        {{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label for="image{{ $complaint->id }}" class="block text-sm font-medium text-gray-700">Image</label>
                                            <div class="mb-2">
                                                @if ($complaint->file_path)
                                                    <img src="{{ asset('storage/' . $complaint->file_path) }}" alt="Current Image" class="w-full h-auto mb-2">
                                                @else
                                                    <p class="text-gray-500">No image available</p>
                                                @endif
                                            </div>
                                            <input type="file" name="image" id="image{{ $complaint->id }}" class="w-full p-2 border border-gray-300 rounded">
                                            <small class="text-gray-500">Leave empty to keep the current image.</small>
                                        </div>
                                        
                                        <div class="flex justify-end">
                                            <button type="button" onclick="closeModal('{{ $complaint->id }}')"
                                                class="bg-gray-300 hover:bg-gray-500 text-gray-800 py-2 px-4 rounded">Close</button>
                                            <button type="submit"
                                                class="bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded ml-2">Update</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="processed-complaints" role="tabpanel"
                aria-labelledby="processed-complaints-tab">
                @if ($processedComplaints->isEmpty())
                    <p class="text-gray-600">No processed complaints found.</p>
                @else
                    <ul class="list-disc list-inside space-y-4">
                        @foreach ($processedComplaints as $complaint)
                            <li class="bg-gray-100 shadow-md rounded-lg p-4">
                                <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
                                <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
                                <p class="text-gray-600">Status: <span
                                        class="text-orange-600">{{ $complaint->status->name }}</span></p>
                                <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>
                                <a href="{{ route('our_response', $complaint->id) }}"
                                    class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">View
                                    Details</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="completed-complaints" role="tabpanel"
                aria-labelledby="completed-complaints-tab">
                @if ($completedComplaints->isEmpty())
                    <p class="text-gray-600">No completed complaints found.</p>
                @else
                    <ul class="list-disc list-inside space-y-4">
                        @foreach ($completedComplaints as $complaint)
                            <li class="bg-gray-100 shadow-md rounded-lg p-4">
                                <h2 class="text-xl font-semibold text-gray-800">{{ $complaint->title }}</h2>
                                <p class="text-gray-600">Category: {{ $complaint->category->name }}</p>
                                <p class="text-gray-600">Status: <span
                                        class="text-green-600">{{ $complaint->status->name }}</span></p>
                                <p class="text-gray-600">Submitted on: {{ $complaint->created_at->format('M d, Y') }}</p>
                                <a href="{{ route('our_response', $complaint->id) }}"
                                    class="mt-2 inline-block bg-blue-500 hover:bg-blue-700 text-white py-2 px-4 rounded">View
                                    Details</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('[role="tab"]');
        const tabPanels = document.querySelectorAll('[role="tabpanel"]');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => {
                    t.classList.remove('text-purple-600', 'border-purple-600');
                    t.classList.add('hover:text-gray-600');
                });
                tab.classList.add('text-purple-600', 'border-purple-600');
                tabPanels.forEach(panel => {
                    panel.classList.add('hidden');
                });
                document.getElementById(tab.getAttribute('aria-controls')).classList.remove('hidden');
            });
        });

        function openModal(id) {
            document.getElementById('editModal' + id).classList.remove('hidden');
        }

        function closeModal(id) {
            document.getElementById('editModal' + id).classList.add('hidden');
        }
    </script>
@endsection
