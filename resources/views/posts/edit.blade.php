<!-- resources/views/posts/edit.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Update Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="edit-post-form" method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700">Title</label>
                            <input type="text" id="title" name="title" class="mt-1 block w-full" value="{{ $post->title }}" required>
                        </div>
                        <div class="mb-4">
                            <label for="content" class="block text-gray-700">Content</label>
                            <textarea id="content" name="content" rows="4" class="mt-1 block w-full" required>{{ $post->content }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label for="meta_title" class="block text-gray-700">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" class="mt-1 block w-full" value="{{ $post->meta_title }}" required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Image</label>
                            <input type="file" id="image" name="image" class="mt-1 block w-full">
                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="mt-2" style="max-width: 200px;">
                            @endif
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full" required>
                                <option value="draft" {{ $post->status == 'draft' ? 'selected' : '' }}>Draft</option>
                                <option value="published" {{ $post->status == 'published' ? 'selected' : '' }}>Published</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700">Category</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $post->category_id == $category->id ? 'selected' : '' }}>{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Update Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
