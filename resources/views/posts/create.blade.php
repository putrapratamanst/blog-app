<!-- resources/views/posts/create.blade.php -->
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Post') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form id="create-post-form" method="POST" action="{{ route('posts.store') }}"  enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block text-gray-700">Title</label>
                            <input type="text" id="title" name="title" class="mt-1 block w-full" required>
                        </div>
                        <div class="mb-4">
                            <label for="content" class="block text-gray-700">Content</label>
                            <textarea id="content" name="content" rows="4" class="mt-1 block w-full" required></textarea>
                        </div>
                          
                        <div class="mb-4">
                            <label for="meta_title" class="block text-gray-700">Meta Title</label>
                            <input type="text" id="meta_title" name="meta_title" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="image" class="block text-gray-700">Image</label>
                            <input type="file" id="image" name="image" class="mt-1 block w-full" required>
                        </div>

                        <div class="mb-4">
                            <label for="status" class="block text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full" required>
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="category_id" class="block text-gray-700">Category</label>
                            <select id="category_id" name="category_id" class="mt-1 block w-full" required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category }}</option>
                                @endforeach
                            </select>
                        </div>


                        <div class="mb-4">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Create Post</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
