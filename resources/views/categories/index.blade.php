<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Categories</h2>
            <a href="{{ route('categories.create') }}"
               class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md shadow-sm hover:bg-indigo-700">
                Add Category
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            
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
                                <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                                <th class="px-4 py-2 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($categories as $category)
                                <tr>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">{{ $category->title }}</td>
                                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                        {{ Str::limit($category->description, 120) }}
                                    </td>
                                    <td class="px-4 py-3 whitespace-nowrap text-right text-sm">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="inline-flex items-center px-2 py-1 border border-gray-300 rounded-md text-gray-700 hover:bg-gray-50">
                                            Edit
                                        </a>
                                        <form action="{{ route('categories.destroy', $category) }}"
                                              method="POST"
                                              class="inline-block ml-2"
                                              onsubmit="return confirm('Delete this category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center px-2 py-1 border border-red-300 rounded-md text-red-700 hover:bg-red-50">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-6 text-center text-sm text-gray-500">
                                        No categories found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4">
                    {{ $categories->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
