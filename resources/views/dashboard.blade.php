<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

                <!-- Users -->
                <a href="{{ route('users.index') ?? '#' }}" class="group block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Users</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $counts['users'] }}</p>
                        </div>
                        <div class="p-3 bg-indigo-50 rounded-full">
                            <!-- simple icon -->
                            <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500 group-hover:text-indigo-600">View users</p>
                </a>

                <!-- Blogs -->
                <a href="{{ route('blogs.index') }}" class="group block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Blogs</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $counts['blogs'] }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-full">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M19 11l-6 6-6-6"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500 group-hover:text-green-600">Manage blogs</p>
                </a>

                <!-- Categories -->
                <a href="{{ route('categories.index') }}" class="group block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Categories</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $counts['categories'] }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-full">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M3 7h18M3 12h18M3 17h18"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500 group-hover:text-yellow-600">Manage categories</p>
                </a>

                <!-- Tags -->
                <a href="{{ route('tags.index') }}" class="group block bg-white p-4 rounded-lg shadow hover:shadow-md transition">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Tags</p>
                            <p class="mt-2 text-3xl font-bold text-gray-900">{{ $counts['tags'] }}</p>
                        </div>
                        <div class="p-3 bg-pink-50 rounded-full">
                            <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M7 7h10M7 12h6M7 17h10"/>
                            </svg>
                        </div>
                    </div>
                    <p class="mt-3 text-sm text-gray-500 group-hover:text-pink-600">Manage tags</p>
                </a>

            </div>
        </div>
    </div>
</x-app-layout>
