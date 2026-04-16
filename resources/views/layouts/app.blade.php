<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Naturals - Natural Hair Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css">
    <style>
        :root {
            --primary: #2d5a27;
            --accent: #4a7c42;
            --light: #f0f5ed;
        }

        * { box-sizing: border-box; }
        
        html { overflow-x: hidden; }
        
        body {
            font-family: 'Poppins', sans-serif;
        }

        h1,
        h2,
        h3 {
            font-family: 'Playfair Display', serif;
        }

        .green-gradient {
            background: linear-gradient(135deg, #2d5a27 0%, #4a7c42 100%);
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 25px 50px rgba(45, 90, 39, 0.15);
        }

        .leaf-pattern {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='60' height='60' viewBox='0 0 60 60'%3E%3Cpath d='M30 5c-5 10-15 15-20 20s-5 15 0 20c5-5 10-10 20-20s15-15 20-20c-5-5-10-10-20-20z' fill='%232d5a27' fill-opacity='0.03'/%3E%3C/svg%3E");
        }

        .floating-leaf {
            position: fixed;
            font-size: 24px;
            color: #2d5a27;
            opacity: 0.3;
            pointer-events: none;
            z-index: 1;
            animation: float linear infinite;
        }

        @keyframes float {
            0% {
                transform: translateY(100vh) rotate(0deg);
            }

            100% {
                transform: translateY(-100px) rotate(360deg);
            }
        }

        @keyframes sway {

            0%,
            100% {
                transform: translateX(-10px) rotate(-5deg);
            }

            50% {
                transform: translateX(10px) rotate(5deg);
            }
        }
    </style>
    <div id="floating-elements"></div>
</head>

<body class="bg-[#f8faf7] min-h-screen" style="overflow-x: hidden;">
    <nav data-aos="fade-down" class="bg-white/95 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <a href="{{ route('home') }}" class="flex items-center space-x-3">
                    <div class="w-12 h-12 green-gradient rounded-full flex items-center justify-center">
                        <i class="fas fa-leaf text-white text-xl"></i>
                    </div>
                    <div>
                        <span class="text-xl font-bold text-[#2d5a27]">Riwayat Naturals</span>
                        <p class="text-xs text-gray-400 -mt-1">100% Natural Hair Care</p>
                    </div>
                </a>
                <div class="hidden md:flex items-center space-x-8">
                    <a href="{{ route('home') }}"
                        class="text-gray-600 hover:text-[#2d5a27] font-medium transition">Home</a>
                    <a href="{{ route('bestseller') }}"
                        class="text-gray-600 hover:text-[#2d5a27] font-medium transition">Best Sellers</a>
                    <a href="{{ route('about') }}"
                        class="text-gray-600 hover:text-[#2d5a27] font-medium transition">About</a>
                    <a href="{{ route('contact') }}"
                        class="text-gray-600 hover:text-[#2d5a27] font-medium transition">Contact</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-10 h-10 bg-green-600 rounded-full flex items-center justify-center text-white hover:bg-green-700 transition"
                            title="Admin Dashboard">
                            <i class="fas fa-tachometer-alt"></i>
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}"
                            class="w-10 h-10 bg-[#2d5a27] rounded-full flex items-center justify-center text-white hover:bg-[#1e3d1a] transition">
                            <i class="fas fa-user"></i>
                        </a>
                    @endauth
                </div>
                <!-- Mobile Menu Button -->
                <button onclick="toggleMobileMenu()" class="md:hidden p-2">
                    <i class="fas fa-bars text-xl text-[#2d5a27]"></i>
                </button>
            </div>
            <!-- Mobile Menu -->
            <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
                <div class="px-4 py-4 space-y-3">
                    <a href="{{ route('home') }}" class="block py-2 text-gray-600 hover:text-[#2d5a27]">Home</a>
                    <a href="{{ route('bestseller') }}" class="block py-2 text-gray-600 hover:text-[#2d5a27]">Best Sellers</a>
                    <a href="{{ route('about') }}" class="block py-2 text-gray-600 hover:text-[#2d5a27]">About</a>
                    <a href="{{ route('contact') }}" class="block py-2 text-gray-600 hover:text-[#2d5a27]">Contact</a>
                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 text-[#2d5a27] font-medium">Dashboard</a>
                    @else
                        <a href="{{ route('admin.login') }}" class="block py-2 text-[#2d5a27]">Login</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    @yield('content')

    <footer class="bg-[#2d5a27] text-white py-16 mt-20">
        <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-3 gap-12">
            <div>
                <div class="flex items-center space-x-3 mb-4">
                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center">
                        <i class="fas fa-leaf text-white text-xl"></i>
                    </div>
                    <span class="text-xl font-bold">Riwayat Naturals</span>
                </div>
                <p class="text-white/70">Premium natural hair care products for healthy, shiny, and beautiful hair. Made
                    with love from nature.</p>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Quick Links</h4>
                <ul class="space-y-2 text-white/70">
                    <li><a href="{{ route('home') }}" class="hover:text-white">Home</a></li>
                    <li><a href="{{ route('bestseller') }}" class="hover:text-white">Best Sellers</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-white">About</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-white">Contact</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold text-lg mb-4">Contact</h4>
                <ul class="space-y-2 text-white/70">
                    <li><i class="fas fa-envelope mr-2"></i>info@riwayathair.com</li>
                    <li><i class="fas fa-phone mr-2"></i>+1 234 567 890</li>
                </ul>
            </div>
        </div>
        <div class="max-w-7xl mx-auto px-4 mt-12 pt-8 border-t border-white/20 text-center text-white/60">
            <p>&copy; {{ date('Y') }} Riwayat Naturals. All rights reserved.</p>
        </div>
    </footer>

    <script>
        const floatingElements = document.getElementById('floating-elements');
        const elements = ['🍃', '🌿', '🍂', '🌱', '✨', '💚'];
        const colors = ['#2d5a27', '#4a7c42', '#6b8e6b', '#8fbc8f'];

        function createFloatingElement() {
            const el = document.createElement('div');
            el.className = 'floating-leaf';
            el.textContent = elements[Math.floor(Math.random() * elements.length)];
            el.style.left = Math.random() * 100 + 'vw';
            el.style.fontSize = (Math.random() * 20 + 15) + 'px';
            el.style.color = colors[Math.floor(Math.random() * colors.length)];
            el.style.opacity = Math.random() * 0.3 + 0.1;
            el.style.animationDuration = (Math.random() * 10 + 10) + 's';
            el.style.animationDelay = (Math.random() * 5) + 's';
            floatingElements.appendChild(el);

            setTimeout(() => el.remove(), 20000);
        }

        for (let i = 0; i < 8; i++) {
            setTimeout(createFloatingElement, i * 1000);
        }
        setInterval(createFloatingElement, 4000);
    </script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50,
            disable: 'mobile'
        });
    </script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>
</body>

</html>
