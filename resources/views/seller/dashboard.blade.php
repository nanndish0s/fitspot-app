<x-guest-layout>
    <!-- Dashboard Header -->
    <div class="bg-green-500 text-white p-8 rounded-t-lg shadow-xl">
        <h2 class="text-4xl font-bold">My Products</h2>
        <p class="mt-2 text-xl">Manage and view your products easily from this dashboard</p>
    </div>

    <!-- Dashboard Content -->
    <div class="container mx-auto py-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar (Navigation) -->
            <div class="bg-white shadow-lg p-6 rounded-lg space-y-4">
                <h3 class="text-2xl font-semibold text-gray-700">Seller Dashboard</h3>
                <ul class="space-y-3">
                    <li><a href="{{ route('seller.dashboard') }}" class="text-green-600 hover:text-green-800 font-medium text-lg">Dashboard</a></li>
                    <li><a href="{{ route('products.create') }}" class="text-green-600 hover:text-green-800 font-medium text-lg">Add Product</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-green-600 hover:text-green-800 font-medium text-lg">Manage Products</a></li>
                </ul>
            </div>

            <!-- Main Content: List of Products -->
            <div class="lg:col-span-3">
                @if($products->isEmpty())
                    <div class="bg-white p-8 rounded-lg shadow-xl">
                        <p class="text-center text-2xl text-gray-700">You have not listed any products yet.</p>
                        <a href="{{ route('products.create') }}" class="mt-4 block text-center bg-green-600 text-white py-3 px-6 rounded-full hover:bg-green-700 transition-all">Add New Product</a>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        @foreach($products as $product)
                            <div class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                                <!-- Product Image -->
                                <img src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}" class="w-full h-48 object-cover rounded-lg shadow-md">

                                <!-- Product Info -->
                                <div class="mt-6">
                                    <h3 class="text-xl font-semibold text-gray-800">{{ $product->name }}</h3>
                                    <p class="text-gray-600 mt-2">{{ $product->description }}</p>
                                    <p class="mt-4 text-lg font-bold text-gray-800">Price: LKR {{ number_format($product->price, 2) }}</p>
                                    <p class="text-gray-600 mt-2">Quantity: {{ $product->quantity }}</p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-6 flex justify-between items-center">
                                    <a href="{{ route('products.edit', $product->id) }}" class="text-green-600 hover:text-green-800 font-medium">Edit</a>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-guest-layout>
