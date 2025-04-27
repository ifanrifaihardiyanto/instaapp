<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Register - InstaApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="flex items-center justify-center h-screen bg-gray-100">

    <div class="bg-white p-8 rounded shadow-md w-96">
        <h2 class="text-2xl font-bold mb-6 text-center">Register</h2>

        <form onsubmit="event.preventDefault(); alert('Dummy register!');">
            <input type="text" placeholder="Name" class="w-full p-2 mb-4 border rounded" required>
            <input type="email" placeholder="Email" class="w-full p-2 mb-4 border rounded" required>
            <input type="password" placeholder="Password" class="w-full p-2 mb-4 border rounded" required>
            <input type="password" placeholder="Confirm Password" class="w-full p-2 mb-4 border rounded" required>

            <button class="w-full bg-green-500 text-white p-2 rounded">Register</button>
        </form>

        <p class="text-center mt-4">
            Already have an account? <a href="{{ route('login') }}" class="text-blue-500">Login</a>
        </p>
    </div>

</body>

</html>
