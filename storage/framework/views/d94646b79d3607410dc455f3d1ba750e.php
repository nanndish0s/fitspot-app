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
    <div class="container product-detail py-5">
        <div class="row g-5">
            <!-- Product Image -->
            <div class="col-lg-6">
                <div class="product-image-container position-sticky top-0">
                    <div class="product-badge">
                        <?php if($product->quantity < 5 && $product->quantity > 0): ?>
                            <span class="badge bg-warning">Low Stock</span>
                        <?php elseif($product->quantity == 0): ?>
                            <span class="badge bg-danger">Out of Stock</span>
                        <?php endif; ?>
                    </div>
                    <div class="image-wrapper">
                        <?php if($product->image): ?>
                            <img 
                                src="<?php echo e(asset('storage/'.$product->image)); ?>" 
                                alt="<?php echo e($product->name); ?>" 
                                class="img-fluid product-image"
                                data-zoom-image="<?php echo e(asset('storage/'.$product->image)); ?>"
                            >
                        <?php else: ?>
                            <img 
                                src="https://via.placeholder.com/600x600" 
                                alt="Placeholder Image" 
                                class="img-fluid product-image"
                            >
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Product Details -->
            <div class="col-lg-6">
                <div class="product-info">
                    <nav aria-label="breadcrumb" class="mb-4">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="/" class="text-decoration-none">Home</a></li>
                            <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>" class="text-decoration-none">Products</a></li>
                            <li class="breadcrumb-item active"><?php echo e($product->name); ?></li>
                        </ol>
                    </nav>

                    <h1 class="product-title display-6 fw-bold mb-3"><?php echo e($product->name); ?></h1>

                    <div class="product-meta d-flex align-items-center mb-4">
                        <div class="rating text-warning me-3">
                            <?php
                                $averageRating = $product->reviews()->avg('rating') ?? 0;
                                $roundedRating = round($averageRating, 1);
                            ?>
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fa<?php echo e($i <= $roundedRating ? 's' : 'r'); ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="text-muted">
                            (<?php echo e($roundedRating); ?> / 5.0 from <?php echo e($product->reviews()->count()); ?> reviews)
                        </span>
                    </div>

                    <p class="product-description text-muted mb-4"><?php echo e($product->description); ?></p>

                    <div class="product-price mb-4">
                        <h2 class="text-primary">
                            LKR <?php echo e(number_format($product->price, 2)); ?>

                            <?php if($product->original_price > $product->price): ?>
                                <small class="text-muted text-decoration-line-through ms-2">
                                    LKR <?php echo e(number_format($product->original_price, 2)); ?>

                                </small>
                                <span class="badge bg-success ms-2">
                                    <?php echo e(round(($product->original_price - $product->price) / $product->original_price * 100)); ?>% OFF
                                </span>
                            <?php endif; ?>
                        </h2>
                        <small class="text-muted"><?php echo e($product->quantity); ?> units available</small>
                    </div>

                    <form action="<?php echo e(route('cart.add', $product->id)); ?>" method="POST" class="mb-4">
                        <?php echo csrf_field(); ?>
                        <div class="quantity-selector d-flex align-items-center mb-3">
                            <label for="quantity" class="me-3">Quantity:</label>
                            <div class="input-group" style="max-width: 150px;">
                                <button class="btn btn-outline-secondary" type="button" id="decrease-quantity">-</button>
                                <input 
                                    type="number" 
                                    class="form-control text-center" 
                                    id="quantity" 
                                    name="quantity" 
                                    value="1" 
                                    min="1" 
                                    max="<?php echo e($product->quantity); ?>"
                                >
                                <button class="btn btn-outline-secondary" type="button" id="increase-quantity">+</button>
                            </div>
                        </div>

                        <div class="d-grid gap-2 d-md-flex">
                            <button 
                                type="submit" 
                                class="btn btn-primary btn-lg flex-grow-1" 
                                <?php echo e($product->quantity == 0 ? 'disabled' : ''); ?>

                            >
                                <i class="fas fa-shopping-cart me-2"></i>
                                Add to Cart
                            </button>
                            <button 
                                type="button" 
                                class="btn btn-outline-secondary btn-lg"
                                onclick="addToWishlist(<?php echo e($product->id); ?>)"
                            >
                                <i class="far fa-heart me-2"></i>
                                Wishlist
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="row mt-5">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h3>Customer Reviews</h3>
                    <?php if(auth()->guard()->check()): ?>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                        <i class="fas fa-plus me-2"></i>Add Review
                    </button>
                    <?php endif; ?>
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $product->reviews; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $review): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="review-card mb-3 p-3 border-bottom position-relative">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="reviewer-info">
                                <strong><?php echo e($review->user->name); ?></strong>
                                <span class="text-muted ms-2">
                                    <?php echo e($review->created_at->diffForHumans()); ?>

                                </span>
                            </div>
                            <div class="review-rating text-warning">
                                <?php for($i = 1; $i <= 5; $i++): ?>
                                    <i class="fa<?php echo e($i <= $review->rating ? 's' : 'r'); ?> fa-star"></i>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <p class="review-text text-muted"><?php echo e($review->comment); ?></p>
                        
                        <?php if(auth()->guard()->check()): ?>
                            <?php if(auth()->id() === $review->user_id): ?>
                                <div class="review-actions position-absolute top-0 end-0 m-2">
                                    <form 
                                        action="<?php echo e(route('reviews.destroy', $review->id)); ?>" 
                                        method="POST" 
                                        class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this review?');"
                                    >
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button 
                                            type="submit" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Delete Review"
                                        >
                                            <i class="fas fa-trash-alt me-1"></i>Delete
                                        </button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="text-muted">No reviews yet. Be the first to review this product!</p>
                <?php endif; ?>

                <?php $__env->startPush('styles'); ?>
                <style>
                    .review-card {
                        position: relative;
                    }
                    .review-actions {
                        opacity: 0.6;
                        transition: opacity 0.3s ease;
                    }
                    .review-card:hover .review-actions {
                        opacity: 1;
                    }
                </style>
                <?php $__env->stopPush(); ?>
            </div>
        </div>

        <!-- Add Review Modal -->
        <?php if(auth()->guard()->check()): ?>
        <div class="modal fade" id="addReviewModal" tabindex="-1" aria-labelledby="addReviewModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addReviewModalLabel">Write a Review</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="<?php echo e(route('reviews.store', $product->id)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <?php if($errors->any()): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><?php echo e($error); ?></li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="mb-3">
                                <label class="form-label">Your Rating</label>
                                <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mb-2"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <div class="star-rating d-flex justify-content-center align-items-center">
                                    <?php for($i = 5; $i >= 1; $i--): ?>
                                        <input 
                                            type="radio" 
                                            id="star<?php echo e($i); ?>" 
                                            name="rating" 
                                            value="<?php echo e($i); ?>"
                                            class="d-none"
                                            <?php echo e(old('rating') == $i ? 'checked' : ''); ?>

                                        >
                                        <label for="star<?php echo e($i); ?>" class="star-label me-1">
                                            <i class="fas fa-star"></i>
                                        </label>
                                    <?php endfor; ?>
                                    <span class="ms-2 text-muted rating-text">
                                        <?php if(old('rating')): ?>
                                            <?php echo e(old('rating')); ?> / 5
                                        <?php else: ?>
                                            Select Rating
                                        <?php endif; ?>
                                    </span>
                                </div>
                                
                                <div class="row mt-2">
                                    <div class="col-md-6 mx-auto">
                                        <input 
                                            type="number" 
                                            name="rating_number" 
                                            id="rating_number" 
                                            class="form-control text-center <?php echo e($errors->has('rating') ? 'is-invalid' : ''); ?>" 
                                            min="1" 
                                            max="5" 
                                            placeholder="Enter Rating (1-5)"
                                            value="<?php echo e(old('rating')); ?>"
                                        >
                                        <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="reviewComment" class="form-label">Your Review</label>
                                <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="text-danger mb-2"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                <textarea 
                                    class="form-control <?php echo e($errors->has('comment') ? 'is-invalid' : ''); ?>" 
                                    id="reviewComment" 
                                    name="comment" 
                                    rows="4" 
                                    placeholder="Share your experience with this product"
                                ><?php echo e(old('comment')); ?></textarea>
                                <?php $__errorArgs = ['comment'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <div class="invalid-feedback"><?php echo e($message); ?></div>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit Review</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <?php $__env->startPush('styles'); ?>
        <style>
            .product-detail {
                max-width: 1200px;
            }
            .product-image-container {
                position: relative;
                z-index: 1;
            }
            .product-badge {
                position: absolute;
                top: 15px;
                left: 15px;
                z-index: 10;
            }
            .image-wrapper {
                background-color: #f8f9fa;
                border-radius: 15px;
                overflow: hidden;
                box-shadow: 0 10px 30px rgba(0,0,0,0.05);
            }
            .product-image {
                transition: transform 0.3s ease;
            }
            .product-image:hover {
                transform: scale(1.05);
            }
            .product-info {
                padding-top: 30px;
            }
            .review-card {
                transition: background-color 0.3s ease;
            }
            .review-card:hover {
                background-color: #f8f9fa;
            }
            .star-rating {
                display: flex;
                flex-direction: row-reverse;
                justify-content: center;
            }
            .star-rating .star-label {
                color: #ddd;
                font-size: 2rem;
                cursor: pointer;
                transition: color 0.2s;
                margin: 0 5px;
            }
            .star-rating input:checked ~ label,
            .star-rating input:checked ~ label ~ label {
                color: #ffc107;
            }
            .star-rating .star-label:hover,
            .star-rating .star-label:hover ~ label {
                color: #ffc107;
            }
            .star-rating .star-label {
                color: #ddd;
                font-size: 2rem;
                cursor: pointer;
                transition: color 0.2s;
            }
            .star-rating input:checked ~ label,
            .star-rating input:checked ~ label ~ label {
                color: #ffc107;
            }
            .star-rating .star-label:hover,
            .star-rating .star-label:hover ~ label {
                color: #ffc107;
            }
        </style>
        <?php $__env->stopPush(); ?>

        <?php $__env->startPush('scripts'); ?>
        <script>
            function addToWishlist(productId) {
                fetch("<?php echo e(route('wishlist.store')); ?>", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
                    },
                    body: JSON.stringify({ product_id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Product added to wishlist!');
                    } else {
                        alert('Failed to add product to wishlist.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred.');
                });
            }

            // Quantity selector
            document.addEventListener('DOMContentLoaded', function() {
                const quantityInput = document.getElementById('quantity');
                const decreaseBtn = document.getElementById('decrease-quantity');
                const increaseBtn = document.getElementById('increase-quantity');

                decreaseBtn.addEventListener('click', () => {
                    if (quantityInput.value > 1) {
                        quantityInput.value = parseInt(quantityInput.value) - 1;
                    }
                });

                increaseBtn.addEventListener('click', () => {
                    if (quantityInput.value < <?php echo e($product->quantity); ?>) {
                        quantityInput.value = parseInt(quantityInput.value) + 1;
                    }
                });
            });

            document.addEventListener('DOMContentLoaded', function() {
                <?php if($errors->any()): ?>
                    var reviewModal = new bootstrap.Modal(document.getElementById('addReviewModal'));
                    reviewModal.show();
                <?php endif; ?>
            });

            document.addEventListener('DOMContentLoaded', function() {
                const starLabels = document.querySelectorAll('.star-label');
                const ratingText = document.querySelector('.rating-text');
                const ratingNumberInput = document.getElementById('rating_number');
                const starInputs = document.querySelectorAll('input[name="rating"]');

                // Star label click handler
                starLabels.forEach(label => {
                    label.addEventListener('click', function() {
                        const rating = this.previousElementSibling.value;
                        ratingText.textContent = `${rating} / 5`;
                        ratingNumberInput.value = rating;
                    });
                });

                // Number input change handler
                ratingNumberInput.addEventListener('change', function() {
                    const rating = parseInt(this.value);
                    if (rating >= 1 && rating <= 5) {
                        // Uncheck all stars
                        starInputs.forEach(input => input.checked = false);
                        
                        // Check the corresponding star
                        const selectedStar = document.getElementById(`star${rating}`);
                        if (selectedStar) {
                            selectedStar.checked = true;
                        }
                        
                        ratingText.textContent = `${rating} / 5`;
                    } else {
                        this.value = '';
                        ratingText.textContent = 'Select Rating';
                    }
                });
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
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/products/show.blade.php ENDPATH**/ ?>