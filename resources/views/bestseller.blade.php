@extends('layouts.app')

@section('content')
<section class="py-20 bg-[#f8faf7]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h1 data-aos="fade-up" class="text-5xl font-bold text-[#1e3d1a] mb-4">Best Sellers</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-600 text-lg">Our most loved products by customers</p>
        </div>

        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($products->take(4) as $product)
            <div class="bg-white rounded-3xl shadow-lg overflow-hidden product-card transition-all duration-300 cursor-pointer" onclick="openOrderModal({{ $product->id }}, '{{ $product->name }}', {{ $product->price }})">
                <div class="h-64 bg-gradient-to-br from-[#f0f5ed] to-white flex items-center justify-center relative">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-32 h-32 green-gradient rounded-full flex items-center justify-center">
                            <i class="fas fa-oil-can text-white text-5xl"></i>
                        </div>
                    @endif
                    <div class="absolute top-4 right-4 bg-red-500 text-white px-3 py-1 rounded-full text-xs font-bold flex items-center">
                        <i class="fas fa-fire mr-1"></i> Best Seller
                    </div>
                </div>
                <div class="p-6">
                    <h3 class="text-xl font-bold text-[#1e3d1a] mb-2">{{ $product->name }}</h3>
                    <p class="text-gray-500 text-sm mb-4 line-clamp-2">{{ $product->description }}</p>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-[#2d5a27]">₨{{ number_format($product->price, 2) }}</span>
                        <span class="bg-[#2d5a27] text-white px-4 py-2 rounded-full text-sm font-medium">
                            <i class="fas fa-shopping-cart mr-1"></i> Order
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
function openOrderModal(productId, productName, price) {
    document.getElementById('productId').value = productId;
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
    document.getElementById('totalPrice').textContent = '₨' + total.toFixed(2);
}

let currentPrice = 0;
document.getElementById('quantity').addEventListener('input', updateTotalPrice);
document.getElementById('orderModal').addEventListener('click', function(e) {
    if (e.target === this) closeOrderModal();
});
</script>
@endsection