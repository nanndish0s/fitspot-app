<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        
        <?php if(session('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-check-circle text-green-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-green-700">
                            <?php echo e(session('success')); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-6">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class="fas fa-exclamation-circle text-red-400"></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <?php echo e(session('error')); ?>

                        </p>
                    </div>
                </div>
            </div>
        <?php endif; ?>

        
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-4xl font-extrabold text-gray-800">Your Shopping Cart</h1>
            <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                <i class="fas fa-shopping-bag mr-2"></i>
                Continue Shopping
            </a>
        </div>

        <?php if($cartItems->isEmpty()): ?>
            <div class="text-center bg-white shadow-md rounded-lg p-12">
                <i class="fas fa-shopping-cart text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600 mb-4">Your cart is empty</h2>
                <p class="text-gray-500 mb-6">Looks like you haven't added any items to your cart yet.</p>
                <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                    Explore Products
                </a>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                
                <div class="md:col-span-2 space-y-6">
                    <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cartItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white shadow-md rounded-lg p-6 flex items-center space-x-6">
                            
                            <img 
                                src="<?php echo e($cartItem->product->image ? Storage::url($cartItem->product->image) : asset('images/default-product.png')); ?>" 
                                alt="<?php echo e($cartItem->product->name); ?>" 
                                class="w-24 h-24 object-cover rounded-md"
                            >

                            
                            <div class="flex-grow">
                                <h3 class="text-xl font-bold text-gray-800 mb-2"><?php echo e($cartItem->product->name); ?></h3>
                                <p class="text-gray-600 mb-4">LKR <?php echo e(number_format($cartItem->product->price, 2)); ?></p>

                                
                                <form 
                                    action="<?php echo e(route('cart.update', $cartItem->id)); ?>" 
                                    method="POST" 
                                    class="flex items-center space-x-4"
                                    x-data="quantityManager(<?php echo e($cartItem->quantity); ?>, <?php echo e($cartItem->product->quantity); ?>)"
                                >
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('PUT'); ?>
                                    <div class="flex items-center border rounded-md">
                                        <button 
                                            type="button" 
                                            @click="decreaseQuantity"
                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100"
                                        >-</button>
                                        <input 
                                            type="number" 
                                            name="quantity" 
                                            x-model="quantity"
                                            min="1" 
                                            max="<?php echo e($cartItem->product->quantity); ?>"
                                            class="w-16 text-center border-none focus:ring-0"
                                        >
                                        <button 
                                            type="button" 
                                            @click="increaseQuantity"
                                            class="px-3 py-1 text-gray-600 hover:bg-gray-100"
                                        >+</button>
                                    </div>
                                    <button 
                                        type="submit" 
                                        class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition"
                                    >
                                        Update
                                    </button>
                                </form>
                            </div>

                            
                            <form 
                                action="<?php echo e(route('cart.remove', ['cartItem' => $cartItem->id])); ?>" 
                                method="POST" 
                                class="ml-4"
                            >
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button 
                                    type="submit" 
                                    class="text-red-500 hover:text-red-700 transition flex items-center"
                                    onclick="return confirm('Are you sure you want to remove this item from your cart?');"
                                >
                                    <i class="fas fa-trash mr-2"></i>
                                    Remove
                                </button>
                            </form>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

                
                <div>
                    <div class="bg-white shadow-md rounded-lg p-6 sticky top-24">
                        <h3 class="text-2xl font-bold text-gray-800 mb-6">Order Summary</h3>
                        
                        <div class="space-y-4 mb-6">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Subtotal</span>
                                <span class="font-semibold">LKR <?php echo e(number_format($total, 2)); ?></span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Tax (10%)</span>
                                <span class="font-semibold">LKR <?php echo e(number_format($total * 0.1, 2)); ?></span>
                            </div>
                            <hr class="border-gray-200">
                            <div class="flex justify-between text-xl font-bold">
                                <span>Total</span>
                                <span>LKR <?php echo e(number_format($total * 1.1, 2)); ?></span>
                            </div>
                        </div>

                        <form action="<?php echo e(route('checkout.session')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <button 
                                type="submit" 
                                class="w-full bg-green-500 text-white py-3 rounded-md hover:bg-green-600 transition"
                            >
                                Proceed to Checkout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endif; ?>
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
</div>

<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function quantityManager(initialQuantity, maxQuantity) {
        return {
            quantity: initialQuantity,
            maxQuantity: maxQuantity,
            
            increaseQuantity() {
                if (this.quantity < this.maxQuantity) {
                    this.quantity++;
                }
            },
            
            decreaseQuantity() {
                if (this.quantity > 1) {
                    this.quantity--;
                }
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/cart/index.blade.php ENDPATH**/ ?>