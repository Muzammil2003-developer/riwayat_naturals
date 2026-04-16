@extends('layouts.app')

@section('content')
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h1 data-aos="fade-up" class="text-5xl font-bold text-[#1e3d1a] mb-4">About Us</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-600 text-lg">Our story of natural hair care</p>
        </div>

        <div class="grid md:grid-cols-2 gap-16 items-center mb-20">
            <div class="relative">
                <div class="w-full h-96 bg-gradient-to-br from-[#2d5a27] to-[#4a7c42] rounded-3xl flex items-center justify-center">
                    <i class="fas fa-leaf text-white text-[150px] opacity-50"></i>
                </div>
                <div class="absolute -bottom-6 -right-6 bg-white rounded-2xl shadow-xl p-6" data-aos="zoom-in">
                    <p class="text-4xl font-bold text-[#2d5a27]">5+</p>
                    <p class="text-gray-500">Years Experience</p>
                </div>
            </div>
            <div data-aos="fade-left">
            <h2 data-aos="fade-up" class="text-4xl font-bold text-[#1e3d1a] mb-6">Pure Nature, Beautiful Hair</h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-gray-600 text-lg mb-6">
                    At Riwayat Naturals, we believe in the power of nature. Our hair oils are crafted from traditional recipes using pure, natural ingredients that have been used for generations.
                </p>
                <p class="text-gray-600 mb-6">
                    Our journey began with a simple mission: to provide natural, effective hair care products without harsh chemicals. Today, we continue that tradition with our carefully crafted formulas.
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

        <!-- Team Section -->
        <div class="text-center mt-20">
            <h2 class="text-3xl font-bold text-[#1e3d1a] mb-12">Why Choose Us?</h2>
            <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-8">
                <div class="bg-[#f8faf7] rounded-2xl p-6">
                    <div class="w-16 h-16 green-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#1e3d1a]">100% Natural</h3>
                    <p class="text-gray-500 text-sm mt-2">Pure ingredients from nature</p>
                </div>
                <div class="bg-[#f8faf7] rounded-2xl p-6">
                    <div class="w-16 h-16 green-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-flask text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#1e3d1a]">Proven Formula</h3>
                    <p class="text-gray-500 text-sm mt-2">Research-backed products</p>
                </div>
                <div class="bg-[#f8faf7] rounded-2xl p-6">
                    <div class="w-16 h-16 green-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-heart text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#1e3d1a]">Customer Love</h3>
                    <p class="text-gray-500 text-sm mt-2">Thousands of happy customers</p>
                </div>
                <div class="bg-[#f8faf7] rounded-2xl p-6">
                    <div class="w-16 h-16 green-gradient rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-shipping-fast text-white text-2xl"></i>
                    </div>
                    <h3 class="font-bold text-[#1e3d1a]">Fast Delivery</h3>
                    <p class="text-gray-500 text-sm mt-2">Free shipping on orders</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection