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
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            
            <div class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-lg shadow-lg mb-10 p-8">
                <div class="max-w-3xl mx-auto text-center">
                    <h1 class="text-4xl font-extrabold mb-4">My Orders</h1>
                    <p class="text-xl text-indigo-100">Track and manage your recent purchases</p>
                </div>
            </div>

            
            <div class="space-y-8">
                <?php if($orders->isEmpty()): ?>
                    <div class="bg-white rounded-lg shadow-md p-10 text-center">
                        <i class="fas fa-shopping-bag text-6xl text-gray-300 mb-6"></i>
                        <h2 class="text-2xl font-semibold text-gray-600 mb-4">No Orders Yet</h2>
                        <p class="text-gray-500 mb-6">Looks like you haven't made any purchases.</p>
                        <a href="<?php echo e(route('products.index')); ?>" class="inline-block bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 transition">
                            Start Shopping
                        </a>
                    </div>
                <?php else: ?>
                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            
                            <div class="bg-gray-100 px-6 py-4 flex justify-between items-center border-b">
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Order #<?php echo e($order->id); ?></h3>
                                    <p class="text-sm text-gray-500">
                                        Placed on <?php echo e($order->created_at->format('F d, Y')); ?>

                                    </p>
                                </div>
                                <span class="px-3 py-1 rounded-full text-sm font-semibold 
                                    <?php if($order->status == 'pending'): ?> bg-yellow-100 text-yellow-800
                                    <?php elseif($order->status == 'completed'): ?> bg-green-100 text-green-800
                                    <?php elseif($order->status == 'cancelled'): ?> bg-red-100 text-red-800
                                    <?php else: ?> bg-gray-100 text-gray-800
                                    <?php endif; ?>">
                                    <?php echo e(ucfirst($order->status)); ?>

                                </span>
                            </div>

                            
                            <div class="p-6">
                                <div class="grid md:grid-cols-2 gap-6">
                                    
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-700">Order Items</h4>
                                        <div class="space-y-4">
                                            <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="flex items-center space-x-4 bg-gray-50 p-4 rounded-lg">
                                                    <div class="flex-shrink-0">
                                                        <?php if($item->product->image): ?>
                                                            <img 
                                                                src="<?php echo e(asset('storage/'.$item->product->image)); ?>" 
                                                                alt="<?php echo e($item->product->name); ?>" 
                                                                class="w-20 h-20 object-cover rounded-md"
                                                            >
                                                        <?php else: ?>
                                                            <div class="w-20 h-20 bg-gray-200 rounded-md flex items-center justify-center">
                                                                <i class="fas fa-image text-gray-400"></i>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="flex-1">
                                                        <h5 class="font-semibold text-gray-800"><?php echo e($item->product->name); ?></h5>
                                                        <p class="text-sm text-gray-600">
                                                            Quantity: <?php echo e($item->quantity); ?> 
                                                            | Price: LKR <?php echo e(number_format($item->price, 2)); ?>

                                                        </p>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                    </div>

                                    
                                    <div>
                                        <h4 class="text-lg font-semibold mb-4 text-gray-700">Order Summary</h4>
                                        <div class="bg-gray-50 p-6 rounded-lg space-y-3">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Subtotal</span>
                                                <span class="font-semibold">LKR <?php echo e(number_format($order->subtotal, 2)); ?></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Tax</span>
                                                <span class="font-semibold">LKR <?php echo e(number_format($order->tax, 2)); ?></span>
                                            </div>
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Shipping</span>
                                                <span class="font-semibold">LKR <?php echo e(number_format($order->shipping, 2)); ?></span>
                                            </div>
                                            <hr class="border-gray-200">
                                            <div class="flex justify-between text-xl font-bold text-gray-800">
                                                <span>Total</span>
                                                <span>LKR <?php echo e(number_format($order->total_amount, 2)); ?></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    
                    <div class="mt-8">
                        <?php echo e($orders->links()); ?>

                    </div>
                <?php endif; ?>
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
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/orders/index.blade.php ENDPATH**/ ?>