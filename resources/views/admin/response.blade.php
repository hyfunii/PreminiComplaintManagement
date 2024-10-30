@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Responses</h1>

        <div class="flex justify-between items-center mb-4 border-b border-gray-200 dark:border-gray-700">
            <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="response-tabs" role="tablist">
                <li class="me-2" role="presentation">
                    <button class="inline-block p-4 border-b-2 rounded-t-lg text-purple-600 border-purple-600"
                        id="response-list-tab" type="button" role="tab" aria-controls="response-list"
                        aria-selected="true">Response List</button>
                </li>
                <li role="presentation">
                    <button class="inline-block p-4 border-b-2 hover:text-gray-600" id="done-complaints-tab" type="button"
                        role="tab" aria-controls="done-complaints" aria-selected="false">Done Complaints</button>
                </li>
            </ul>
        </div>

        <div id="response-tabs-content">
            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="response-list" role="tabpanel"
                aria-labelledby="response-list-tab">
                <form action="{{ route('response.search') }}" method="GET" class="max-w-md mx-auto mb-4 ml-0"
                    id="searchForm">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            type="search" name="query" id="response-search" placeholder="Search responses..."
                            oninput="searchResponses()" />
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
                                    {{ $response->complaint->status->name }}</td>
                                <td class="px-6 py-4 text-gray-700">
                                    <div class="flex flex-wrap gap-2">
                                        <a href="{{ route('response.detail', $response->id) }}"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-semibold py-1 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105">Details</a>
                                        <a href="#"
                                            class="bg-red-500 hover:bg-red-700 text-white font-semibold py-1 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105"
                                            onclick="showSweetAlert('Are you sure?', 'do you want to cancel this response?', function() {
                                                window.location.href = '{{ route('response.cancel', $response->id) }}';
                                            }); return false;">Cancel</a>
                                        <a href="#"
                                            class="bg-green-500 hover:bg-green-700 text-white font-semibold py-1 px-4 rounded transition duration-200 ease-in-out transform hover:scale-105"
                                            onclick="showSweetAlert('Are you sure?','Do you want to resolve this complaint?', function() { 
                                                window.location.href = '{{ route('response.done', $response->id) }}';
                                            }); return false;">Complete</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="done-complaints" role="tabpanel"
                aria-labelledby="done-complaints-tab">
                <form action="{{ route('response.search') }}" method="GET" class="max-w-md mx-auto mb-4 ml-0"
                    id="searchForm">
                    <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input
                            class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                            type="search" name="query" id="done-response-search" placeholder="Search done responses..."
                            oninput="searchDoneResponses()" />
                    </div>
                </form>
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
                                    {{ $response->complaint->status->name }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        const tabs = document.querySelectorAll('#response-tabs button');
        const tabContents = document.querySelectorAll('#response-tabs-content > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.getAttribute('aria-controls');

                tabs.forEach(t => t.classList.remove('border-purple-600', 'text-purple-600'));
                tab.classList.add('border-purple-600', 'text-purple-600');

                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });
                document.getElementById(target).classList.remove('hidden');
            });
        });
    </script>
    <script>
        function searchResponses() {
            const query = document.getElementById('response-search').value.toLowerCase();
            const rows = document.querySelectorAll('#response-list tbody tr');

            rows.forEach(row => {
                const user = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const complaint = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const respondedBy = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const response = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (user.includes(query) || complaint.includes(query) || respondedBy.includes(query) || response
                    .includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }

        function searchDoneResponses() {
            const query = document.getElementById('done-response-search').value.toLowerCase();
            const rows = document.querySelectorAll('#done-complaints tbody tr');

            rows.forEach(row => {
                const user = row.querySelector('td:nth-child(1)').textContent.toLowerCase();
                const complaint = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const respondedBy = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                const response = row.querySelector('td:nth-child(4)').textContent.toLowerCase();

                if (user.includes(query) || complaint.includes(query) || respondedBy.includes(query) || response
                    .includes(query)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>
@endsection
