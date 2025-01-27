<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            {{-- Page Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-lg mb-10 p-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-4xl font-extrabold mb-4">My Orders</h1>
                    <p class="text-xl text-indigo-100">Track and manage your recent purchases</p>
                </div>
            </div>

            {{-- Orders Container --}}
            <div class="space-y-8">
                @if ($orders->isEmpty())
                    <div class="bg-white rounded-lg shadow-md p-10 text-center">
                        <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-6"></i>
                        <h2 class="text-2xl font-semibold text-gray-600 mb-4">No Orders Yet</h2>
                        <p class="text-gray-500 mb-6">Looks like you haven't made any purchases.</p>
                        <a href="{{ route('products.index') }}" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                            Start Shopping
                        </a>
                    </div>
                @else
                    @foreach ($orders as $order)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            {{-- Order Header --}}
                            <div class="bg-gray-100 px-6 py-4 flex justify-between items-center border-b">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Order #{{ $order->id }}</h3>
                                    <p class="text-sm text-gray-500">
                                        Placed on {{ $order->created_at->format('F d, Y') }}
                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                    @if ($order->status == 'pending') bg-yellow-100 text-yellow-800
                                    @elseif ($order->status == 'completed') bg-green-100 text-green-800
                                    @elseif ($order->status == 'cancelled') bg-red-100 text-red-800
                                    @else bg-gray-100 text-gray-800
                                    @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </div>

                            {{-- Order Details --}}
                            <div class="p-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    {{-- Order Items --}}
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-700">Order Items</h4>
                                        <div class="space-y-4">
                                            @foreach ($order->orderItems as $item)
                                                <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-lg">
                                                    <div class="flex-shrink-0">
                                                        @if ($item->product->image)
                                                            <img 
                                                                src="{{ asset('storage/'.$item->product->image) }}" 
                                                                alt="{{ $item->product->name }}" 
                                                                class="w-20 h-20 object-cover rounded-md"
                                                            >
                                                        @else
                                                            <div class="w-20 h-20 bg-gray-200 rounded-md flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400"></i>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-semibold text-gray-800">{{ $item->product->name }}</h5>
                                                        <p class="text-sm text-gray-600">
                                                            Quantity: {{ $item->quantity }} 
                                                            | Price: LKR {{ number_format($item->price, 2) }}
                                                        </p>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                    {{-- Order Summary --}}
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-700">Order Summary</h4>
                                        <div class="bg-gray-50 p-6 rounded-lg space-y-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Subtotal</span>
                                                <span class="font-semibold">LKR {{ number_format($order->subtotal, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Tax</span>
                                                <span class="font-semibold">LKR {{ number_format($order->tax, 2) }}</span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Shipping</span>
                                                <span class="font-semibold">LKR {{ number_format($order->shipping, 2) }}</span>
                                            </div>
                                            <hr class="border-gray-200">
                                            <div class="flex justify-between text-xl font-bold text-gray-800">
                                                <span>Total</span>
                                                <span>LKR {{ number_format($order->total_amount, 2) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- Pagination --}}
                    <div class="mt-8">
                        {{ $orders->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="bg-dark text-white py-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>FitSpot</h5>
                    <p>Your ultimate destination for fitness and wellness.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="{{ route('services.index') }}" class="text-white-50">Services</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-white-50">Products</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Connect With Us</h5>
                    <div class="social-links">
                        <a href="#" class="text-white-50 me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-white-50 me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-4 bg-white">
            <div class="text-center">
                <p>&copy; 2024 FitSpot. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</x-app-layout>
