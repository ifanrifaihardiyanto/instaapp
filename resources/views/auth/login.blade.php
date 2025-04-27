@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            <form id="loginForm">
                <input type="email" placeholder="Email" class="w-full p-2 mb-4 border rounded" required>
                <input type="password" placeholder="Password" class="w-full p-2 mb-4 border rounded" required>

                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
            </form>

            <p class="text-center mt-4">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-500">Register</a>
            </p>
        </div>
    </div>

    <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            localStorage.setItem('loggedIn', 'true');
            window.location.href = "{{ route('feed') }}";
        });
    </script>
@endsection
