<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Blogs') }}</h2>
            <a href="{{ route('blogs.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700">
                {{ __('Add Blog') }}
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 rounded-md bg-green-50 p-4">
                    <div class="text-sm text-green-700">{{ session('success') }}</div>
                </div>
            @endif

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-4 overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categories</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Publish At</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Time</th>
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($blogs as $blog)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $blog->title }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ optional($blog->author)->name }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $blog->categories->pluck('title')->join(', ') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ \Carbon\Carbon::parse($blog->publish_at)->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ $blog->time_to_read }} min</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-700">{{ ucfirst($blog->status) }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('blogs.edit', $blog) }}" class="inline-flex items-center px-2 py-1 border border-gray-300 rounded text-sm text-gray-700 hover:bg-gray-50">Edit</a>

                                        <form action="{{ route('blogs.destroy', $blog) }}" method="POST" class="inline-block ml-2" onsubmit="return confirm('Delete this blog?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="inline-flex items-center px-2 py-1 border border-red-300 rounded text-sm text-red-700 hover:bg-red-50">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-4 py-10 text-center text-sm text-gray-500">No blogs found.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{-- Tailwind pagination (Laravel's default uses Tailwind) --}}
                    <div class="mt-4">
                        {{ $blogs->withQueryString()->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
