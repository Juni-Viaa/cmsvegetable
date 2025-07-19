<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Sayur Kita')</title>
    @vite([ 'resources/css/app.css', 'resources/js/app.js' ])
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/flowbite.min.js"></script>
</head>
<body class="bg-gray-200 text-black font-sans">

    <!-- Sidebar -->
    @include('components.sidebar_admin')
    
    <!-- Content -->
    <main>
        @yield('content')
    </main>

</body>
</html>