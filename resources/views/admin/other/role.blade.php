@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">Roles Management</h1>

        <div class="relative overflow-y-auto max-h-screen shadow-md sm:rounded-lg">
            <table class="w-full bg-white border border-gray-200 shadow-md">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Description</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                        <tr class="border-b bg-white odd:bg-gray-50 even:bg-gray-100">
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $role->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $role->description ?? 'N/A' }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="createRoleModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-bold mb-4">Create Role</h2>
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="description"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Create</button>
                                <button type="button" onclick="closeModal('createRoleModal')"
                                    class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="editRoleModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-bold mb-4">Edit Role</h2>
                        <form id="editRoleForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="edit_name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="edit_name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <input type="text" name="description" id="edit_description"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">Update</button>
                                <button type="button" onclick="closeModal('editRoleModal')"
                                    class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId, role = null) {
            document.getElementById(modalId).classList.remove('hidden');
            if (role) {
                document.getElementById('editRoleForm').action = `/roles/${role.id}`; // Set the form action
                document.getElementById('edit_name').value = role.name;
                document.getElementById('edit_description').value = role.description;
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
