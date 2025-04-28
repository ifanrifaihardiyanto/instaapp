@extends('layouts.app')

@section('content')
    <style>
        @keyframes pop {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.2);
            }

            100% {
                transform: scale(1);
            }
        }

        .pop-animation {
            animation: pop 0.4s ease;
        }
    </style>

    <div class="max-w-xl mx-auto py-8 px-4">
        <!-- Posts Feed -->
        @foreach ($posts as $post)
            <!-- Modal for Comments -->
            <div id="comments-modal-{{ $post->id }}"
                class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
                <div class="bg-white rounded-lg max-w-lg w-full p-4 relative">
                    <button class="absolute top-2 right-2 text-gray-400 hover:text-gray-600"
                        onclick="closeCommentsModal({{ $post->id }})">
                        &times;
                    </button>
                    <h2 class="text-lg font-semibold mb-4">Komentar</h2>
                    <div id="comments-list-{{ $post->id }}" class="space-y-2 max-h-[400px] overflow-y-auto">
                        <!-- Comments will be loaded here -->
                        <p class="text-center text-gray-500">Memuat komentar...</p>
                    </div>
                </div>
            </div>

            <div class="bg-white border border-gray-200 rounded mb-6">
                <!-- Post Header -->
                <div class="flex items-center justify-between p-3 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="bg-gray-300 w-8 h-8 rounded-full mr-3"></div>
                        <span class="font-semibold text-sm">{{ $post->user->name }}</span>
                    </div>
                </div>

                <!-- Post Image -->
                @if ($post->image_path)
                    <img src="{{ Storage::url($post->image_path) }}" alt="Post Image" class="w-full object-cover"
                        style="max-height: 600px;">
                @else
                    <img src="https://via.placeholder.com/600x600" alt="Post Image" class="w-full object-cover"
                        style="max-height: 600px;">
                @endif

                <!-- Post Actions -->
                <div class="p-3">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center space-x-4">
                            <button
                                class="like-btn {{ $post->likes->contains(auth()->user()) ? 'text-red-500' : 'text-black' }}"
                                data-post-id="{{ $post->id }}"
                                data-liked="{{ $post->likes->contains(auth()->user()) ? 'true' : 'false' }}">
                                <i data-feather="{{ $post->likes->contains(auth()->user()) ? 'heart' : 'heart' }}"
                                    class="w-6 h-6 {{ $post->likes->contains(auth()->user()) ? 'fill-current' : '' }}"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Likes count - Updated to use actual count -->
                    <div class="mt-2">
                        <p class="font-semibold text-sm">{{ $post->likes->count() }} suka</p>
                    </div>

                    <!-- Caption -->
                    <div class="mt-1">
                        <p class="text-sm">
                            <span class="font-semibold">{{ $post->user->name }}</span>
                            {{ $post->content }}
                        </p>
                    </div>

                    <!-- View all comments -->
                    <div class="mt-1">
                        <button class="text-gray-500 text-sm" onclick="openCommentsModal({{ $post->id }})">
                            Lihat semua {{ count($post->comments) }} komentar
                        </button>
                    </div>

                    <!-- Comments preview -->
                    <div class="mt-1 comments-preview">
                        @foreach ($post->comments->take(2) as $comment)
                            <p class="text-sm">
                                <span class="font-semibold">{{ $comment->user->name }}</span>
                                {{ $comment->content }}
                            </p>
                        @endforeach
                    </div>

                    <!-- Post time -->
                    <div class="mt-1">
                        <p class="text-gray-400 text-xs uppercase">{{ $post->created_at->diffForHumans() }}</p>
                    </div>
                </div>

                <!-- Comment Input -->
                <div class="flex items-center border-t border-gray-200 p-3">
                    <button class="mr-3">
                        <i data-feather="smile" class="w-6 h-6 text-gray-500"></i>
                    </button>
                    <input type="text" class="comment-text flex-grow bg-transparent outline-none text-sm"
                        placeholder="Tambahkan komentar...">
                    <button
                        class="post-comment-btn ml-2 font-semibold text-blue-500 text-sm disabled:opacity-50 disabled:cursor-not-allowed"
                        data-post-id="{{ $post->id }}" disabled>
                        Kirim
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    <script>
        // Initialize feather icons
        feather.replace();

        function openCommentsModal(postId) {
            const modal = document.getElementById(`comments-modal-${postId}`);
            const commentsList = document.getElementById(`comments-list-${postId}`);

            // Show modal
            modal.classList.remove('hidden');

            // Clear previous
            commentsList.innerHTML = '<p class="text-center text-gray-500">Memuat komentar...</p>';

            // Fetch comments
            fetch(`/posts/${postId}/comment`)
                .then(response => response.json())
                .then(data => {
                    if (data.comments.length > 0) {
                        commentsList.innerHTML = '';
                        data.comments.forEach(comment => {
                            const commentElement = document.createElement('div');
                            commentElement.className = 'text-sm';
                            commentElement.innerHTML =
                                `<span class="font-semibold">${comment.user}</span> ${comment.content}`;
                            commentsList.appendChild(commentElement);
                        });
                    } else {
                        commentsList.innerHTML = '<p class="text-center text-gray-500">Belum ada komentar.</p>';
                    }
                })
                .catch(error => {
                    console.error('Error loading comments:', error);
                    commentsList.innerHTML = '<p class="text-center text-red-500">Gagal memuat komentar.</p>';
                });
        }

        function closeCommentsModal(postId) {
            const modal = document.getElementById(`comments-modal-${postId}`);
            modal.classList.add('hidden');
        }

        // Enable or disable comment button based on input
        document.querySelectorAll('.comment-text').forEach(input => {
            input.addEventListener('input', function() {
                const postCard = this.closest('.bg-white');
                const commentBtn = postCard.querySelector('.post-comment-btn');

                if (this.value.trim() !== '') {
                    commentBtn.removeAttribute('disabled');
                } else {
                    commentBtn.setAttribute('disabled', 'disabled');
                }
            });
        });

        // Like button functionality
        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();

                const postId = this.getAttribute('data-post-id');
                const icon = this.querySelector('svg'); // Ganti ke svg
                const likesCountElement = this.closest('.p-3').querySelector('.font-semibold.text-sm');

                if (!icon) {
                    console.error('Icon not found in button!');
                    return;
                }

                fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        credentials: 'same-origin'
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Server responded with status ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.liked) {
                            button.classList.add('text-red-500');
                            button.setAttribute('data-liked', 'true');
                            icon.classList.add('fill-current');
                        } else {
                            button.classList.remove('text-red-500');
                            button.setAttribute('data-liked', 'false');
                            icon.classList.remove('fill-current');
                        }

                        likesCountElement.textContent = `${data.likesCount} suka`;

                        // Pop animation
                        icon.classList.add('pop-animation');
                        setTimeout(() => {
                            icon.classList.remove('pop-animation');
                        }, 400);
                    })
                    .catch(error => {
                        console.error('Error liking post:', error);
                        alert('Gagal menyukai postingan.');
                    });
            });
        });

        // Comment posting functionality
        document.querySelectorAll('.post-comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-post-id');
                const postCard = this.closest('.bg-white');
                const commentTextArea = postCard.querySelector('.comment-text');
                const commentText = commentTextArea.value.trim();
                const commentsPreview = postCard.querySelector('.comments-preview');

                if (commentText === '' || !commentsPreview) {
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
                        button.setAttribute('disabled', 'disabled');

                        // Create and add the new comment to the comments preview
                        const newComment = document.createElement('p');
                        newComment.classList.add('text-sm');
                        newComment.innerHTML =
                            `<span class="font-semibold">${data.comment.user}</span> ${data.comment.content}`;

                        // Add to the beginning of comments list
                        if (commentsPreview.firstChild) {
                            commentsPreview.insertBefore(newComment, commentsPreview.firstChild);
                        } else {
                            commentsPreview.appendChild(newComment);
                        }

                        // Update comment count if it exists
                        const commentCountEl = postCard.querySelector('button.text-gray-500.text-sm');
                        if (commentCountEl) {
                            const currentText = commentCountEl.textContent;
                            const match = currentText.match(/Lihat semua (\d+) komentar/);
                            if (match) {
                                const newCount = parseInt(match[1]) + 1;
                                commentCountEl.textContent = `Lihat semua ${newCount} komentar`;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error posting comment:', error);
                        alert('Failed to post comment. Please try again.');
                    });
            });
        });
    </script>
@endsection
