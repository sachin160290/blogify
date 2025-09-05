<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Add User</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('users.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Name</label>
                        <input name="name" value="{{ old('name') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('name') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('email') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" class="mt-1 block w-full border-gray-300 rounded-md">
                            <option value="editor">Editor</option>
                            <option value="admin">Admin</option>
                        </select>
                        @error('role') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Password</label>
                        <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        @error('password') <p class="text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Confirm Password</label>
                        <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md" required>
                    </div>

                    <div class="flex items-center gap-3">
                        <button class="px-4 py-2 bg-indigo-600 text-white rounded-md">Save</button>
                        <a href="{{ route('users.index') }}" class="text-sm text-gray-600">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
