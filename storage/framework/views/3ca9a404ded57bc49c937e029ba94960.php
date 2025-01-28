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
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <?php echo e(__('Booking Details')); ?>

        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Status Banner -->
                    <div class="mb-6 p-4 rounded-lg <?php echo e($booking->status === 'confirmed' ? 'bg-green-100' : ($booking->status === 'cancelled' ? 'bg-red-100' : 'bg-yellow-100')); ?>">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <?php if($booking->status === 'confirmed'): ?>
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                <?php elseif($booking->status === 'cancelled'): ?>
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                <?php else: ?>
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium <?php echo e($booking->status === 'confirmed' ? 'text-green-800' : ($booking->status === 'cancelled' ? 'text-red-800' : 'text-yellow-800')); ?>">
                                    Status: <?php echo e(ucfirst($booking->status)); ?>

                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Service Information -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Service Details</h3>
                                <p class="mt-1 text-gray-600"><?php echo e($booking->service->service_name); ?></p>
                                <p class="mt-1 text-gray-600"><?php echo e($booking->service->description); ?></p>
                                <p class="mt-2 font-medium">Price: <span class="text-indigo-600">$<?php echo e(number_format($booking->service->price, 2)); ?></span></p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Trainer</h3>
                                <p class="mt-1 text-gray-600"><?php echo e($booking->trainer->user->name); ?></p>
                                <p class="mt-1 text-sm text-gray-600"><?php echo e($booking->trainer->specialization); ?></p>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Session Details</h3>
                                <p class="mt-1 text-gray-600">
                                    Date: <?php echo e(Carbon\Carbon::parse($booking->session_date)->format('l, F j, Y')); ?>

                                </p>
                                <p class="mt-1 text-gray-600">
                                    Time: <?php echo e(Carbon\Carbon::parse($booking->session_date)->format('g:i A')); ?>

                                </p>
                            </div>

                            <?php if($booking->notes): ?>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Notes</h3>
                                    <p class="mt-1 text-gray-600"><?php echo e($booking->notes); ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end">
                        <?php if($booking->status === 'pending' || $booking->status === 'confirmed'): ?>
                            <form method="POST" action="<?php echo e(route('bookings.cancel', $booking)); ?>">
                                <?php echo csrf_field(); ?>
                                <?php if (isset($component)) { $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.danger-button','data' => ['type' => 'submit','onclick' => 'return confirm(\'Are you sure you want to cancel this booking?\')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('danger-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','onclick' => 'return confirm(\'Are you sure you want to cancel this booking?\')']); ?>
                                    <?php echo e(__('Cancel Booking')); ?>

                                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $attributes = $__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__attributesOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11)): ?>
<?php $component = $__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11; ?>
<?php unset($__componentOriginal656e8c5ea4d9a4fa173298297bfe3f11); ?>
<?php endif; ?>
                            </form>
                        <?php endif; ?>
                    </div>
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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/bookings/show.blade.php ENDPATH**/ ?>