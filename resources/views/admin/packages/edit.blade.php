@extends('admin.layouts.main')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Edit Package</h1>
        <a href="{{ route('admin.packages.index') }}" class="text-amber-600 hover:text-amber-700">
            <i class="fas fa-arrow-left mr-1"></i> Back
        </a>
    </div>

    <div class="bg-white rounded-xl shadow-lg p-8">
        <form action="{{ route('admin.packages.update', $package->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <div>
                    <label class="block text-gray-700 font-medium mb-2">Package Name</label>
                    <input type="text" name="name" value="{{ $package->name }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Description</label>
                    <textarea name="description" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">{{ $package->description }}</textarea>
                </div>

                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Original Price</label>
                        <input type="number" name="original_price" step="0.01" value="{{ $package->original_price }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-gray-700 font-medium mb-2">Discount Price</label>
                        <input type="number" name="discount_price" step="0.01" value="{{ $package->discount_price }}" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-2">Package Image</label>
                    <div id="imageDropzone" class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-amber-400 transition cursor-pointer">
                        <input type="file" name="image" accept="image/*" class="sr-only" id="imageInput" onchange="previewImage(event)">
                        <label for="imageInput" class="cursor-pointer block">
                            @if($package->image)
                                <img src="{{ asset('storage/' . $package->image) }}" alt="{{ $package->name }}" class="max-h-48 mx-auto rounded-lg mb-3">
                            @else
                                <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                            @endif
                            <p class="text-gray-500">Click to change image</p>
                        </label>
                        <div id="imagePreview" class="mt-4 hidden">
                            <img id="previewImg" src="" alt="Preview" class="max-h-48 mx-auto rounded-lg">
                        </div>
                    </div>
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="is_active" id="is_active" value="1" {{ $package->is_active ? 'checked' : '' }} class="w-5 h-5 text-amber-600 rounded focus:ring-amber-500">
                    <label for="is_active" class="ml-2 text-gray-700">Active (show on website)</label>
                </div>
            </div>

            <button type="submit" class="w-full mt-8 green-gradient text-white py-3 rounded-lg font-bold hover:bg-amber-700 transition">
                <i class="fas fa-save mr-2"></i> Update Package
            </button>
        </form>
    </div>
</div>

<script>
    (function () {
        const input = document.getElementById('imageInput');
        const dropzone = document.getElementById('imageDropzone');
        if (input && dropzone) {
            dropzone.addEventListener('click', function () {
                input.click();
            });
        }
    })();

    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('previewImg').src = e.target.result;
                document.getElementById('imagePreview').classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection


