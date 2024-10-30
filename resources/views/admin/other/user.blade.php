@extends('layouts.app')

@section('content')
    <div class="container mx-auto py-8">
        <h1 class="text-2xl font-bold mb-6">User Management</h1>

        <button onclick="openModal('createUserModal')"
            class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded mb-4">
            Add User
        </button>

        <div class="relative overflow-y-auto max-h-screen shadow-md sm:rounded-lg">
            <table class="w-full bg-white border border-gray-200 shadow-md">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-sm font-semibold text-gray-700">Name</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Email</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Role</th>
                        <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr class="border-b bg-white odd:bg-gray-50 even:bg-gray-100">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $user->name }}
                            </th>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $user->email }}
                            </td>
                            <td class="px-6 py-4 text-gray-700">
                                {{ $user->role->name }}
                            </td>
                            <td class="px-6 py-4">
                                <button onclick="openModal('editUserModal', {{ $user }})"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-4 rounded mr-2">Edit</button>
                                <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline"
                                    id="delete-form-{{ $user->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete('delete-form-{{ $user->id }}')"
                                        class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="createUserModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-bold mb-4">Create User</h2>
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="email"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                                <input type="password" name="password" id="password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="role_id" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role_id" id="role_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Create</button>
                                <button type="button" onclick="closeModal('createUserModal')"
                                    class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div id="editUserModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
            <div class="flex items-center justify-center min-h-screen">
                <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                    <div class="bg-white p-6">
                        <h2 class="text-lg font-bold mb-4">Edit User</h2>
                        <form id="editUserForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-4">
                                <label for="edit_name" class="block text-sm font-medium text-gray-700">Name</label>
                                <input type="text" name="name" id="edit_name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_email" class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" id="edit_email"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                            </div>
                            <div class="mb-4">
                                <label for="edit_password" class="block text-sm font-medium text-gray-700">Password (leave
                                    blank to keep current password)</label>
                                <input type="password" name="password" id="edit_password"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div class="mb-4">
                                <label for="edit_role_id" class="block text-sm font-medium text-gray-700">Role</label>
                                <select name="role_id" id="edit_role_id"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="flex justify-end">
                                <button type="submit"
                                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-2 px-4 rounded">Update</button>
                                <button type="button" onclick="closeModal('editUserModal')"
                                    class="ml-2 bg-gray-300 hover:bg-gray-400 text-gray-700 py-2 px-4 rounded">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModal(modalId, user = null) {
            document.getElementById(modalId).classList.remove('hidden');
            if (user) {
                document.getElementById('editUserForm').action = `/users/${user.id}`; // Set the form action
                document.getElementById('edit_name').value = user.name;
                document.getElementById('edit_email').value = user.email;
                document.getElementById('edit_role_id').value = user.role_id;
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
@endsection
