<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Wishlist') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @if($wishlistServices->count() > 0 || $wishlistProducts->count() > 0)
                            {{-- Services Wishlist --}}
                            @foreach($wishlistServices as $item)
                                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                    <div class="p-4">
                                        <h2 class="text-xl font-semibold mb-2">{{ $item->service->name }}</h2>
                                        <p class="text-gray-600 mb-4">{{ $item->service->description }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-primary">
                                                ${{ number_format($item->service->price, 2) }}
                                            </span>
                                            <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                    Remove
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            {{-- Products Wishlist --}}
                            @foreach($wishlistProducts as $item)
                                <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                    <div class="p-4">
                                        <h2 class="text-xl font-semibold mb-2">{{ $item->product->name }}</h2>
                                        <p class="text-gray-600 mb-4">{{ Str::limit($item->product->description, 100) }}</p>
                                        <div class="flex justify-between items-center">
                                            <span class="text-lg font-bold text-primary">
                                                ${{ number_format($item->product->price, 2) }}
                                            </span>
                                            <div class="flex space-x-2">
                                                <form action="{{ route('wishlist.destroy', $item->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition">
                                                        Remove
                                                    </button>
                                                </form>
                                                <form action="{{ route('cart.add', $item->product->id) }}" method="POST" class="inline">
                                                    @csrf
                                                    <button type="submit" class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 transition">
                                                        Add to Cart
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="col-span-full text-center py-8">
                                <p class="text-gray-600">Your wishlist is empty.</p>
                                <div class="mt-4 space-x-4">
                                    <a href="{{ route('services.index') }}" class="inline-block bg-primary text-white px-4 py-2 rounded hover:bg-primary-dark transition">
                                        Explore Services
                                    </a>
                                    <a href="{{ route('products.index') }}" class="inline-block bg-secondary text-white px-4 py-2 rounded hover:bg-secondary-dark transition">
                                        Browse Products
                                    </a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
