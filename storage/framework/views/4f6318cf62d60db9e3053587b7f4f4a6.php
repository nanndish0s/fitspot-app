<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8" x-data="productManagement()">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        
        <div class="bg-gradient-to-r from-green-500 to-green-700 px-6 py-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-4xl font-extrabold tracking-tight">Manage Products</h1>
                    <p class="mt-2 text-xl opacity-80">View, edit, and manage your product listings</p>
                </div>
                <div>
                    <a href="<?php echo e(route('products.create')); ?>" class="inline-flex items-center px-4 py-2 border border-white text-white rounded-md hover:bg-white hover:text-green-600 transition">
                        <i class="fas fa-plus-circle mr-2"></i>
                        Add New Product
                    </a>
                    <a href="<?php echo e(route('seller.dashboard')); ?>" class="ml-2 inline-flex items-center px-4 py-2 border border-white text-white rounded-md hover:bg-white hover:text-green-600 transition">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Dashboard
                    </a>
                </div>
            </div>
        </div>

        
        <?php if(session('success')): ?>
            <div class="bg-green-50 border-l-4 border-green-400 p-4 mb-4">
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
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
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

        
        <?php if($products->isEmpty()): ?>
            <div class="p-8 text-center">
                <i class="fas fa-box-open text-6xl text-gray-300 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-600 mb-2">No Products Yet</h2>
                <p class="text-gray-500">Start by adding your first product to the store.</p>
                <a href="<?php echo e(route('products.create')); ?>" class="mt-4 inline-block bg-green-500 text-white px-6 py-3 rounded-md hover:bg-green-600 transition">
                    Add First Product
                </a>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Image</th>
                            <th class="py-3 px-6 text-left">Name</th>
                            <th class="py-3 px-6 text-left">Price</th>
                            <th class="py-3 px-6 text-left">Quantity</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-3 px-6">
                                    <img 
                                        src="<?php echo e($product->image ? Storage::url($product->image) : asset('images/default-product.png')); ?>" 
                                        alt="<?php echo e($product->name); ?>" 
                                        onerror="this.onerror=null; this.src='<?php echo e(asset('images/default-product.png')); ?>'"
                                        class="w-16 h-16 object-cover rounded"
                                    >
                                </td>
                                <td class="py-3 px-6 font-medium"><?php echo e($product->name); ?></td>
                                <td class="py-3 px-6">$<?php echo e(number_format($product->price, 2)); ?></td>
                                <td class="py-3 px-6"><?php echo e($product->quantity); ?></td>
                                <td class="py-3 px-6 text-center">
                                    <span class="
                                        px-3 py-1 rounded-full text-xs font-bold
                                        <?php echo e($product->quantity > 0 ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800'); ?>

                                    ">
                                        <?php echo e($product->quantity > 0 ? 'In Stock' : 'Out of Stock'); ?>

                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <div class="flex justify-center space-x-2">
                                        <a href="<?php echo e(route('products.edit', $product)); ?>" 
                                           class="inline-flex items-center px-2 py-1 bg-blue-50 text-blue-600 hover:bg-blue-100 rounded-md transition"
                                           title="Edit Product"
                                        >
                                            <i class="fas fa-edit mr-1 text-lg"></i>
                                            Edit
                                        </a>
                                        <form 
                                            action="<?php echo e(route('products.destroy', $product)); ?>" 
                                            method="POST" 
                                            x-data="{ 
                                                confirmDelete(event) {
                                                    console.log('Delete confirmation triggered');
                                                    if (!confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                                                        event.preventDefault();
                                                        console.log('Delete cancelled');
                                                    } else {
                                                        console.log('Delete confirmed');
                                                    }
                                                }
                                            }"
                                            @submit.prevent="confirmDelete($event)"
                                        >
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button 
                                                type="submit" 
                                                class="inline-flex items-center px-2 py-1 bg-red-50 text-red-600 hover:bg-red-100 rounded-md transition"
                                                title="Delete Product"
                                            >
                                                <i class="fas fa-trash mr-1 text-lg"></i>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            
            <div class="p-4">
                <?php echo e($products->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    function productManagement() {
        return {
            init() {
                console.log('Product Management Alpine component initialized');
            }
        }
    }
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/products/seller_index.blade.php ENDPATH**/ ?>