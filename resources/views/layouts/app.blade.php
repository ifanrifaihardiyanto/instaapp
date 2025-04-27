<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
</head>

<body class="bg-gray-100">

    <!-- Navbar -->
    <nav class="bg-white shadow p-4 flex justify-between items-center">
        <h1 class="text-xl font-bold">InstaApp</h1>
        <div class="relative">
            @if (request()->routeIs('feed'))
                <div class="flex items-center space-x-4">
                    <a href="{{ route('post.create') }}" class="px-4 py-2 bg-blue-500 text-white rounded">New Post</a>
                    <div class="relative">
                        <button id="profileDropdown" class="flex items-center text-gray-600">
                            <div class="bg-gray-300 w-8 h-8 rounded-full mr-2"></div>
                            <span>Username</span>
                            <i data-feather="chevron-down" class="ml-2"></i>
                        </button>
                        <div id="dropdownMenu" class="absolute right-0 mt-2 w-40 bg-white rounded shadow-md hidden">
                            <ul>
                                <li>
                                    <a href="{{ route('profile') }}" class="block px-4 py-2 text-gray-800">Profile</a>
                                </li>
                                <!-- Logout Form -->
                                <li>
                                    <form action="{{ route('logout') }}" method="POST"
                                        class="block px-4 py-2 text-gray-800">
                                        @csrf
                                        <button type="submit" class="w-full text-left">Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="px-4 py-2 bg-gray-700 text-white rounded">Login</a>
            @endif
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <script>
        feather.replace();

        // Show dropdown menu
        document.getElementById('profileDropdown').addEventListener('click', function() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        });

        // Logout function
        function logout() {
            localStorage.removeItem('loggedIn');
            window.location.href = "{{ route('login') }}";
        }

        // Close dropdown if clicked outside
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('dropdownMenu');
            const dropdownButton = document.getElementById('profileDropdown');
            if (!dropdown.contains(event.target) && !dropdownButton.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
