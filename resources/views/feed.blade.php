@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto mt-8 grid grid-cols-1 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        <!-- Main Feed (tengah) -->
        <div class="col-span-1 md:col-span-2 lg:col-span-3">
            @for ($i = 0; $i < 5; $i++)
                <div class="bg-white p-4 rounded shadow mb-6">
                    <div class="flex items-center mb-3">
                        <div class="bg-gray-300 w-10 h-10 rounded-full mr-3"></div>
                        <h2 class="font-semibold">Username</h2>
                    </div>
                    <img src="https://via.placeholder.com/600x400" alt="Post Image" class="w-full rounded mb-2">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <button class="like-btn flex items-center text-gray-600">
                                <i data-feather="heart" class="mr-1"></i><span>Like</span>
                            </button>
                            <button class="comment-toggle flex items-center text-gray-600">
                                <i data-feather="message-circle" class="mr-1"></i><span>Comment</span>
                            </button>
                        </div>
                        <div>
                            <button class="text-gray-600 text-sm">Share</button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <p class="font-semibold">Username</p>
                        <p class="text-gray-700">This is a sample post caption...</p>
                    </div>

                    <div class="comment-section hidden mt-4">
                        <textarea class="w-full p-2 border rounded mb-2" placeholder="Write a comment..."></textarea>
                        <button class="bg-blue-500 text-white px-4 py-2 rounded">Post Comment</button>
                    </div>
                </div>
            @endfor
        </div>
    </div>

    <script>
        feather.replace();

        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', () => {
                button.classList.toggle('text-red-500');
            });
        });

        document.querySelectorAll('.comment-toggle').forEach(button => {
            button.addEventListener('click', () => {
                const commentSection = button.closest('div').nextElementSibling;
                commentSection.classList.toggle('hidden');
            });
        });
    </script>
@endsection
