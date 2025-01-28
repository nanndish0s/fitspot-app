<?php $__env->startSection('content'); ?>
<div class="container mx-auto px-4 py-8">
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h2 class="text-2xl font-bold text-gray-800">My Sales Orders</h2>
            <a href="<?php echo e(route('seller.dashboard')); ?>" class="text-green-600 hover:text-green-800 transition">
                Back to Dashboard
            </a>
        </div>

        <?php if($sellerOrders->isEmpty()): ?>
            <div class="p-6 text-center text-gray-600">
                <p class="text-xl">You haven't received any orders yet.</p>
                <p class="mt-2 text-sm">As you add more products, your sales will appear here.</p>
            </div>
        <?php else: ?>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-100 text-gray-600 uppercase text-sm leading-normal">
                            <th class="py-3 px-6 text-left">Order ID</th>
                            <th class="py-3 px-6 text-left">Date</th>
                            <th class="py-3 px-6 text-left">Total Items</th>
                            <th class="py-3 px-6 text-left">Total Revenue</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-600 text-sm font-light">
                        <?php $__currentLoopData = $sellerOrders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-3 px-6 text-left whitespace-nowrap">
                                    <div class="flex items-center">
                                        <span class="font-medium">#<?php echo e($order->id); ?></span>
                                    </div>
                                </td>
                                <td class="py-3 px-6 text-left">
                                    <?php echo e($order->created_at->format('M d, Y')); ?>

                                </td>
                                <td class="py-3 px-6 text-left">
                                    <?php echo e($order->orderItems->count()); ?> Items
                                </td>
                                <td class="py-3 px-6 text-left">
                                    $<?php echo e(number_format($order->orderItems->sum(function($item) {
                                        return $item->quantity * $item->price;
                                    }), 2)); ?>

                                </td>
                                <td class="py-3 px-6 text-center">
                                    <span class="
                                        px-3 py-1 rounded-full text-xs font-bold
                                        <?php echo e($order->status === 'completed' ? 'bg-green-200 text-green-800' : 
                                           ($order->status === 'pending' ? 'bg-yellow-200 text-yellow-800' : 
                                           'bg-red-200 text-red-800')); ?>

                                    ">
                                        <?php echo e(ucfirst($order->status)); ?>

                                    </span>
                                </td>
                                <td class="py-3 px-6 text-center">
                                    <a href="<?php echo e(route('orders.show', $order)); ?>" 
                                       class="text-blue-600 hover:text-blue-900 transition">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <div class="p-4">
                <?php echo e($sellerOrders->links()); ?>

            </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/orders/seller_index.blade.php ENDPATH**/ ?>