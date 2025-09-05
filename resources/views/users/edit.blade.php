<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit User</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('users.update', $user) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input name="name" value="{{ old('name', $user->name) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('email') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="editor" {{ $user->role == 'editor' ? 'selected' : '' }}>Editor</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">New Password (leave blank to keep current)</label>
                        <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md">
                        @error('password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md">
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button>
                        <a href="{{ route('users.index') }}" class="text-sm text-gray-600">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
