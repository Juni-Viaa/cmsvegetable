<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href="{{ asset('css/output.css') }}" rel="stylesheet" />
    <title>@yield('title', 'Default Title')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- CSS for carousel/flickity-->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <link rel="stylesheet" href="https://unpkg.com/flickity-fade@2/flickity-fade.css">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        poppins: ['Poppins', 'sans-serif'],
                    },
                },
            },
        };
    </script>

    <!-- AOS CSS -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet" />
    <!-- Rellax.js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/rellax/1.12.1/rellax.min.js"></script>

    <!-- Custom style -->
    <style>
        .parallax-container {
            position: relative;
            overflow: hidden;
            height: 300px;
        }

        .parallax-image {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 120%;
            object-fit: cover;
        }

        .overlay-text {
            position: relative;
            z-index: 10;
            color: white;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.7);
        }

        @keyframes fade-in-blur {
            0% {
                opacity: 0;
                filter: blur(4px);
                transform: translateY(10px);
            }

            100% {
                opacity: 1;
                filter: blur(0);
                transform: translateY(0);
            }
        }

        .animate-fade-in-blur {
            animation: fade-in-blur 1s ease-out forwards;
        }
    </style>

    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col font-poppins">

    @include('components.navbar')

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('components.footer')

    <!-- ====== TEAM MODAL (Global) ====== -->
    <div id="team-modal"
        class="fixed inset-0 bg-black/90 backdrop-blur-sm hidden justify-center items-center z-[9999] transition-opacity duration-300">
        <div id="modal-content"
            class="bg-white p-8 rounded-xl shadow-xl max-w-md w-full relative scale-95 opacity-0 transition-all duration-300">
            <button onclick="closeModal()"
                class="absolute top-4 right-4 text-gray-600 hover:text-black text-2xl">&times;</button>
            <img id="modal-img" src="" class="w-32 h-32 object-cover rounded-full mx-auto mb-4 shadow">
            <h3 id="modal-name" class="text-xl font-semibold text-center text-gray-800"></h3>
            <p id="modal-nim" class="text-center text-green-700 font-medium"></p>
            <p id="modal-desc" class="mt-4 text-center text-gray-600 text-sm"></p>
        </div>
    </div>

    <!-- JS Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

    <!-- Scripts -->
    <script>
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100,
        });

        const rellax = new Rellax('.rellax');

        gsap.registerPlugin(ScrollTrigger);
        gsap.to(".parallax-image", {
            scale: 1.1,
            scrollTrigger: {
                trigger: ".parallax-container",
                start: "top center",
                end: "bottom top",
                scrub: true
            }
        });

        VanillaTilt.init(document.querySelector(".parallax-container"), {
            max: 10,
            speed: 400,
            glare: true,
            "max-glare": 0.3
        });

        // Modal Logic
        function openModal(imgSrc, name, nim, desc) {
            const modal = document.getElementById('team-modal');
            const content = document.getElementById('modal-content');

            document.getElementById('modal-img').src = imgSrc;
            document.getElementById('modal-name').textContent = name;
            document.getElementById('modal-nim').textContent = nim;
            document.getElementById('modal-desc').textContent = desc;

            modal.classList.remove('hidden');
            modal.classList.add('flex');

            // animate content
            setTimeout(() => {
                content.classList.remove('opacity-0', 'scale-95');
                content.classList.add('opacity-100', 'scale-100');
            }, 50);
        }

        function closeModal() {
            const modal = document.getElementById('team-modal');
            const content = document.getElementById('modal-content');

            content.classList.remove('opacity-100', 'scale-100');
            content.classList.add('opacity-0', 'scale-95');

            setTimeout(() => {
                modal.classList.remove('flex');
                modal.classList.add('hidden');
            }, 200);
        }
    </script>

    @stack('scripts')
</body>

</html>
