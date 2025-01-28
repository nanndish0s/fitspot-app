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
    <!-- Page Title Section -->
    <section class="bg-gray-800 text-white text-center py-20">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold">My Orders</h2>
            <p class="mt-4 text-xl">View your order history</p>
        </div>
    </section>

    <!-- Orders Section -->
    <section class="container mx-auto py-20 px-4 flex-grow">
        <?php if($orders->isEmpty()): ?>
            <p class="text-center text-xl">You have no orders yet.</p>
        <?php else: ?>
            <div class="space-y-6">
                <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white shadow-md rounded-lg p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-2xl font-semibold">Order #<?php echo e($order->id); ?></h3>
                            <span class="text-sm px-3 py-1 rounded 
                                <?php if($order->status == 'pending'): ?> bg-yellow-200 text-yellow-800
                                <?php elseif($order->status == 'completed'): ?> bg-green-200 text-green-800
                                <?php else: ?> bg-red-200 text-red-800
                                <?php endif; ?>">
                                <?php echo e(ucfirst($order->status)); ?>

                            </span>
                        </div>
                        
                        <div class="mb-4">
                            <p class="text-gray-600">Ordered on: <?php echo e($order->created_at->format('F d, Y')); ?></p>
                            <p class="text-xl font-bold">Total: LKR <?php echo e(number_format($order->total_amount, 2)); ?></p>
                        </div>

                        <div class="border-t pt-4">
                            <h4 class="text-lg font-semibold mb-2">Order Items</h4>
                            <div class="space-y-2">
                                <?php $__currentLoopData = $order->orderItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="flex justify-between items-center">
                                        <div class="flex items-center">
                                            <?php if($item->product->image): ?>
                                                <img src="<?php echo e(asset('storage/'.$item->product->image)); ?>" alt="<?php echo e($item->product->name); ?>" class="w-16 h-16 object-cover rounded-md mr-4">
                                            <?php else: ?>
                                                <img src="https://via.placeholder.com/150" alt="<?php echo e($item->product->name); ?>" class="w-16 h-16 object-cover rounded-md mr-4">
                                            <?php endif; ?>
                                            <div>
                                                <p class="font-semibold"><?php echo e($item->product->name); ?></p>
                                                <p class="text-gray-600">Quantity: <?php echo e($item->quantity); ?></p>
                                            </div>
                                        </div>
                                        <p class="font-bold">LKR <?php echo e(number_format($item->price, 2)); ?></p>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php endif; ?>
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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/orders/index.blade.php ENDPATH**/ ?>