<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Edit Blog</h2>
            <a href="{{ route('blogs.index') }}" class="inline-flex items-center px-3 py-1.5 bg-gray-100 text-sm rounded-md">
                Back
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('blogs.update', $blog) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input name="title" value="{{ old('title', $blog->title) }}" required class="mt-1 block w-full border-gray-300 rounded-md" />
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="editor" name="description" rows="8" class="mt-1 block w-full border-gray-300 rounded-md">{{ old('description', $blog->description ?? '') }}</textarea>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Publish At</label>
                            <input type="datetime-local" name="publish_at" value="{{ old('publish_at', \Carbon\Carbon::parse($blog->publish_at)->format('Y-m-d\TH:i')) }}" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Time to read (min)</label>
                            <input type="number" name="time_to_read" value="{{ old('time_to_read', $blog->time_to_read) }}" min="1" class="mt-1 block w-full border-gray-300 rounded-md" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" class="mt-1 block w-full border-gray-300 rounded-md">
                                <option value="draft" {{ old('status', $blog->status)=='draft' ? 'selected':'' }}>Draft</option>
                                <option value="private" {{ old('status', $blog->status)=='private' ? 'selected':'' }}>Private</option>
                                <option value="published" {{ old('status', $blog->status)=='published' ? 'selected':'' }}>Published</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Categories</label>
                            <select name="categories[]" multiple class="mt-1 block w-full border-gray-300 rounded-md">
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ in_array($c->id, old('categories', $blog->categories->pluck('id')->toArray())) ? 'selected':'' }}>{{ $c->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Tags</label>
                            <select name="tags[]" multiple class="mt-1 block w-full border-gray-300 rounded-md">
                                @foreach($tags as $t)
                                    <option value="{{ $t->id }}" {{ in_array($t->id, old('tags', $blog->tags->pluck('id')->toArray())) ? 'selected':'' }}>{{ $t->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-6 flex items-center gap-3">
                        <button class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded-md">Update</button>
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
