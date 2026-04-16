@extends('layouts.app')

@section('content')
<section class="py-20 bg-[#f8faf7]">
    <div class="max-w-7xl mx-auto px-4">
        <div class="text-center mb-16">
            <h1 data-aos="fade-up" class="text-5xl font-bold text-[#1e3d1a] mb-4">Contact Us</h1>
            <p data-aos="fade-up" data-aos-delay="200" class="text-gray-600 text-lg">We'd love to hear from you</p>
        </div>

        <div class="grid md:grid-cols-2 gap-16">
            <!-- Contact Info -->
            <div data-aos="fade-right">
                <h2 data-aos="fade-up" class="text-3xl font-bold text-[#1e3d1a] mb-6">Get in Touch</h2>
                <p data-aos="fade-up" data-aos-delay="200" class="text-gray-600 mb-8">Have questions about our products? Need help with your order? We're here to help!</p>
                
                <div class="space-y-6">
                    <div data-aos="fade-up" data-aos-delay="300" class="flex items-start gap-4">
                        <div class="w-14 h-14 green-gradient rounded-xl flex items-center justify-center text-white shrink-0">
                            <i class="fas fa-map-marker-alt text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1e3d1a]">Our Location</h3>
                            <p class="text-gray-600">123 Nature Street, Garden City, GC 12345</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 green-gradient rounded-xl flex items-center justify-center text-white shrink-0">
                            <i class="fas fa-phone text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1e3d1a]">Phone</h3>
                            <p class="text-gray-600">+1 234 567 890</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 green-gradient rounded-xl flex items-center justify-center text-white shrink-0">
                            <i class="fas fa-envelope text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1e3d1a]">Email</h3>
                            <p class="text-gray-600">info@riwayathair.com</p>
                        </div>
                    </div>
                    <div class="flex items-start gap-4">
                        <div class="w-14 h-14 green-gradient rounded-xl flex items-center justify-center text-white shrink-0">
                            <i class="fas fa-clock text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-[#1e3d1a]">Working Hours</h3>
                            <p class="text-gray-600">Mon - Sat: 9AM - 6PM</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Contact Form -->
            <div data-aos="fade-left" class="bg-white rounded-3xl shadow-lg p-8">
                <h2 data-aos="fade-up" class="text-3xl font-bold text-[#1e3d1a] mb-6">Send us a Message</h2>
                
                @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-4">
                    {{ session('success') }}
                </div>
                @endif

                <form method="POST" action="{{ route('contact.send') }}" class="space-y-5">
                    @csrf
                    <div data-aos="fade-up" data-aos-delay="400">
                        <label class="block text-gray-700 font-medium mb-2">Your Name</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="Enter your name">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Email Address</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="Enter your email">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Phone Number</label>
                        <input type="tel" name="phone" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="Enter your phone">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Message</label>
                        <textarea name="message" required rows="4" class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-[#2d5a27] focus:border-[#2d5a27]" placeholder="How can we help you?"></textarea>
                    </div>
                    <button type="submit" class="w-full green-gradient text-white py-4 rounded-xl font-bold hover:opacity-90 transition">
                        <i class="fas fa-paper-plane mr-2"></i> Send Message
                    </button>
                </form>
            </div>
        </div>

        <!-- Map -->
        <div class="mt-16">
            <div class="w-full h-96 bg-[#f0f5ed] rounded-3xl flex items-center justify-center">
                <div class="text-center">
                    <i class="fas fa-map text-6xl text-[#2d5a27] mb-4"></i>
                    <p class="text-gray-600">Map placeholder</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection