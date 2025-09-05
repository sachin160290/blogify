<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Category</h2>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-sm rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('categories.update', $category) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input name="title"
                               value="{{ old('title', $category->title) }}"
                               required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('title') border-red-500 @enderror" />
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="4"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 @error('description') border-red-500 @enderror">{{ old('description', $category->description) }}</textarea>
                        @error('description') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button>
                        <a href="{{ route('categories.index') }}" class="text-sm text-gray-600">Cancel</a>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
