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
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                <?php echo e(__('My Bookings')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <?php if(session('success')): ?>
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('success')); ?></span>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline"><?php echo e(session('error')); ?></span>
                </div>
            <?php endif; ?>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <?php if($bookings->isEmpty()): ?>
                        <p class="text-gray-500 text-center py-4">You don't have any bookings yet.</p>
                        <div class="text-center">
                            <a href="<?php echo e(route('services.index')); ?>" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Browse Services
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <?php echo e($booking->service->service_name); ?>

                                        </h3>
                                        <p class="text-sm text-gray-600">with <?php echo e($booking->trainer->user->name); ?></p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Service:</span>
                                            <span class="text-gray-900"><?php echo e($booking->service->service_name); ?> (LKR <?php echo e($booking->service->price); ?>)</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Date:</span>
                                            <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('M j, Y')); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Time:</span>
                                            <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('g:i A')); ?></span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status:</span>
                                            <span class="
                                                <?php if($booking->status === 'confirmed'): ?> text-green-600
                                                <?php elseif($booking->status === 'cancelled'): ?> text-red-600
                                                <?php else: ?> text-yellow-600
                                                <?php endif; ?> font-medium">
                                                <?php echo e(ucfirst($booking->status)); ?>

                                            </span>
                                        </div>
                                        <?php if($booking->notes): ?>
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600">Notes: <?php echo e($booking->notes); ?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <div class="mt-4 flex justify-between items-center">
                                        <a href="<?php echo e(route('bookings.show', $booking)); ?>" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View Details
                                        </a>
                                        <?php if($booking->status !== 'cancelled'): ?>
                                            <form action="<?php echo e(route('bookings.cancel', $booking)); ?>" method="POST" class="inline">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 text-sm font-medium"
                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>
                </div>
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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/bookings/index.blade.php ENDPATH**/ ?>