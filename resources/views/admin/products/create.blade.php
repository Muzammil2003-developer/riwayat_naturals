@extends('admin.layouts.main')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Add New Product</h1>
        <a href="{{ route('admin.products.index') }}" class="text-amber-600 hover:text-amber-700">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Product Name</label>
                    <input type="text" name="name" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="Enter product name">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="Enter product description"></textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Price ($)</label>
                    <input type="number" name="price" step="0.01" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="0.00">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Product Image</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-amber-400 transition cursor-pointer">
                        <input type="file" name="image" accept="image/*" class="hidden" id="imageInput" onchange="previewImage(event)">
                        <label for="imageInput" class="cursor-pointer">
                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            <p class="text-gray-500">Click to upload image</p>
                        </label>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="previewImg" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" checked class="w-5 h-5 text-amber-600 rounded focus:ring-amber-500">
                    <label for="is_active" class="ml-2 text-gray-700">Active (show on website)</label>
                </div>
            </div>

            <button type="submit" class="w-full mt-8 green-gradient text-white py-3 rounded-lg font-bold hover:bg-amber-700 transition">
                <i class="fas fa-save mr-2"></i> Save Product
            </button>
        </form>
    </div>
</div>

<script>
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection