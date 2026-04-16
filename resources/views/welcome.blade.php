@extends('layouts.app')

@section('content')
<!-- Hero Section -->
<section class="relative py-24 overflow-hidden">
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

<!-- Features -->
<section class="py-16 bg-white">
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

<!-- Products -->
<section id="products" class="py-20 bg-[#f2f2f2]">
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
                    <div data-aos="fade-up" data-aos-delay="{{ ($index * 100) }}" class="bg-white rounded-[24px] border border-black/10 shadow-[0_12px_28px_rgba(0,0,0,0.08)] overflow-hidden">
                        <div class="grid lg:grid-cols-[1fr,1.15fr]">
                            <div class="relative min-h-[240px] lg:min-h-[340px] bg-gradient-to-b from-[#171717] to-black flex items-center justify-center">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="text-center text-[#d9b66e]">
                                        <div class="w-28 h-28 mx-auto mb-4 rounded-full border border-[#d9b66e]/40 flex items-center justify-center">
                                            <i class="fas fa-oil-can text-5xl"></i>
                                        </div>
                                        <p class="text-sm tracking-[0.22em] uppercase">Riwayat Naturals</p>
                                    </div>
                                @endif
                            </div>

                            <div class="p-5 md:p-7">
                                <h3 class="text-2xl md:text-3xl font-extrabold text-black leading-tight">{{ $product->name }}</h3>
                                <p class="text-black/65 mt-3 text-sm md:text-base">{{ $product->description ?: 'Organic hair oil crafted for healthier, stronger, and shinier hair.' }}</p>

                                <div class="flex items-center gap-3 mt-5 mb-4">
                                    <span class="text-2xl md:text-3xl font-semibold text-black">{{ $siteSettings['currency_symbol'] ?? 'Rs.' }}{{ number_format($product->price, 2) }}</span>
                                    <span class="bg-black text-white px-3 py-1 rounded text-xs md:text-sm font-semibold">Sale</span>
                                </div>

                                <div class="space-y-2 text-sm md:text-base text-black/75 mb-5">
                                    <p><i class="fas fa-truck text-[#2d5a27] mr-2"></i>Order will be delivered within 2 to 5 days</p>
                                    <p><i class="fas fa-leaf text-[#2d5a27] mr-2"></i>100% Organic Products</p>
                                    <p><i class="fas fa-star text-[#2d5a27] mr-2"></i>100+ happy customer reviews</p>
                                </div>

                                <button type="button"
                                    onclick="openOrderModal({{ $product->id }}, null, @js($product->name), {{ $product->price }})"
                                    class="w-full bg-black text-white py-3 rounded-md text-base md:text-lg font-bold hover:opacity-90 transition">
                                    <i class="fas fa-cart-plus mr-2"></i>Buy with Cash on Delivery
                                </button>

                                <p class="mt-3 text-sm md:text-base text-black/70"><i class="fas fa-seedling text-[#2d5a27] mr-2"></i>Organic Hair Oil</p>
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

<!-- About -->
<section id="about" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 grid md:grid-cols-2 gap-16 items-center">
        <div data-aos="fade-right">
            <div class="relative">
                <div class="w-full h-96 bg-gradient-to-br from-[#2d5a27] to-[#4a7c42] rounded-3xl flex items-center justify-center">
                    <i class="fas fa-leaf text-white text-[150px] opacity-50"></i>
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
