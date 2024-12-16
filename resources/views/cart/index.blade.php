<x-app-layout>
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Your Shopping Cart</h1>

        @if ($cartItems->isEmpty())
            <div class="alert alert-info text-center">
                <p>Your cart is empty!</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">Continue Shopping</a>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Cart Items
                        </div>
                        <div class="card-body">
                            @foreach ($cartItems as $cartItem)
                                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                    <img src="{{ $cartItem->product->image ? asset('storage/'.$cartItem->product->image) : 'https://via.placeholder.com/100' }}" 
                                         alt="{{ $cartItem->product->name }}" 
                                         class="img-thumbnail me-3" 
                                         style="max-width: 100px;">
                                    
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1">{{ $cartItem->product->name }}</h5>
                                        <p class="text-muted mb-1">Price: LKR {{ number_format($cartItem->product->price, 2) }}</p>
                                        
                                        <form action="{{ route('cart.update', $cartItem->id) }}" method="POST" class="d-flex align-items-center">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group" style="max-width: 150px;">
                                                <button class="btn btn-outline-secondary quantity-decrease" type="button">-</button>
                                                <input type="number" name="quantity" class="form-control text-center" 
                                                       value="{{ $cartItem->quantity }}" 
                                                       min="1" 
                                                       max="{{ $cartItem->product->stock }}">
                                                <button class="btn btn-outline-secondary quantity-increase" type="button">+</button>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                        </form>
                                    </div>
                                    
                                    <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST" class="ms-3">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            Order Summary
                        </div>
                        <div class="card-body">
                            <p class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span>LKR {{ number_format($total, 2) }}</span>
                            </p>
                            <p class="d-flex justify-content-between">
                                <span>Tax (10%):</span>
                                <span>LKR {{ number_format($total * 0.1, 2) }}</span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span>LKR {{ number_format($total * 1.1, 2) }}</span>
                            </p>
                            
                            <form action="{{ route('checkout.session') }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100 mt-3">
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quantityInputs = document.querySelectorAll('input[name="quantity"]');
            
            quantityInputs.forEach(input => {
                const decreaseBtn = input.previousElementSibling;
                const increaseBtn = input.nextElementSibling;
                
                decreaseBtn.addEventListener('click', function() {
                    let currentValue = parseInt(input.value);
                    if (currentValue > 1) {
                        input.value = currentValue - 1;
                    }
                });
                
                increaseBtn.addEventListener('click', function() {
                    let currentValue = parseInt(input.value);
                    let maxValue = parseInt(input.getAttribute('max'));
                    if (currentValue < maxValue) {
                        input.value = currentValue + 1;
                    }
                });
            });
        });
    </script>
    @endpush

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