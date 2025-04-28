<!-- layouts/auth.blade.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>InstaApp - Authentication</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Lobster+Two:wght@400;700&display=swap" rel="stylesheet">
    <style>
        .instagram-logo {
            font-family: 'Lobster Two', cursive;
            font-size: 1.75rem;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="min-h-screen flex flex-col">
        <!-- Logo Header (Optional) -->
        <div class="flex justify-center pt-8 pb-4">
            <h1 class="instagram-logo">Insta App</h1>
        </div>

        <!-- Main Content -->
        <div class="flex-grow">
            @yield('content')
        </div>
    </div>
</body>

</html>
