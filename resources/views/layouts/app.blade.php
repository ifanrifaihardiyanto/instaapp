<!-- app.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:wght@400;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/feather-icons"></script>
    <style>
        .instagram-logo {
            font-family: 'Lobster Two', cursive;
            font-size: 1.75rem;
        }

        .story-circle {
            border: 2px solid #E1306C;
            padding: 2px;
        }

        .nav-icon {
            height: 24px;
            width: 24px;
        }

        .sidebar-fixed {
            position: fixed;
            height: 100vh;
            border-right: 1px solid #dbdbdb;
        }

        .feed-content {
            margin-left: 240px;
        }

        .dropdown-menu {
            position: absolute;
            bottom: 70px;
            left: 0;
            width: 100%;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
            z-index: 50;
        }

        @media (max-width: 768px) {
            .sidebar-fixed {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: auto;
                border-top: 1px solid #dbdbdb;
                border-right: none;
                z-index: 100;
            }

            .feed-content {
                margin-left: 0;
                margin-bottom: 60px;
            }
        }
    </style>
</head>

<body class="bg-white">
    <div class="flex">
        <!-- Sidebar -->
        <div class="sidebar-fixed bg-white w-60 px-4 py-8 hidden md:block">
            <div class="mb-10">
                <h1 class="instagram-logo">Insta App</h1>
            </div>
            <div class="space-y-6">
                <a href="{{ route('feed') }}" class="flex items-center space-x-3 text-black font-medium">
                    <i data-feather="home" class="nav-icon"></i>
                    <span>Beranda</span>
                </a>
                <a href="{{ route('post.create') }}" class="flex items-center space-x-3 text-gray-600">
                    <i data-feather="plus-square" class="nav-icon"></i>
                    <span>Buat</span>
                </a>
                <a href="{{ route('profile') }}" class="flex items-center space-x-3 text-gray-600">
                    <div class="bg-gray-300 w-6 h-6 rounded-full"></div>
                    <span>Profil</span>
                </a>
            </div>
            <div class="mt-auto pt-8 relative">
                <button id="moreMenuBtn" class="flex items-center space-x-3 text-gray-600 w-full">
                    <i data-feather="menu" class="nav-icon"></i>
                    <span>Lainnya</span>
                </button>

                <!-- Dropdown Menu -->
                <div id="moreDropdownMenu"
                    class="absolute left-0 mt-2 w-full bg-white rounded-lg shadow-lg border border-gray-200 hidden z-20">
                    <ul>
                        <li class="border-t border-gray-200">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-left px-4 py-3 text-gray-800 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile Nav -->
        <div
            class="fixed bottom-0 left-0 right-0 bg-white border-t border-gray-300 px-4 py-3 flex justify-around md:hidden z-10">
            <a href="{{ route('feed') }}" class="text-black">
                <i data-feather="home" class="nav-icon"></i>
            </a>
            <a href="#" class="text-gray-600">
                <i data-feather="search" class="nav-icon"></i>
            </a>
            <a href="{{ route('post.create') }}" class="text-gray-600">
                <i data-feather="plus-square" class="nav-icon"></i>
            </a>
            <a href="#" class="text-gray-600">
                <i data-feather="film" class="nav-icon"></i>
            </a>
            <div class="relative">
                <button id="mobileProfileBtn" class="text-gray-600">
                    <div class="bg-gray-300 w-6 h-6 rounded-full"></div>
                </button>

                <!-- Mobile Profile Dropdown -->
                <div id="mobileProfileMenu" class="dropdown-menu hidden">
                    <ul>
                        <li>
                            <a href="{{ route('profile') }}"
                                class="block px-4 py-3 text-center text-gray-800 hover:bg-gray-100 border-b border-gray-200">
                                Profil
                            </a>
                        </li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="w-full text-center px-4 py-3 text-gray-800 hover:bg-gray-100">
                                    Keluar
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="w-full feed-content">
            @yield('content')
        </div>
    </div>

    <script>
        feather.replace();

        // Desktop Menu Toggle
        document.getElementById('moreMenuBtn')?.addEventListener('click', function() {
            const dropdown = document.getElementById('moreDropdownMenu');
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown when clicking outside
        window.addEventListener('click', function(event) {
            const dropdown = document.getElementById('moreDropdownMenu');
            const button = document.getElementById('moreMenuBtn');

            if (dropdown && button && !dropdown.contains(event.target) && !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        });

        // Mobile Profile Menu Toggle
        document.getElementById('mobileProfileBtn')?.addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileProfileMenu');
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        window.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileProfileMenu');
            const mobileButton = document.getElementById('mobileProfileBtn');

            if (mobileMenu && mobileButton && !mobileMenu.contains(event.target) && !mobileButton.contains(event
                    .target)) {
                mobileMenu.classList.add('hidden');
            }
        });
    </script>
</body>

</html>
