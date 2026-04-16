@extends('admin.layouts.main')

@section('content')
<div class="max-w-md mx-auto mt-20">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <div class="text-center mb-8">
            <div class="w-16 h-16 green-gradient rounded-full flex items-center justify-center mx-auto mb-3">
                <i class="fas fa-user-shield text-white text-3xl"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-800">Admin Login</h1>
            <p class="text-gray-500 text-sm">Sign in to your account</p>
        </div>

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-medium mb-2">Email</label>
                <input type="email" name="email" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2d5a27]" placeholder="admin@example.com">
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 font-medium mb-2">Password</label>
                <input type="password" name="password" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#2d5a27]" placeholder="••••••••">
            </div>
            <button type="submit" class="w-full green-gradient text-white py-3 rounded-lg font-bold hover:opacity-90">
                <i class="fas fa-sign-in-alt mr-2"></i> Login
            </button>
        </form>
    </div>
</div>
@endsection