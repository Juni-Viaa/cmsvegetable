<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/output.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet" />
    <!-- CSS for carousel/flickity-->
    <link rel="icon" href="{{ asset('logos/logo.png') }}" type="image/png">
    <title>@yield('title', 'Sayur Kita')</title>
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity-fade@2/flickity-fade.css">

</head>

<body class="font-poppins text-cp-black">

    @yield('content')

    @stack('before-scripts')
    {{-- file js di sini khusus semua halaman --}}


    @stack('after-scripts')

</body>

</html>
