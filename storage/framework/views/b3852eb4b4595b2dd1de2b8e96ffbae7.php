<?php $__env->startPush('styles'); ?>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<?php $__env->stopPush(); ?>

<?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php if (isset($component)) { $__componentOriginala929ede201b7612faf05084a170269ae = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala929ede201b7612faf05084a170269ae = $attributes; } ?>
<?php $component = App\View\Components\ServicesLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('services-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\ServicesLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                <?php echo e(__('Manage Bookings')); ?>

            </h2>
            <a href="<?php echo e(route('trainer.dashboard')); ?>" class="text-indigo-600 hover:text-indigo-900">Back to Dashboard</a>
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
                    <?php else: ?>
                        <!-- Pending Bookings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Bookings</h3>
                            <?php if(isset($bookings['pending']) && $bookings['pending']->count() > 0): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php $__currentLoopData = $bookings['pending']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200 bg-yellow-50">
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    <?php echo e($booking->service->service_name); ?>

                                                </h4>
                                                <p class="text-sm text-gray-600">Client: <?php echo e($booking->user->name); ?></p>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Date:</span>
                                                    <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('M j, Y')); ?></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Time:</span>
                                                    <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('g:i A')); ?></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Service Price:</span>
                                                    <span class="text-gray-900">LKR <?php echo e($booking->service->price); ?></span>
                                                </div>
                                                <?php if($booking->notes): ?>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600">Notes: <?php echo e($booking->notes); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>

                                            <div class="mt-4 flex justify-between items-center space-x-2">
                                                <form action="<?php echo e(route('trainer.bookings.accept', $booking)); ?>" method="POST" class="flex-1">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" 
                                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Accept
                                                    </button>
                                                </form>
                                                <form action="<?php echo e(route('trainer.bookings.decline', $booking)); ?>" method="POST" class="flex-1">
                                                    <?php echo csrf_field(); ?>
                                                    <button type="submit" 
                                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Decline
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500">No pending bookings.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Confirmed Bookings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirmed Bookings</h3>
                            <?php if(isset($bookings['confirmed']) && $bookings['confirmed']->count() > 0): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php $__currentLoopData = $bookings['confirmed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200 bg-green-50">
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    <?php echo e($booking->service->service_name); ?>

                                                </h4>
                                                <p class="text-sm text-gray-600">Client: <?php echo e($booking->user->name); ?></p>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Date:</span>
                                                    <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('M j, Y')); ?></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Time:</span>
                                                    <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('g:i A')); ?></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Service Price:</span>
                                                    <span class="text-gray-900">LKR <?php echo e($booking->service->price); ?></span>
                                                </div>
                                                <?php if($booking->notes): ?>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600">Notes: <?php echo e($booking->notes); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500">No confirmed bookings.</p>
                            <?php endif; ?>
                        </div>

                        <!-- Cancelled Bookings -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Cancelled Bookings</h3>
                                <?php if(isset($bookings['cancelled']) && $bookings['cancelled']->count() > 0): ?>
                                    <form action="<?php echo e(route('trainer.bookings.clear-cancelled')); ?>" method="POST" class="inline">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                onclick="return confirm('Are you sure you want to clear all cancelled bookings? This action cannot be undone.')">
                                            Clear Cancelled Bookings
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </div>
                            <?php if(isset($bookings['cancelled']) && $bookings['cancelled']->count() > 0): ?>
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    <?php $__currentLoopData = $bookings['cancelled']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200 bg-red-50">
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    <?php echo e($booking->service->service_name); ?>

                                                </h4>
                                                <p class="text-sm text-gray-600">Client: <?php echo e($booking->user->name); ?></p>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Date:</span>
                                                    <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('M j, Y')); ?></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Time:</span>
                                                    <span class="text-gray-900"><?php echo e(Carbon\Carbon::parse($booking->session_date)->format('g:i A')); ?></span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Service Price:</span>
                                                    <span class="text-gray-900">LKR <?php echo e($booking->service->price); ?></span>
                                                </div>
                                                <?php if($booking->notes): ?>
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600">Notes: <?php echo e($booking->notes); ?></p>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php else: ?>
                                <p class="text-gray-500">No cancelled bookings.</p>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala929ede201b7612faf05084a170269ae)): ?>
<?php $attributes = $__attributesOriginala929ede201b7612faf05084a170269ae; ?>
<?php unset($__attributesOriginala929ede201b7612faf05084a170269ae); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala929ede201b7612faf05084a170269ae)): ?>
<?php $component = $__componentOriginala929ede201b7612faf05084a170269ae; ?>
<?php unset($__componentOriginala929ede201b7612faf05084a170269ae); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/bookings/trainer-index.blade.php ENDPATH**/ ?>