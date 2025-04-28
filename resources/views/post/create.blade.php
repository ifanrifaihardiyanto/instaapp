@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Create Post</h2>

            <form id="postForm" method="POST" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="text" name="title" placeholder="Title" class="w-full p-2 mb-4 border rounded" required>
                <textarea name="content" placeholder="What's on your mind?" class="w-full p-2 mb-4 border rounded" rows="4"
                    required></textarea>
                <input type="file" name="image" id="imageInput" class="w-full mb-4" accept="image/*">
                <img id="previewImage" class="rounded mb-4 hidden" />
                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Post</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('previewImage');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    preview.src = event.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
