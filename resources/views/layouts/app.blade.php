<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Naturals - Natural Hair Care</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@400;500;600;700&family=Poppins:wght@300;400;500;600&display=swap"
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
            font-family: 'Manrope', 'Poppins', sans-serif;
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
    <nav data-aos="fade-down" class="bg-[#f5f5f5] border-b border-black/10 sticky top-0 z-50">
        <div class="border-b border-black/10">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2">
                <div class="grid grid-cols-3 items-center text-[11px] sm:text-xs font-bold tracking-wide">
                    <span class="justify-self-start text-black/60"><i class="fas fa-chevron-left"></i></span>
                    <p class="justify-self-center text-black text-center">{{ $siteSettings['announcement_text'] ?? 'Rivaaj Mahal Official WhatsApp Numbers : 0327 2222189' }}</p>
                    <span class="justify-self-end text-black/60"><i class="fas fa-chevron-right"></i></span>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3">
            <div class="grid grid-cols-3 items-center">
                <button class="hidden md:inline-flex w-10 h-10 rounded-full border border-black/15 items-center justify-center text-lg text-black hover:bg-black hover:text-white transition">
                    <i class="fas fa-search"></i>
                </button>
                <button onclick="toggleMobileMenu()" class="md:hidden justify-self-start p-2 text-2xl text-black">
                    <i class="fas fa-bars"></i>
                </button>

                <a href="{{ route('home') }}" class="justify-self-center text-center">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 mx-auto mb-1.5 rounded-full bg-white shadow-sm border border-[#d9c17f] flex items-center justify-center">
                        @if(!empty($siteSettings['logo']))
                            <img src="{{ $siteSettings['logo'] }}" alt="{{ $siteSettings['site_name'] ?? 'Logo' }}" class="w-full h-full rounded-full object-cover">
                        @else
                            <span class="text-[#caa44c] text-2xl sm:text-[28px] font-extrabold tracking-tight">RM</span>
                        @endif
                    </div>
                    <p class="text-[10px] uppercase tracking-[0.16em] text-black/60">{{ $siteSettings['site_name'] ?? 'Riwayat Naturals' }}</p>
                </a>

                <div class="justify-self-end flex items-center gap-2">
                    @auth
                        <a href="{{ route('admin.dashboard') }}"
                            class="w-10 h-10 rounded-full border border-black/15 flex items-center justify-center text-black hover:bg-black hover:text-white transition"
                            title="Admin Dashboard">
                            <i class="fas fa-user-cog"></i>
                        </a>
                    @else
                        <a href="{{ route('admin.login') }}"
                            class="w-10 h-10 rounded-full border border-black/15 flex items-center justify-center text-black hover:bg-black hover:text-white transition">
                            <i class="far fa-user"></i>
                        </a>
                    @endauth
                    <a href="{{ route('bestseller') }}" class="w-10 h-10 rounded-full border border-black/15 flex items-center justify-center text-black hover:bg-black hover:text-white transition">
                        <i class="fas fa-shopping-bag"></i>
                    </a>
                </div>
            </div>

            <div class="hidden md:flex items-center justify-center gap-8 mt-3 text-[17px]">
                <a href="{{ route('home') }}" class="text-black/80 hover:text-black font-medium transition">Home</a>
                <a href="{{ route('bestseller') }}" class="text-black/80 hover:text-black font-medium transition">Catalog</a>
                <a href="{{ route('contact') }}" class="text-black/80 hover:text-black font-medium transition">Contact</a>
            </div>
        </div>

        <div id="mobileMenu" class="hidden md:hidden bg-white border-t border-black/10">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block py-2 text-black/80 hover:text-black">Home</a>
                <a href="{{ route('bestseller') }}" class="block py-2 text-black/80 hover:text-black">Catalog</a>
                <a href="{{ route('about') }}" class="block py-2 text-black/80 hover:text-black">About</a>
                <a href="{{ route('contact') }}" class="block py-2 text-black/80 hover:text-black">Contact</a>
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block py-2 text-black font-medium">Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}" class="block py-2 text-black/80">Login</a>
                @endauth
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
            // Keep animations enabled on mobile, but respect reduced-motion settings.
            disable: function () {
                return window.matchMedia('(prefers-reduced-motion: reduce)').matches;
            }
        });
    </script>
    <script>
        function toggleMobileMenu() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        }
    </script>
</body>

</html>
