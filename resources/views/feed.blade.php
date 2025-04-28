@extends('layouts.app')

@section('content')
    <style>
        @keyframes pop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.5);
            }

            100% {
                transform: scale(1);
            }
        }

        .pop-animation {
            animation: pop 0.4s ease;
        }
    </style>

    <div class="max-w-7xl mx-auto mt-8 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($posts as $post)
            <div class="bg-white p-4 rounded shadow mb-6">
                <div class="flex items-center mb-3">
                    <div class="bg-gray-300 w-10 h-10 rounded-full mr-3"></div>
                    <h2 class="font-semibold">{{ $post->user->name }}</h2>
                </div>

                <!-- Post Image -->
                @if ($post->image_path)
                    <img src="{{ Storage::url($post->image_path) }}" alt="Post Image"
                        class="w-full h-48 object-cover rounded mb-2">
                @else
                    <img src="https://via.placeholder.com/600x400" alt="Post Image"
                        class="w-full h-48 object-cover rounded mb-2">
                @endif

                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        <button
                            class="like-btn flex items-center {{ $post->likes->contains(auth()->user()) ? 'text-red-500' : 'text-gray-600' }}"
                            data-post-id="{{ $post->id }}"
                            data-liked="{{ $post->likes->contains(auth()->user()) ? 'true' : 'false' }}">
                            <i data-feather="heart" class="mr-1"></i>
                            <span>Like</span>
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
                    <p class="font-semibold">{{ $post->user->name }}</p>
                    <p class="text-gray-700">{{ $post->content }}</p>
                </div>

                <!-- Comment Section -->
                <div class="comment-section hidden mt-4 transition-all duration-300">
                    <div class="comments-list mb-4">
                        @foreach ($post->comments as $comment)
                            <div class="p-2 border-b text-sm text-gray-800">
                                <strong>{{ $comment->user->name }}</strong> {{ $comment->content }}
                            </div>
                        @endforeach
                    </div>
                    <textarea class="w-full p-2 border rounded mb-2 comment-text" placeholder="Write a comment..."></textarea>
                    <button class="post-comment-btn bg-blue-500 text-white px-4 py-2 rounded"
                        data-post-id="{{ $post->id }}">Post Comment</button>
                </div>
            </div>
        @endforeach
    </div>

    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
    <script>
        feather.replace();

        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const postId = this.getAttribute('data-post-id');
                const icon = this.querySelector('i');

                console.log(`Sending like request for post ID: ${postId}`);

                fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        console.log('Response received:', response);
                        console.log('Status code:', response.status);

                        if (!response.ok) {
                            throw new Error(`Server responded with status ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Response data:', data);

                        if (data.liked) {
                            button.classList.add('text-red-500');
                            button.setAttribute('data-liked', 'true');
                        } else {
                            button.classList.remove('text-red-500');
                            button.setAttribute('data-liked', 'false');
                        }

                        // Add pop animation only if icon exists
                        if (icon) {
                            icon.classList.add('pop-animation');
                            setTimeout(() => {
                                icon.classList.remove('pop-animation');
                            }, 400);
                        }
                    })
                    .catch(error => {
                        console.error('Error liking post:', error);
                        // Only show alert for errors that aren't related to missing UI elements
                        if (!(error instanceof TypeError)) {
                            alert('Failed to like/unlike the post.');
                        }
                    });
            });
        });

        document.querySelectorAll('.comment-toggle').forEach(button => {
            button.addEventListener('click', function() {
                const postCard = this.closest('.bg-white');
                const commentSection = postCard.querySelector('.comment-section');
                commentSection.classList.toggle('hidden');
            });
        });

        document.querySelectorAll('.post-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const postCard = this.closest('.bg-white');
                const commentTextArea = postCard.querySelector('.comment-text');
                const commentText = commentTextArea.value.trim();
                const commentsList = postCard.querySelector('.comments-list');

                if (commentText === '') {
                    alert('Please write a comment first.');
                    return;
                }

                fetch(`/posts/${postId}/comment`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            content: commentText
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        commentTextArea.value = '';

                        const newComment = document.createElement('div');
                        newComment.classList.add(
                            'p-2', 'border-b', 'text-sm', 'text-gray-800',
                            'opacity-0', 'transition-opacity', 'duration-500', 'ease-in-out'
                        );
                        newComment.innerHTML =
                            `<strong>${data.comment.user}</strong> ${data.comment.content}`;
                        commentsList.prepend(newComment);

                        setTimeout(() => {
                            newComment.classList.remove('opacity-0');
                            newComment.classList.add('opacity-100');
                        }, 10);
                    })
                    .catch(error => {
                        console.error('Error posting comment:', error);
                        alert('Failed to post comment.');
                    });
            });
        });
    </script>
@endsection
