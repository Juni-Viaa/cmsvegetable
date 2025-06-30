<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Settings')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#4F46E5',
                        secondary: '#10B981',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-100">
    <!-- Header -->
    <x-navbar />
    
    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <div class="flex gap-8">
            <!-- Sidebar -->
            <x-settings-sidebar />
            
            <!-- Content -->
            <div class="flex-1">
                @yield('content')
            </div>
        </div>
    </div>
</body>
</html>