<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />

    <title>@yield('title', 'Sayur Kita')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/flowbite@1.6.6/dist/flowbite.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/flowbite@1.6.6/dist/flowbite.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                    backgroundImage: {
                        'bg-1': "url('/images/gambar1.jpg')",
                        'bg-2': "url('/images/gambar2.jpg')",
                        'bg-3': "url('/images/gambar3.jpg')",
                    }
                }
            }
        }
    </script>

    <style>
        main {
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        }

        .bg-transition {
            transition: background-image 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .main-fade-in {
            animation: fadeIn 0.8s ease forwards;
        }

        input:focus,
        textarea:focus,
        select:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 5px #3b82f6;
            transition: all 0.3s ease;
            outline: none;
        }

        button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.5);
            transition: all 0.3s ease;
        }

        button {
            position: relative;
            overflow: hidden;
        }

        button::after {
            content: "";
            position: absolute;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            transform: scale(0);
            opacity: 0;
            pointer-events: none;
            transition: transform 0.4s, opacity 0.8s;
            width: 100px;
            height: 100px;
            top: 50%;
            left: 50%;
            transform-origin: center;
        }

        button:active::after {
            transform: scale(3);
            opacity: 1;
            transition: 0s;
        }
    </style>

</head>

<body
    class="min-h-screen flex items-center justify-center font-poppins bg-cover bg-center bg-no-repeat bg-transition bg-[url('/images/gambar1.jpg')]"
    id="dynamic-bg">

    <!-- Container transparan -->
    <main class="w-full max-w-md p-6 bg-white/30 backdrop-blur-md rounded-xl shadow-md main-fade-in">
        @yield('content')
    </main>

    <script>
        const images = [
            "/images/gambar1.jpg",
            "/images/gambar2.jpg",
            "/images/gambar3.jpg"
        ];

        let index = 0;
        const bgEl = document.getElementById("dynamic-bg");

        setInterval(() => {
            index = (index + 1) % images.length;
            bgEl.style.backgroundImage = `url('${images[index]}')`;
        }, 5000); // Ganti setiap 5 detik
    </script>

</body>

</html>
