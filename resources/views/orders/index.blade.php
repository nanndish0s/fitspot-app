<x-app-layout>
    <!-- Page Title Section -->
    <section class="bg-gray-800 text-white text-center py-20">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold">My Orders</h2>
            <p class="mt-4 text-xl">View your order history</p>
        </div>
    </section>

    <!-- Orders Section -->
    <section class="container mx-auto py-20 px-4 flex-grow">
        @if ($orders->isEmpty())
            <p class="text-center text-xl">You have no orders yet.</p>
        @else
            <div class="space-y-6">
                @foreach ($orders as $order)
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-semibold">Order #{{ $order->id }}</h3>
                            <span class="text-sm px-3 py-1 rounded 
                                @if ($order->status == 'pending') bg-yellow-200 text-yellow-800
                                @elseif ($order->status == 'completed') bg-green-200 text-green-800
                                @else bg-red-200 text-red-800
                                @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-600">Ordered on: {{ $order->created_at->format('F d, Y') }}</p>
                            <p class="text-xl font-bold">Total: LKR {{ number_format($order->total_amount, 2) }}</p>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-lg font-semibold mb-2">Order Items</h4>
                            <div class="space-y-2">
                                @foreach ($order->orderItems as $item)
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            @if ($item->product->image)
                                                <img src="{{ asset('storage/'.$item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                            @else
                                                <img src="https://via.placeholder.com/150" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded-md mr-4">
                                            @endif
                                            <div>
                                                <p class="font-semibold">{{ $item->product->name }}</p>
                                                <p class="text-gray-600">Quantity: {{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <p class="font-bold">LKR {{ number_format($item->price, 2) }}</p>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </section>

    <footer class="bg-dark text-white py-5">
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
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
