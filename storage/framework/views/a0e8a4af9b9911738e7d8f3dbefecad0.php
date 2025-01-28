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
            <?php echo e($trainer->user->name); ?>'s Profile
        </h2>
     <?php $__env->endSlot(); ?>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Trainer Info Section -->
                    <div class="flex flex-col md:flex-row justify-center text-center">
                        <!-- Profile Picture -->
                        <div class="md:w-1/3 mb-6 md:mb-0 flex justify-center">
                            <?php if($trainer->profile_picture): ?>
                                <img src="<?php echo e(Storage::url($trainer->profile_picture)); ?>" 
                                     alt="<?php echo e($trainer->user->name); ?>" 
                                     class="w-16 h-16 rounded-full shadow-lg object-cover">
                            <?php else: ?>
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Trainer Details -->
                        <div class="md:w-2/3 md:pl-8">
                            <h3 class="text-2xl font-bold text-gray-900"><?php echo e($trainer->user->name); ?></h3>
                            <div class="text-gray-700">
                                <p><span class="font-semibold">Specialization:</span> <?php echo e($trainer->specialization); ?></p>
                                <p><span class="font-semibold">Hourly Rate:</span> LKR <?php echo e(number_format($trainer->hourly_rate, 2)); ?></p>
                                <p><span class="font-semibold">Bio:</span> <?php echo e($trainer->bio); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div class="mt-12">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Available Services</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <?php $__currentLoopData = $trainer->services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900"><?php echo e($service->service_name); ?></div>
                                            <p class="mt-2 text-gray-600"><?php echo e($service->description); ?></p>
                                        </div>
                                        <div class="text-lg font-bold text-indigo-600">
                                            LKR <?php echo e(number_format($service->price, 2)); ?>

                                        </div>
                                    </div>
                                    <?php if(auth()->guard()->check()): ?>
                                        <div class="mt-4 text-right">
                                            <a href="<?php echo e(route('bookings.create', ['service_id' => $service->id])); ?>" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Book This Service
                                            </a>
                                        </div>
                                    <?php else: ?>
                                        <div class="mt-4 text-right">
                                            <a href="<?php echo e(route('login')); ?>" 
                                               class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Login to Book
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/trainers/profile.blade.php ENDPATH**/ ?>