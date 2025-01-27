@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">
        <div class="bg-white shadow-2xl rounded-xl overflow-hidden">
            {{-- Header --}}
            <div class="bg-gradient-to-r from-blue-500 to-blue-700 px-6 py-8 text-white">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-4xl font-extrabold tracking-tight">Edit Product</h1>
                        <p class="mt-2 text-xl opacity-80">Update details for {{ $product->name }}</p>
                    </div>
                    <div>
                        <a href="{{ route('seller.products') }}" class="inline-flex items-center px-4 py-2 border border-white text-white rounded-md hover:bg-white hover:text-blue-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Back to Products
                        </a>
                    </div>
                </div>
            </div>

            {{-- Form --}}
            <form 
                action="{{ route('products.update', $product) }}" 
                method="POST" 
                enctype="multipart/form-data" 
                x-data="productForm()"
                @submit.prevent="validateAndSubmit"
            >
                @csrf
                @method('PUT')

                <div class="p-8 space-y-6">
                    {{-- Product Name --}}
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Product Name</label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name" 
                            x-model="name"
                            value="{{ old('name', $product->name) }}"
                            required 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 
                            @error('name') border-red-500 @enderror"
                            placeholder="Enter product name"
                        >
                        @error('name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea 
                            name="description" 
                            id="description" 
                            x-model="description"
                            rows="4" 
                            class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500
                            @error('description') border-red-500 @enderror"
                            placeholder="Describe your product"
                        >{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Price and Quantity Row --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- Price --}}
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Price ($)</label>
                            <input 
                                type="number" 
                                name="price" 
                                id="price" 
                                x-model="price"
                                value="{{ old('price', $product->price) }}"
                                step="0.01" 
                                min="0"
                                required 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500
                                @error('price') border-red-500 @enderror"
                                placeholder="0.00"
                            >
                            @error('price')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Quantity --}}
                        <div>
                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                            <input 
                                type="number" 
                                name="quantity" 
                                id="quantity" 
                                x-model="quantity"
                                value="{{ old('quantity', $product->quantity) }}"
                                min="0" 
                                required 
                                class="block w-full px-4 py-3 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500
                                @error('quantity') border-red-500 @enderror"
                                placeholder="Number of items"
                            >
                            @error('quantity')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Image Upload --}}
                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Product Image</label>
                        <div 
                            x-data="imagePreview()" 
                            class="mt-2 flex justify-center px-6 pt-5 pb-6 border-2 border-gray-300 border-dashed rounded-md 
                            hover:border-blue-500 transition"
                        >
                            <div class="space-y-1 text-center">
                                <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <div class="flex text-sm text-gray-600">
                                    <label for="image" class="relative cursor-pointer bg-white rounded-md font-medium text-blue-600 hover:text-blue-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-blue-500">
                                        <span>Upload a new file</span>
                                        <input 
                                            id="image" 
                                            name="image" 
                                            type="file" 
                                            class="sr-only" 
                                            @change="previewImage"
                                            accept="image/*"
                                        >
                                    </label>
                                    <p class="pl-1">or drag and drop</p>
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF up to 2MB</p>
                                
                                {{-- Current Image --}}
                                @if ($product->image_path)
                                    <div class="mt-4 flex justify-center">
                                        <img 
                                            src="{{ Storage::url($product->image_path) }}" 
                                            alt="{{ $product->name }}" 
                                            class="max-h-48 rounded-md shadow-md"
                                        >
                                    </div>
                                @endif

                                {{-- Preview New Image --}}
                                <img 
                                    x-show="imagePreviewUrl" 
                                    :src="imagePreviewUrl" 
                                    class="mt-4 mx-auto max-h-48 rounded-md shadow-md" 
                                    x-ref="imagePreview"
                                >
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Submit Button --}}
                    <div class="text-center mt-8">
                        <button 
                            type="submit" 
                            class="inline-flex items-center px-8 py-3 border border-transparent text-base font-medium rounded-full shadow-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition transform hover:scale-105"
                        >
                            <i class="fas fa-save mr-2"></i>
                            Update Product
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function productForm() {
        return {
            name: '{{ old('name', $product->name) }}',
            description: '{{ old('description', $product->description) }}',
            price: '{{ old('price', $product->price) }}',
            quantity: '{{ old('quantity', $product->quantity) }}',
            validateAndSubmit() {
                // Basic client-side validation
                if (!this.name || !this.price || !this.quantity) {
                    alert('Please fill in all required fields');
                    return;
                }
                
                // Submit the form
                this.$el.submit();
            }
        }
    }

    function imagePreview() {
        return {
            imagePreviewUrl: null,
            previewImage(event) {
                const file = event.target.files[0];
                const reader = new FileReader();
                
                reader.onload = (e) => {
                    this.imagePreviewUrl = e.target.result;
                };
                
                reader.readAsDataURL(file);
            }
        }
    }
</script>
@endpush

@push('styles')
<style>
    [x-cloak] { display: none !important; }
</style>
@endpush
