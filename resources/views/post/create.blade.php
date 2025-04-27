@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Create Post</h2>

            <form id="postForm">
                <textarea placeholder="What's on your mind?" class="w-full p-2 mb-4 border rounded" rows="4" required></textarea>

                <input type="file" id="imageInput" class="w-full mb-4" accept="image/*">

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

        document.getElementById('postForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Dummy post created!');
        });
    </script>
@endsection
