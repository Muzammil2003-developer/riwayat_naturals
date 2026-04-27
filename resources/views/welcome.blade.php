@extends('layouts.app')

@section('content')
<style>
    .cod-cta {
        animation: codPulse 1.8s ease-in-out infinite;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
    }

    .cod-cta:hover {
        animation-play-state: paused;
        transform: translateY(-1px);
    }

    @keyframes codPulse {
        0%, 100% {
            transform: scale(1);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.18);
        }
        50% {
            transform: scale(1.035);
            box-shadow: 0 14px 28px rgba(45, 90, 39, 0.35);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .cod-cta {
            animation: none;
        }
    }

    .premium-dot {
        animation: premiumBlink 2.2s ease-in-out infinite;
    }

    @keyframes premiumBlink {
        0%, 100% {
            opacity: 0.35;
            box-shadow: 0 0 0 0 rgba(34, 197, 94, 0.15);
        }
        50% {
            opacity: 1;
            box-shadow: 0 0 12px 2px rgba(34, 197, 94, 0.45);
        }
    }

    @media (prefers-reduced-motion: reduce) {
        .premium-dot {
            animation: none;
        }
    }
</style>
<!-- Hero Section -->
<section class="motion-section relative py-24 overflow-hidden">
    <div class="absolute inset-0 leaf-pattern"></div>
    <div class="absolute top-0 right-0 w-96 h-96 bg-[#2d5a27]/10 rounded-full blur-3xl"></div>
    <div class="absolute bottom-0 left-0 w-64 h-64 bg-[#4a7c42]/10 rounded-full blur-3xl"></div>
    
    <div class="max-w-7xl mx-auto px-4 relative">
    <div class="text-center max-w-3xl mx-auto">
            <div data-aos="fade-up" data-aos-delay="100" class="inline-block px-4 py-1 bg-[#2d5a27]/10 rounded-full text-[#2d5a27] font-medium text-sm mb-6">
                &#10024; 100% Natural & Organic
            </div>
            <h1 data-aos="fade-up" data-aos-delay="200" class="text-5xl md:text-7xl font-bold text-[#1e3d1a] mb-6 leading-tight">
                Nature's Best for <br>
                <span class="text-[#2d5a27]">Beautiful Hair</span>
            </h1>
            <p data-aos="fade-up" data-aos-delay="400" class="text-xl text-gray-600 mb-10 max-w-2xl mx-auto">
                Discover our premium collection of natural hair oils that nourish, strengthen, and transform your hair. Free from harsh chemicals, full of nature's goodness.
            </p>
            <div data-aos="fade-up" data-aos-delay="600" class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="#products" class="green-gradient px-8 py-4 rounded-full text-white font-semibold hover:opacity-90 transition inline-flex items-center justify-center">
                    <i class="fas fa-shopping-bag mr-2"></i> Shop Now
                </a>
                <a href="#about" class="border-2 border-[#2d5a27] text-[#2d5a27] px-8 py-4 rounded-full font-semibold hover:bg-[#2d5a27] hover:text-white transition">
                    Learn More
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Products -->
<section id="products" class="motion-section py-20 bg-[#f2f2f2]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-extrabold text-black mb-4">Our Products</h2>
            <p data-aos="fade-up" data-aos-delay="200" class="text-black/70 text-lg">Premium natural hair oils for your hair care routine</p>
        </div>

        @if($products->isEmpty())
            <div class="text-center py-20">
                <div class="w-24 h-24 bg-[#f0f5ed] rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-flask text-4xl text-[#2d5a27]"></i>
                </div>
                <h3 class="text-2xl font-bold text-[#1e3d1a] mb-2">Coming Soon!</h3>
                <p class="text-gray-600">Our products are loading. Check back soon!</p>
            </div>
        @else
            <div class="space-y-8">
                @foreach($products as $index => $product)
                    <div data-aos="fade-up" data-aos-delay="{{ ($index * 100) }}" class="card-lift relative bg-white rounded-[28px] border border-black/10 shadow-[0_14px_36px_rgba(0,0,0,0.08)] p-4 md:p-5">
                        <div class="grid lg:grid-cols-[0.95fr,1.05fr] gap-0 lg:gap-5 items-center">
                            <div class="relative">
                                <div class="relative h-[300px] md:h-[380px] rounded-[24px] overflow-hidden bg-gradient-to-br from-[#121212] via-[#1a1a1a] to-black flex items-center justify-center">
                                    @if($product->image)
                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-contain object-center p-2 md:p-3">
                                    @else
                                        <div class="text-center text-[#d9b66e]">
                                            <div class="w-24 h-24 mx-auto mb-3 rounded-full border border-[#d9b66e]/40 flex items-center justify-center">
                                                <i class="fas fa-oil-can text-4xl"></i>
                                            </div>
                                            <p class="text-xs tracking-[0.2em] uppercase">Riwayat Naturals</p>
                                        </div>
                                    @endif
                                </div>

                                <div class="absolute top-3 left-3 bg-white/95 text-black text-xs font-semibold px-3 py-1 rounded-full shadow inline-flex items-center gap-2">
                                    <span class="premium-dot inline-block w-2 h-2 rounded-full bg-green-500"></span>
                                    Premium Blend
                                </div>
                                <div class="absolute -bottom-4 left-4 bg-[#2d5a27] text-white text-xs font-semibold px-3 py-1.5 rounded-full shadow">
                                    Organic Hair Oil
                                </div>
                            </div>

                            <div class="relative -mt-5 lg:mt-0">
                                <div class="bg-white rounded-2xl border border-black/10 shadow-[0_8px_20px_rgba(0,0,0,0.07)] p-5 md:p-6">
                                    <h3 class="text-2xl md:text-[30px] font-extrabold text-black leading-tight">{{ $product->name }}</h3>
                                    <p class="text-black/65 mt-2.5 text-sm md:text-base">{{ $product->description ?: 'Organic hair oil crafted for healthier, stronger, and shinier hair.' }}</p>

                                    <div class="flex items-center gap-3 mt-4 mb-4">
                                        <span class="text-2xl md:text-3xl font-extrabold text-black">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($product->price, 2) }}</span>
                                        <span class="bg-black text-white px-3 py-1 rounded-full text-xs font-semibold">Sale</span>
                                    </div>

                                    <div class="grid sm:grid-cols-2 gap-2.5 text-[13px] md:text-sm text-black/80 mb-5">
                                        <p class="bg-[#f6f8f5] rounded-xl px-3 py-2"><i class="fas fa-truck text-[#2d5a27] mr-2"></i>Delivery in 2 to 5 days</p>
                                        <p class="bg-[#f6f8f5] rounded-xl px-3 py-2"><i class="fas fa-leaf text-[#2d5a27] mr-2"></i>100% Organic Products</p>
                                        <p class="bg-[#f6f8f5] rounded-xl px-3 py-2 sm:col-span-2"><i class="fas fa-star text-[#2d5a27] mr-2"></i>100+ happy customer reviews</p>
                                    </div>

                                    <button type="button"
                                        onclick="openOrderModal({{ $product->id }}, null, @js($product->name), {{ $product->price }})"
                                        class="cod-cta w-full bg-black text-white py-3 rounded-xl text-base md:text-lg font-bold hover:opacity-90 transition">
                                        <i class="fas fa-cart-plus mr-2"></i>Buy with Cash on Delivery
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>

