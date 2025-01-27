@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">
        {{-- Dashboard Header --}}
        <div class="bg-gradient-to-r from-green-500 to-green-700 text-white p-8 rounded-t-xl shadow-2xl mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold tracking-tight">Seller Dashboard</h1>
                    <p class="mt-2 text-xl opacity-80">Welcome, {{ auth()->user()->name }}! Manage your business with ease.</p>
                </div>
                <div>
                    <a href="{{ route('products.create') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md shadow-lg text-white bg-green-600 hover:bg-green-700 transition duration-300 transform hover:scale-105">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add New Product
                    </a>
                </div>
            </div>
        </div>

        {{-- Dashboard Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {{-- Sales Overview Card --}}
            <div class="bg-white rounded-xl shadow-lg p-6 transform transition hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Sales Overview</h3>
                    <i class="fas fa-chart-line text-green-600 text-3xl"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Revenue</span>
                        <span class="font-bold text-green-600">LKR {{ number_format($totalRevenue ?? 0, 2) }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Orders</span>
                        <span class="font-bold text-blue-600">{{ $totalOrders ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Average Order Value</span>
                        <span class="font-bold text-purple-600">LKR {{ number_format($averageOrderValue ?? 0, 2) }}</span>
                    </div>
                </div>
            </div>

            {{-- Product Statistics Card --}}
            <div class="bg-white rounded-xl shadow-lg p-6 transform transition hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Product Stats</h3>
                    <i class="fas fa-box-open text-blue-600 text-3xl"></i>
                </div>
                <div class="space-y-4">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Total Products</span>
                        <span class="font-bold text-blue-600">{{ $totalProducts ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Active Products</span>
                        <span class="font-bold text-green-600">{{ $activeProducts ?? 0 }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Out of Stock</span>
                        <span class="font-bold text-red-600">{{ $outOfStockProducts ?? 0 }}</span>
                    </div>
                </div>
            </div>

            {{-- Quick Actions Card --}}
            <div class="bg-white rounded-xl shadow-lg p-6 transform transition hover:scale-105">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-2xl font-bold text-gray-800">Quick Actions</h3>
                    <i class="fas fa-bolt text-yellow-500 text-3xl"></i>
                </div>
                <div class="space-y-4">
                    <a href="{{ route('products.create') }}" class="block bg-green-50 hover:bg-green-100 p-3 rounded-lg transition flex items-center justify-between">
                        <span class="text-green-700">Add New Product</span>
                        <i class="fas fa-plus-circle text-green-600"></i>
                    </a>
                    <a href="{{ route('seller.products') }}" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition flex items-center justify-between">
                        <span class="text-blue-700">Manage Products</span>
                        <i class="fas fa-edit text-blue-600"></i>
                    </a>
                    <a href="{{ route('seller.orders') }}" class="block bg-purple-50 hover:bg-purple-100 p-3 rounded-lg transition flex items-center justify-between">
                        <span class="text-purple-700">View Orders</span>
                        <i class="fas fa-shopping-cart text-purple-600"></i>
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Products Section --}}
        <div class="mt-12 bg-white rounded-xl shadow-lg p-8">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold text-gray-800">Recent Products</h2>
                <a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-800 transition">View All Products</a>
            </div>

            @if($recentProducts && $recentProducts->isNotEmpty())
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($recentProducts as $product)
                        <div class="bg-gray-50 rounded-lg overflow-hidden shadow-md transform transition hover:scale-105">
                            <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg text-gray-800">{{ $product->name }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ Str::limit($product->description, 50) }}</p>
                                <div class="flex justify-between items-center">
                                    <span class="text-green-600 font-semibold">LKR {{ number_format($product->price, 2) }}</span>
                                    <a href="{{ route('products.edit', $product) }}" class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <p class="text-gray-600 text-xl">No recent products found.</p>
                    <a href="{{ route('products.create') }}" class="mt-4 inline-block bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition">
                        Add Your First Product
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .transform {
        transition: transform 0.3s ease-in-out;
    }
    .transform:hover {
        transform: scale(1.03);
    }
</style>
@endpush
