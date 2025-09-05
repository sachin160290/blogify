<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Blog</h2>
            <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-sm rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('blogs.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input name="title" value="{{ old('title') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" />
                        @error('title') <p class="text-xs text-red-600 mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="editor" name="description" rows="8" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description', $blog->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Publish At</label>
                            <input type="datetime-local" name="publish_at" value="{{ old('publish_at', now()->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Time to read (min)</label>
                            <input type="number" name="time_to_read" value="{{ old('time_to_read', 5) }}" min="1" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="draft">Draft</option>
                                <option value="private">Private</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categories</label>
                            <select name="categories[]" multiple class="mt-1 block w-full border-gray-300 rounded-md">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tags</label>
                            <select name="tags[]" multiple class="mt-1 block w-full border-gray-300 rounded-md">
                                @foreach($tags as $t)
                                    <option value="{{ $t->id }}">{{ $t->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Save</button>
                        <a href="{{ route('blogs.index') }}" class="text-sm text-gray-600">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.0.0/classic/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => { console.error(error); });
    </script>
</x-app-layout>
