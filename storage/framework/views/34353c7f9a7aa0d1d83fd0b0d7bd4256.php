<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="products-hero bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-3">
                        <i class="fas fa-dumbbell me-3"></i>Fitness Essentials
                    </h1>
                    <p class="lead mb-4">
                        Elevate your fitness journey with our premium, high-performance products designed to help you reach your goals.
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-block">
                    <img src="<?php echo e(asset('images/fitness-hero.png')); ?>" alt="Fitness Products" class="img-fluid hero-image">
                </div>
            </div>
        </div>
    </div>

    <!-- Product Filters and Search -->
    <div class="container mb-4" id="product-filters">
        <div class="row">
            <div class="col-md-6 mb-3">
                <select class="form-select" id="price-filter">
                    <option value="">Price Range</option>
                    <option value="0-50">LKR 0 - 5,000</option>
                    <option value="50-100">LKR 5,000 - 10,000</option>
                    <option value="100+">LKR 10,000+</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search products..." id="product-search">
                    <button class="btn btn-outline-secondary" type="button">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Listings Section -->
    <div class="container py-3" id="products">
        <div class="row row-cols-1 row-cols-md-3 row-cols-lg-4 g-4">
            <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col product-card" 
                     data-price="<?php echo e($product->price); ?>">
                    <div class="card h-100 border-0 shadow-sm product-item">
                        <div class="product-badge">
                            <?php if($product->is_featured): ?>
                                <span class="badge bg-warning text-dark">Featured</span>
                            <?php endif; ?>
                            <?php if($product->discount > 0): ?>
                                <span class="badge bg-danger">-<?php echo e($product->discount); ?>%</span>
                            <?php endif; ?>
                        </div>
                        <div class="product-image-container">
                            <?php if($product->image): ?>
                                <img src="<?php echo e(asset('storage/'.$product->image)); ?>" 
                                     class="card-img-top product-image" 
                                     alt="<?php echo e($product->name); ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x250" 
                                     class="card-img-top product-image" 
                                     alt="<?php echo e($product->name); ?>">
                            <?php endif; ?>
                            <div class="product-overlay">
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="btn btn-light">
                                    <i class="fas fa-eye me-2"></i>Quick View
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title mb-2"><?php echo e($product->name); ?></h5>
                            <p class="card-text text-muted small mb-2">
                                <?php echo e(Str::limit($product->description, 50)); ?>

                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="product-price">
                                    <?php if($product->discount > 0): ?>
                                        <span class="text-muted text-decoration-line-through me-2">
                                            LKR <?php echo e(number_format($product->original_price, 2)); ?>

                                        </span>
                                    <?php endif; ?>
                                    <span class="fw-bold text-success">
                                        LKR <?php echo e(number_format($product->price, 2)); ?>

                                    </span>
                                </div>
                                <div class="product-rating text-warning">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo e($i <= $product->rating ? 'text-warning' : 'text-muted'); ?>"></i>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex">
                            <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="flex-grow-1 me-2">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                </button>
                            </form>
                            <form action="<?php echo e(route('wishlist.store')); ?>" method="POST" class="flex-shrink-0">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="product_id" value="<?php echo e($product->id); ?>">
                                <button type="submit" class="btn btn-outline-danger" title="Add to Wishlist">
                                    <i class="fas fa-heart me-2"></i>Wishlist
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5">
            <?php echo e($products->links('pagination::bootstrap-4')); ?>

        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
        .products-hero {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            position: relative;
            overflow: hidden;
        }
        .products-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1600 800" preserveAspectRatio="none"%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1102.5 734.8c2.5-1.2 24.8-8.6 25.6-7.5.5.7-5.4 23.4-6.6 24.4-1.4-.3-19.4-3.4-19-17.9z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1226.3 782.3c13.6-7.9 14-25.4 1-33.8-13.6-8.5-32.6-.7-34.6 15-1.4 13.5 8.4 24.7 20.9 24.8 5.2 0 10.9-1.6 12.7-6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M1152.7 782.4c-9.7 5-9.9 16.4-1.4 21.8 8.5 5.3 22.6.7 24.2-8.4 1.1-6.8-4.4-15.3-12.8-13.4-4.3 1-7.4 4.4-10 8z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1234.8 762.3c-8.6 7-11.4 13.3-8.6 21.8 3.9 12 18.8 10.5 23.4 3.5 3.7-5.8 2.2-15.6-5.4-19.3-4.4-2.1-9.4-1.7-9.4 6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M1206.1 718.8c1-5.7-1.9-11.2-7.9-13.5-12.2-4.4-26 2.8-25.8 15.7-.1 10.2 9.5 16.3 19.3 14.4 7.6-1.7 12.1-7.2 14.4-16.6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M1071.5 798.3c15.4-7.3 14.6-25.4 1.5-33.7-13.6-8.8-32.9-.7-34.6 15-1.4 13.5 8.4 24.7 20.9 24.8 5.2 0 10.9-1.6 12.2-6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1062 774.5c-7.6 4.5-6.5 14.7 1.8 20.2 12.6 8 30.3-.2 28.1-13.5-1.6-10.5-16.9-12.3-29.9-6.7z"/%3E%3C/svg%3E');
            opacity: 0.1;
        }
        .hero-image {
            max-width: 350px;
            transform: rotate(-15deg);
            box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        }
        .product-card {
            transition: transform 0.3s ease;
        }
        .product-card:hover {
            transform: translateY(-10px);
        }
        .product-image-container {
            position: relative;
            overflow: hidden;
        }
        .product-image {
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }
        .product-card:hover .product-image {
            transform: scale(1.1);
        }
        .product-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }
        .product-card:hover .product-overlay {
            opacity: 1;
        }
        .product-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
        }
        .product-item {
            transition: all 0.3s ease;
        }
        .product-item:hover {
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
    </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const priceFilter = document.getElementById('price-filter');
            const productSearch = document.getElementById('product-search');
            const productCards = document.querySelectorAll('.product-card');

            // Wishlist form submission handler
            const wishlistForms = document.querySelectorAll('form[action="<?php echo e(route("wishlist.store")); ?>"]');
            wishlistForms.forEach(form => {
                form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    
                    fetch(this.action, {
                        method: 'POST',
                        body: new FormData(this),
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Create and show toast message
                        const toast = document.createElement('div');
                        toast.classList.add('toast', 'align-items-center', 'text-bg-success', 'border-0', 'position-fixed', 'top-0', 'end-0', 'm-3');
                        toast.setAttribute('role', 'alert');
                        toast.setAttribute('aria-live', 'assertive');
                        toast.setAttribute('aria-atomic', 'true');
                        
                        toast.innerHTML = `
                            <div class="d-flex">
                                <div class="toast-body">
                                    Product added to Wishlist
                                </div>
                                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                            </div>
                        `;
                        
                        document.body.appendChild(toast);
                        
                        // Use Bootstrap's toast method if available
                        if (window.bootstrap && window.bootstrap.Toast) {
                            const bsToast = new bootstrap.Toast(toast);
                            bsToast.show();
                        } else {
                            // Fallback toast display
                            toast.classList.add('show');
                            setTimeout(() => {
                                toast.classList.remove('show');
                                document.body.removeChild(toast);
                            }, 3000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
                });
            });

            function filterProducts() {
                const selectedPriceRange = priceFilter.value;
                const searchTerm = productSearch.value.toLowerCase();

                productCards.forEach(card => {
                    const price = parseFloat(card.dataset.price);
                    const productName = card.querySelector('.card-title').textContent.toLowerCase();

                    const priceMatch = selectedPriceRange === '' || 
                        (selectedPriceRange === '0-50' && price <= 5000) ||
                        (selectedPriceRange === '50-100' && price > 5000 && price <= 10000) ||
                        (selectedPriceRange === '100+' && price > 10000);
                    const searchMatch = searchTerm === '' || productName.includes(searchTerm);

                    card.style.display = priceMatch && searchMatch ? 'block' : 'none';
                });
            }

            priceFilter.addEventListener('change', filterProducts);
            productSearch.addEventListener('input', filterProducts);
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

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
                    <li><a href="<?php echo e(route('services.index')); ?>" class="text-white-50">Services</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-white-50">Products</a></li>
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
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/products/index.blade.php ENDPATH**/ ?>