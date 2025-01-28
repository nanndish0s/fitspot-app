<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <!-- Dashboard Header -->
    <div class="bg-green-500 text-white p-8 rounded-t-lg shadow-xl">
        <h2 class="text-4xl font-bold">My Products</h2>
        <p class="mt-2 text-xl">Manage and view your products easily from this dashboard</p>
    </div>

    <!-- Dashboard Content -->
    <div class="container mx-auto py-8 px-4">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            <!-- Sidebar (Navigation) -->
            <div class="bg-white shadow-lg p-6 rounded-lg space-y-4">
                <h3 class="text-2xl font-semibold text-gray-700">Seller Dashboard</h3>
                <ul class="space-y-3">
                    <li><a href="<?php echo e(route('seller.dashboard')); ?>" class="text-green-600 hover:text-green-800 font-medium text-lg">Dashboard</a></li>
                    <li><a href="<?php echo e(route('products.create')); ?>" class="text-green-600 hover:text-green-800 font-medium text-lg">Add Product</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-green-600 hover:text-green-800 font-medium text-lg">Manage Products</a></li>
                </ul>
            </div>

            <!-- Main Content: List of Products -->
            <div class="lg:col-span-3">
                <?php if($products->isEmpty()): ?>
                    <div class="bg-white p-8 rounded-lg shadow-xl">
                        <p class="text-center text-2xl text-gray-700">You have not listed any products yet.</p>
                        <a href="<?php echo e(route('products.create')); ?>" class="mt-4 block text-center bg-green-600 text-white py-3 px-6 rounded-full hover:bg-green-700 transition-all">Add New Product</a>
                    </div>
                <?php else: ?>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="bg-white p-6 rounded-lg shadow-lg transform hover:scale-105 transition-all">
                                <!-- Product Image -->
                                <img src="<?php echo e(asset('storage/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-48 object-cover rounded-lg shadow-md">

                                <!-- Product Info -->
                                <div class="mt-6">
                                    <h3 class="text-xl font-semibold text-gray-800"><?php echo e($product->name); ?></h3>
                                    <p class="text-gray-600 mt-2"><?php echo e($product->description); ?></p>
                                    <p class="mt-4 text-lg font-bold text-gray-800">Price: LKR <?php echo e(number_format($product->price, 2)); ?></p>
                                    <p class="text-gray-600 mt-2">Quantity: <?php echo e($product->quantity); ?></p>
                                </div>

                                <!-- Action Buttons -->
                                <div class="mt-6 flex justify-between items-center">
                                    <a href="<?php echo e(route('products.edit', $product->id)); ?>" class="text-green-600 hover:text-green-800 font-medium">Edit</a>
                                    <form action="<?php echo e(route('products.destroy', $product->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-medium">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/seller/dashboard.blade.php ENDPATH**/ ?>