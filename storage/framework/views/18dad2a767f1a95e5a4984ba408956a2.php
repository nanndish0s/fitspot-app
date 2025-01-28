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
    <div class="container py-5">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>" class="text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
            </ol>
        </nav>

        <div class="row">
            <div class="col-lg-9">
                <!-- Product Card -->
                <div class="card shadow-lg border-0 rounded-3">
                    <div class="row g-0">
                        <!-- Product Image Section -->
                        <div class="col-md-6">
                            <div class="position-relative">
                                <?php if($product->quantity < 5 && $product->quantity > 0): ?>
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-warning">Low Stock</span>
                                    </div>
                                <?php elseif($product->quantity == 0): ?>
                                    <div class="position-absolute top-0 start-0 m-3">
                                        <span class="badge bg-danger">Out of Stock</span>
                                    </div>
                                <?php endif; ?>
                                <div class="text-center bg-light h-100 p-4">
                                    <?php if($product->image): ?>
                                        <img src="<?php echo e(asset('storage/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid rounded-3">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/500" alt="Placeholder Image" class="img-fluid rounded-3">
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <!-- Product Details Section -->
                        <div class="col-md-6">
                            <div class="card-body p-4">
                                <h1 class="card-title display-6 fw-bold text-primary mb-2"><?php echo e($product->name); ?></h1>
                                
                                <!-- Rating -->
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rating text-warning me-2">
                                        <?php
                                            $averageRating = $product->reviews()->avg('rating') ?? 0;
                                            $roundedRating = round($averageRating, 1);
                                            $fullStars = floor($roundedRating);
                                            $halfStar = $roundedRating - $fullStars >= 0.5;
                                        ?>
        
                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                            <?php if($i <= $fullStars): ?>
                                                <i class="fas fa-star"></i>
                                            <?php elseif($halfStar && $i == $fullStars + 1): ?>
                                                <i class="fas fa-star-half-alt"></i>
                                            <?php else: ?>
                                                <i class="far fa-star"></i>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    </div>
                                    <span class="text-muted">
                                        (<?php echo e($roundedRating); ?> / 5.0 from <?php echo e($product->reviews()->count()); ?> reviews)
                                    </span>
                                </div>

                                <p class="text-muted fst-italic mb-4"><?php echo e($product->description); ?></p>
                                <hr>
                                
                                <!-- Price and Stock -->
                                <div class="mb-4">
                                    <div class="d-flex align-items-baseline">
                                        <h2 class="text-success mb-0 me-2">LKR <?php echo e(number_format($product->price, 2)); ?></h2>
                                        <?php if($product->original_price > $product->price): ?>
                                            <span class="text-decoration-line-through text-muted">LKR <?php echo e(number_format($product->original_price, 2)); ?></span>
                                        <?php endif; ?>
                                    </div>
                                    <small class="text-muted">Stock: <?php echo e($product->quantity); ?> units available</small>
                                </div>

                                <!-- Add to Cart Form -->
                                <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="mb-4">
                                    <?php echo csrf_field(); ?>
                                    <div class="d-flex align-items-center mb-4">
                                        <label for="quantity" class="me-2">Quantity:</label>
                                        <div class="input-group" style="max-width: 150px;">
                                            <button class="btn btn-outline-secondary" type="button" id="decrease-quantity">-</button>
                                            <input type="number" 
                                                   class="form-control text-center" 
                                                   id="quantity" 
                                                   name="quantity" 
                                                   value="1" 
                                                   min="1" 
                                                   max="<?php echo e($product->quantity); ?>" 
                                                   aria-label="Product Quantity">
                                            <button class="btn btn-outline-secondary" type="button" id="increase-quantity">+</button>
                                        </div>
                                        <small class="ms-2 text-muted">(<?php echo e($product->quantity); ?> available)</small>
                                    </div>
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-start mb-4">
                                        <button type="submit" class="btn btn-primary btn-lg me-md-2" <?php echo e($product->quantity == 0 ? 'disabled' : ''); ?>>
                                            <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                                        </button>
                                    </div>
                                </form>

                                <!-- Specifications -->
                                <div class="mt-4">
                                    <h5 class="text-secondary">Product Details</h5>
                                    <div class="table-responsive">
                                        <table class="table table-sm">
                                            <tbody>
                                                <tr>
                                                    <th class="w-25">Brand:</th>
                                                    <td><?php echo e($product->brand ?? 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Weight:</th>
                                                    <td><?php echo e($product->weight ?? 'N/A'); ?></td>
                                                </tr>
                                                <tr>
                                                    <th>Category:</th>
                                                    <td><?php echo e($product->category ?? 'N/A'); ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Reviews Section -->
                <div class="mt-5">
                    <ul class="nav nav-tabs" id="reviewTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" type="button" role="tab">Reviews</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="reviewTabContent">
                        <div class="tab-pane fade show active" id="reviews">
                            <?php if(session('success')): ?>
                                <div class="alert alert-success">
                                    <?php echo e(session('success')); ?>

                                </div>
                            <?php endif; ?>

                            <div class="row">
                                <!-- Display Reviews -->
                                <div class="col-md-8">
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <h4>Customer Reviews</h4>
                                    </div>
                                    <?php $__empty_1 = true; $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <div class="card mb-3">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <h5 class="card-title mb-0"><?php echo e($review->user->name); ?></h5>
                                                    <div class="text-warning">
                                                        <?php for($i = 1; $i <= 5; $i++): ?>
                                                            <?php if($i <= $review->rating): ?>
                                                                <i class="fas fa-star"></i>
                                                            <?php else: ?>
                                                                <i class="far fa-star"></i>
                                                            <?php endif; ?>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                                <p class="text-muted small mb-2"><?php echo e($review->created_at->diffForHumans()); ?></p>
                                                <p class="card-text"><?php echo e($review->comment); ?></p>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <p class="text-muted">No reviews yet.</p>
                                    <?php endif; ?>
                                </div>

                                <!-- Add Review Section -->
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h5 class="card-title">Write a Review</h5>
                                            <?php if(auth()->guard()->check()): ?>
                                                <form action="<?php echo e(route('reviews.store', $product)); ?>" method="POST">
                                                    <?php echo csrf_field(); ?>
                                                    <div class="mb-3">
                                                        <label for="rating" class="form-label">Rating</label>
                                                        <div class="star-rating">
                                                            <input type="radio" name="rating" value="5" id="star5">
                                                            <label for="star5"></label>
                                                            <input type="radio" name="rating" value="4" id="star4">
                                                            <label for="star4"></label>
                                                            <input type="radio" name="rating" value="3" id="star3">
                                                            <label for="star3"></label>
                                                            <input type="radio" name="rating" value="2" id="star2">
                                                            <label for="star2"></label>
                                                            <input type="radio" name="rating" value="1" id="star1">
                                                            <label for="star1"></label>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="comment" class="form-label">Review</label>
                                                        <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                                </form>
                                            <?php else: ?>
                                                <p class="text-muted">Please <a href="<?php echo e(route('login')); ?>">log in</a> to write a review.</p>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-3">
                <!-- Delivery Information -->
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Delivery Information</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-truck me-2 text-primary"></i>Free shipping on orders over LKR 5,000</li>
                            <li class="mb-2"><i class="fas fa-sync me-2 text-primary"></i>30-day return policy</li>
                            <li><i class="fas fa-shield-alt me-2 text-primary"></i>Secure payment</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Related Products -->
        <div class="mt-5">
            <h3 class="mb-4">Related Products</h3>
            <div class="row">
                <?php $__empty_1 = true; $__currentLoopData = $relatedProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $relatedProduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100">
                            <?php if($relatedProduct->image): ?>
                                <img src="<?php echo e(asset('storage/'.$relatedProduct->image)); ?>" class="card-img-top" alt="<?php echo e($relatedProduct->name); ?>">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300" class="card-img-top" alt="Placeholder Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo e($relatedProduct->name); ?></h5>
                                <p class="card-text text-success">LKR <?php echo e(number_format($relatedProduct->price, 2)); ?></p>
                                <a href="<?php echo e(route('products.show', $relatedProduct->id)); ?>" class="btn btn-primary">View Product</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12">
                        <p class="text-muted text-center">No related products found.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const decreaseBtn = document.getElementById('decrease-quantity');
            const increaseBtn = document.getElementById('increase-quantity');
            const quantityInput = document.getElementById('quantity');
            const maxQuantity = parseInt(quantityInput.getAttribute('max'));

            decreaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue > 1) {
                    quantityInput.value = currentValue - 1;
                }
            });

            increaseBtn.addEventListener('click', function() {
                let currentValue = parseInt(quantityInput.value);
                if (currentValue < maxQuantity) {
                    quantityInput.value = currentValue + 1;
                }
            });
        });
    </script>
    <?php $__env->stopPush(); ?>

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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/products/show.blade.php ENDPATH**/ ?>