<!-- Discount Packages -->
@if(isset($packages) && $packages->isNotEmpty())
<section id="packages" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-12">
            <h2 data-aos="fade-up" class="text-4xl md:text-5xl font-extrabold text-black mb-4">Special Packages</h2>
            <p data-aos="fade-up" data-aos-delay="120" class="text-black/65 text-lg">Bundle offers with discounted prices for better value.</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $index => $package)
                @php
                    $savingPercent = $package->original_price > 0
                        ? round((($package->original_price - $package->discount_price) / $package->original_price) * 100)
                        : 0;
                @endphp
                <div data-aos="fade-up" data-aos-delay="{{ ($index * 100) }}" class="rounded-2xl border border-black/10 shadow-sm overflow-hidden bg-white">
                    <div class="h-52 bg-gradient-to-b from-[#171717] to-black flex items-center justify-center">
                        @if($package->image)
                            <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="w-full h-full object-cover">
                        @else
                            <i class="fas fa-gift text-[#d9b66e] text-6xl"></i>
                        @endif
                    </div>
                    <div class="p-5">
                        <div class="flex items-center justify-between gap-3 mb-2">
                            <h3 class="text-xl font-bold text-gray-900">{{ $package->name }}</h3>
                            @if($savingPercent > 0)
                                <span class="px-2.5 py-1 rounded-full bg-green-100 text-green-700 text-xs font-bold">Save {{ $savingPercent }}%</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600 mb-4">{{ $package->description ?: 'Limited-time package offer for premium hair care.' }}</p>
                        <div class="flex items-end gap-3">
                            <span class="text-gray-400 line-through">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($package->original_price, 2) }}</span>
                            <span class="text-2xl font-extrabold text-[#2d5a27]">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($package->discount_price, 2) }}</span>
                        </div>
                        <button type="button"
                            onclick="openOrderModal(null, {{ $package->id }}, @js($package->name), {{ $package->discount_price }})"
                            class="w-full mt-4 bg-black text-white py-3 rounded-md text-sm md:text-base font-bold hover:opacity-90 transition">
                            <i class="fas fa-cart-plus mr-2"></i>Order This Package
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- Features -->
<section class="motion-section py-16 bg-white">
<div class="max-w-7xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8">
        <div class="text-center" data-aos="fade-up" data-aos-delay="100">
            <div class="w-16 h-16 bg-[#f0f5ed] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-leaf text-[#2d5a27] text-2xl"></i>
            </div>
            <h3 class="font-bold text-[#1e3d1a]">100% Natural</h3>
            <p class="text-sm text-gray-500">No harsh chemicals</p>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="200">
            <div class="w-16 h-16 bg-[#f0f5ed] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-flask text-[#2d5a27] text-2xl"></i>
            </div>
            <h3 class="font-bold text-[#1e3d1a]">Herbal Formula</h3>
            <p class="text-sm text-gray-500">Ancient recipes</p>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="300">
            <div class="w-16 h-16 bg-[#f0f5ed] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-heart text-[#2d5a27] text-2xl"></i>
            </div>
            <h3 class="font-bold text-[#1e3d1a]">Gentle</h3>
            <p class="text-sm text-gray-500">Safe for all hair</p>
        </div>
        <div class="text-center" data-aos="fade-up" data-aos-delay="400">
            <div class="w-16 h-16 bg-[#f0f5ed] rounded-2xl flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-shipping-fast text-[#2d5a27] text-2xl"></i>
            </div>
            <h3 class="font-bold text-[#1e3d1a]">Fast Delivery</h3>
            <p class="text-sm text-gray-500">Free shipping</p>
        </div>
    </div>
