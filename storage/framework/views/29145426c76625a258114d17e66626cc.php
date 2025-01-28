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
    <div class="container mt-4">
        <h1 class="text-2xl font-bold mb-4">Your Shopping Cart</h1>

        <?php if($cartItems->isEmpty()): ?>
            <div class="alert alert-info text-center">
                <p>Your cart is empty!</p>
                <a href="<?php echo e(route('products.index')); ?>" class="btn btn-primary mt-3">Continue Shopping</a>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            Cart Items
                        </div>
                        <div class="card-body">
                            <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="d-flex align-items-center border-bottom pb-3 mb-3">
                                    <img src="<?php echo e($cartItem->product->image ? asset('storage/'.$cartItem->product->image) : 'https://via.placeholder.com/100'); ?>" 
                                         alt="<?php echo e($cartItem->product->name); ?>" 
                                         class="img-thumbnail me-3" 
                                         style="max-width: 100px;">
                                    
                                    <div class="flex-grow-1">
                                        <h5 class="mb-1"><?php echo e($cartItem->product->name); ?></h5>
                                        <p class="text-muted mb-1">Price: LKR <?php echo e(number_format($cartItem->product->price, 2)); ?></p>
                                        
                                        <form action="<?php echo e(route('cart.update', $cartItem->id)); ?>" method="POST" class="d-flex align-items-center">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('PUT'); ?>
                                            <div class="input-group" style="max-width: 150px;">
                                                <button class="btn btn-outline-secondary quantity-decrease" type="button">-</button>
                                                <input type="number" name="quantity" class="form-control text-center" 
                                                       value="<?php echo e($cartItem->quantity); ?>" 
                                                       min="1" 
                                                       max="<?php echo e($cartItem->product->stock); ?>">
                                                <button class="btn btn-outline-secondary quantity-increase" type="button">+</button>
                                            </div>
                                            <button type="submit" class="btn btn-sm btn-primary ms-2">Update</button>
                                        </form>
                                    </div>
                                    
                                    <form action="<?php echo e(route('cart.remove', $cartItem->id)); ?>" method="POST" class="ms-3">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <span>LKR <?php echo e(number_format($total, 2)); ?></span>
                            </p>
                            <p class="d-flex justify-content-between">
                                <span>Tax (10%):</span>
                                <span>LKR <?php echo e(number_format($total * 0.1, 2)); ?></span>
                            </p>
                            <hr>
                            <p class="d-flex justify-content-between fw-bold">
                                <span>Total:</span>
                                <span>LKR <?php echo e(number_format($total * 1.1, 2)); ?></span>
                            </p>
                            
                            <form action="<?php echo e(route('checkout.session')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <button type="submit" class="btn btn-success w-100 mt-3">
                                    Proceed to Checkout
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('scripts'); ?>
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
<?php endif; ?><?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/cart/index.blade.php ENDPATH**/ ?>