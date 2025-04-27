@extends('layouts.app')

@section('content')
    <div class="flex items-center justify-center h-screen">
        <div class="bg-white p-8 rounded shadow-md w-96">
            <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>

            <!-- Form Login -->
            <form action="{{ url('login') }}" method="POST">
                @csrf
                <input type="email" name="email" placeholder="Email" class="w-full p-2 mb-4 border rounded"
                    value="{{ old('email') }}" required>
                @error('email')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <input type="password" name="password" placeholder="Password" class="w-full p-2 mb-4 border rounded"
                    required>
                @error('password')
                    <div class="text-red-500 text-sm">{{ $message }}</div>
                @enderror

                <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Login</button>
            </form>

            <p class="text-center mt-4">
                Don't have an account? <a href="{{ route('register') }}" class="text-blue-500">Register</a>
            </p>
        </div>
    </div>
@endsection
