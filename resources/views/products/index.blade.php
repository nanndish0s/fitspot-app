<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('Our Products') }}
            </h2>
        </div>
    </x-slot>

    <!-- Product Listings Section -->
    <div class="container py-5">
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($products as $product)
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        @if ($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @else
                            <img src="https://via.placeholder.com/150" class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
                        @endif
                        <div class="card-body">
                            <h5 class="card-title">{{ $product->name }}</h5>
                            <p class="card-text text-muted small">{{ Str::limit($product->description, 50) }}</p>
                            <p class="card-text fw-bold text-success">LKR {{ number_format($product->price, 2) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-between align-items-center">
                            <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-outline-secondary">View</a>
                            <div class="d-flex align-items-center">
                                <form action="{{ route('wishlist.store') }}" method="POST" class="me-2" onsubmit="return handleWishlistSubmit(event)">
                                    @csrf
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="fas fa-heart me-1"></i> Wishlist
                                    </button>
                                </form>
                                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $products->links() }}
        </div>
    </div>
</x-app-layout>

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

@section('scripts')
<script>
    function handleWishlistSubmit(event) {
        event.preventDefault();
        
        const form = event.target;
        const formData = new FormData(form);

        console.log('Wishlist Form Submission:', {
            action: form.action,
            method: form.method,
            data: Object.fromEntries(formData)
        });

        fetch(form.action, {
            method: form.method,
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token')
            }
        })
        .then(response => {
            console.log('Wishlist Response:', response);
            return response.json();
        })
        .then(data => {
            console.log('Wishlist Response Data:', data);
            // Redirect to wishlist page on successful addition
            if (data.success) {
                window.location.href = "{{ route('wishlist.index') }}";
            } else if (data.error) {
                alert(data.error);
            }
        })
        .catch(error => {
            console.error('Wishlist Error:', error);
            alert('An error occurred while adding to wishlist');
        });

        return false;
    }
</script>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