</section>

<!-- About -->
<section id="about" class="motion-section py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-16 items-center">
        <div data-aos="fade-right">
            <div class="relative">
                <div class="w-full h-96 rounded-3xl overflow-hidden">
                    <img src="{{ asset('webimg/webimg.png') }}" alt="Natural ingredients" class="w-full h-full object-cover">
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6">
                    <p class="text-4xl font-bold text-[#2d5a27]">100%</p>
                    <p class="text-gray-500">Natural</p>
                </div>
            </div>
        </div>
        <div data-aos="fade-left">
            <h2 class="text-4xl font-bold text-[#1e3d1a] mb-6">Pure Nature, Beautiful Hair</h2>
            <p class="text-gray-600 text-lg mb-6">
                At Riwayat Naturals, we believe in the power of nature. Our hair oils are crafted from traditional recipes using pure, natural ingredients that have been used for generations.
            </p>
            <ul class="space-y-4">
                <li class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-[#2d5a27] mr-3"></i>
                    Free from sulfates and parabens
                </li>
                <li class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-[#2d5a27] mr-3"></i>
                    Cruelty-free and vegan
                </li>
                <li class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-[#2d5a27] mr-3"></i>
                    Suitable for all hair types
                </li>
                <li class="flex items-center text-gray-700">
                    <i class="fas fa-check-circle text-[#2d5a27] mr-3"></i>
                    Eco-friendly packaging
                </li>
            </ul>
        </div>
    </div>
</section>

<!-- Follow Us -->
<section class="motion-section py-12 bg-[#f8faf7] border-t border-b border-[#dce7d7]">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <h3 class="text-2xl font-bold text-[#1e3d1a] mb-6">Follow Us On</h3>
        <div class="flex items-center justify-center gap-4 md:gap-6">
            @if(!empty($siteSettings['tiktok_url']))
                <a href="{{ $siteSettings['tiktok_url'] }}" target="_blank" rel="noopener noreferrer" class="icon-pop float-soft w-12 h-12 rounded-full bg-white border border-[#dce7d7] flex items-center justify-center text-[#111] hover:bg-[#111] hover:text-white transition" aria-label="TikTok">
                    <img src="{{ asset('icons/tiktok.png') }}" alt="TikTok" class="w-6 h-6 object-contain">
                </a>
            @endif
            @if(!empty($siteSettings['facebook_url']))
                <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" class="icon-pop float-soft w-12 h-12 rounded-full bg-white border border-[#dce7d7] flex items-center justify-center text-[#1877f2] hover:bg-[#1877f2] hover:text-white transition" aria-label="Facebook">
                    <img src="{{ asset('icons/facebook.png') }}" alt="Facebook" class="w-6 h-6 object-contain">
                </a>
            @endif
            @if(!empty($siteSettings['youtube_url']))
                <a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" class="icon-pop float-soft w-12 h-12 rounded-full bg-white border border-[#dce7d7] flex items-center justify-center text-[#ff0000] hover:bg-[#ff0000] hover:text-white transition" aria-label="YouTube">
                    <img src="{{ asset('icons/youtube.png') }}" alt="YouTube" class="w-6 h-6 object-contain">
                </a>
            @endif
            @if(!empty($siteSettings['instagram_url']))
                <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" class="icon-pop float-soft w-12 h-12 rounded-full bg-white border border-[#dce7d7] flex items-center justify-center text-[#e1306c] hover:bg-[#e1306c] hover:text-white transition" aria-label="Instagram">
                    <img src="{{ asset('icons/insta.png') }}" alt="Instagram" class="w-6 h-6 object-contain">
                </a>
            @endif
        </div>
    </div>
</section>

<!-- Order Modal -->
<div id="orderModal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-md w-full overflow-hidden">
        <div class="green-gradient p-6">
            <div class="flex justify-between items-center">
                <h2 class="text-2xl font-bold text-white">Order Now</h2>
                <button onclick="closeOrderModal()" class="text-white/80 hover:text-white">
                    <i class="fas fa-times text-xl"></i>
                </button>
            </div>
            <p id="productName" class="text-white/80 mt-1"></p>
        </div>
        <form id="orderForm" method="POST" action="{{ route('orders.store') }}" class="p-6">
            @csrf
            <input type="hidden" name="product_id" id="productId">
            <input type="hidden" name="package_id" id="packageId">
            
            <div class="space-y-5">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Your Name</label>
                    <input type="text" name="customer_name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="Enter your name">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                    <input type="tel" name="customer_phone" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="Enter your phone number">
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Delivery Address</label>
                    <textarea name="customer_address" required rows="3" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="Enter your delivery address"></textarea>
                </div>
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Quantity</label>
                    <div class="flex items-center gap-4">
                        <button type="button" onclick="decreaseQty()" class="w-12 h-12 bg-[#f0f5ed] text-[#2d5a27] rounded-xl hover:bg-[#2d5a27] hover:text-white transition">
                            <i class="fas fa-minus"></i>
                        </button>
                        <input type="number" name="quantity" id="quantity" value="1" min="1" required class="w-20 text-center px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]">
                        <button type="button" onclick="increaseQty()" class="w-12 h-12 bg-[#f0f5ed] text-[#2d5a27] rounded-xl hover:bg-[#2d5a27] hover:text-white transition">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="bg-[#f0f5ed] p-4 rounded-xl">
                    <p class="text-gray-600">Total Price:</p>
                    <p id="totalPrice" class="text-3xl font-bold text-[#2d5a27]"></p>
                </div>
            </div>
            <button type="submit" class="w-full mt-6 green-gradient text-white py-4 rounded-xl font-bold hover:opacity-90 transition">
                <i class="fas fa-check-circle mr-2"></i> Place Order
            </button>
        </form>
    </div>
</div>

@if(session('success'))
<div id="orderSuccessPopup" class="fixed inset-0 z-[70] bg-black/45 flex items-center justify-center p-4">
    <div class="bg-white w-full max-w-md rounded-3xl shadow-2xl overflow-hidden">
        <div class="green-gradient p-5 flex items-center justify-between">
            <h3 class="text-white text-xl font-bold">Order Confirmed</h3>
            <button type="button" id="closeOrderSuccessPopup" class="text-white/80 hover:text-white transition" aria-label="Close confirmation popup">
                <i class="fas fa-times text-lg"></i>
            </button>
        </div>
        <div class="p-6 text-center">
            <div class="w-14 h-14 rounded-full bg-[#f0f5ed] text-[#2d5a27] flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-2xl"></i>
            </div>
            <p class="text-gray-800 font-semibold">{{ session('success') }}</p>
            <button type="button" id="okOrderSuccessPopup" class="mt-6 w-full green-gradient text-white py-3 rounded-xl font-semibold hover:opacity-90 transition">
                OK
            </button>
        </div>
    </div>
</div>
@endif

<script>
    let currentPrice = 0;

    function openOrderModal(productId, packageId, productName, price) {
        document.getElementById('productId').value = productId || '';
        document.getElementById('packageId').value = packageId || '';
        document.getElementById('productName').textContent = productName;
        currentPrice = price;
        updateTotalPrice();
        document.getElementById('orderModal').classList.remove('hidden');
        document.getElementById('orderModal').classList.add('flex');
    }

    function closeOrderModal() {
        document.getElementById('orderModal').classList.add('hidden');
        document.getElementById('orderModal').classList.remove('flex');
        document.getElementById('orderForm').reset();
        document.getElementById('quantity').value = 1;
        updateTotalPrice();
    }

    function increaseQty() {
        let qty = parseInt(document.getElementById('quantity').value);
        document.getElementById('quantity').value = qty + 1;
        updateTotalPrice();
    }

    function decreaseQty() {
        let qty = parseInt(document.getElementById('quantity').value);
        if (qty > 1) {
            document.getElementById('quantity').value = qty - 1;
            updateTotalPrice();
        }
    }

    function updateTotalPrice() {
        let qty = parseInt(document.getElementById('quantity').value) || 0;
        let total = currentPrice * qty;
        document.getElementById('totalPrice').textContent = '{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}' + total.toFixed(2);
    }

    document.getElementById('quantity').addEventListener('input', updateTotalPrice);

    document.getElementById('orderModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeOrderModal();
        }
    });

    const successPopup = document.getElementById('orderSuccessPopup');
    if (successPopup) {
        const closeSuccessPopup = () => successPopup.classList.add('hidden');
        document.getElementById('closeOrderSuccessPopup').addEventListener('click', closeSuccessPopup);
        document.getElementById('okOrderSuccessPopup').addEventListener('click', closeSuccessPopup);
        successPopup.addEventListener('click', function (e) {
            if (e.target === this) {
                closeSuccessPopup();
            }
        });
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape' && !successPopup.classList.contains('hidden')) {
                closeSuccessPopup();
            }
        });
    }
</script>
@endsection
