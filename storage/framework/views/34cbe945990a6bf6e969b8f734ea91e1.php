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
                <?php echo e(__('Our Services')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>
    <div class="py-8 bg-gradient-to-br from-indigo-50 via-purple-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div class="mb-8 mt-8 bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-6">
                    <form action="<?php echo e(route('services.index')); ?>" method="GET" class="space-y-6">
                        <!-- Search Bar -->
                        <div class="relative group">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" 
                                   id="search"
                                   name="search"
                                   value="<?php echo e($filters['search'] ?? ''); ?>"
                                   placeholder="Search by service name, trainer, or description..." 
                                   class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-md"
                                   aria-label="Search by service name, trainer, or description">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-indigo-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Filters Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Specialization Filter -->
                            <div class="space-y-2">
                                <label for="specialization" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Specialization
                                </label>
                                <select id="specialization" name="specialization" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                        aria-label="Select specialization">
                                    <option value="all">All Specializations</option>
                                    <option value="weight-training">Weight Training</option>
                                    <option value="cardio">Cardio</option>
                                    <option value="yoga">Yoga</option>
                                    <option value="hiit">HIIT</option>
                                    <option value="nutrition">Nutrition</option>
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="space-y-2">
                                <label for="price_range" class="block text-sm font-medium text-gray-700">Price Range</label>
                                <select id="price_range" name="price_range" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                        aria-label="Select price range">
                                    <option value="">Any Price</option>
                                    <option value="0-1000" <?php echo e(($filters['price_range'] ?? '') == '0-1000' ? 'selected' : ''); ?>>Under LKR 1,000</option>
                                    <option value="1000-2000" <?php echo e(($filters['price_range'] ?? '') == '1000-2000' ? 'selected' : ''); ?>>LKR 1,000 - 2,000</option>
                                    <option value="2000+" <?php echo e(($filters['price_range'] ?? '') == '2000+' ? 'selected' : ''); ?>>Above LKR 2,000</option>
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div class="space-y-2">
                                <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                                <select id="sort" name="sort" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                        aria-label="Sort by">
                                    <option value="latest">Latest</option>
                                    <option value="price_low">Price: Low to High</option>
                                    <option value="price_high">Price: High to Low</option>
                                </select>
                            </div>
                        </div>

                        <!-- Location Filter -->
                        <div class="space-y-2">
                            <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                            <select id="location" name="location" 
                                    class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                    aria-label="Select location">
                                <option value="all">All Locations</option>
                                <option value="Colombo" <?php echo e(($filters['location'] ?? '') == 'Colombo' ? 'selected' : ''); ?>>Colombo</option>
                                <option value="Kandy" <?php echo e(($filters['location'] ?? '') == 'Kandy' ? 'selected' : ''); ?>>Kandy</option>
                                <option value="Galle" <?php echo e(($filters['location'] ?? '') == 'Galle' ? 'selected' : ''); ?>>Galle</option>
                                <option value="Jaffna" <?php echo e(($filters['location'] ?? '') == 'Jaffna' ? 'selected' : ''); ?>>Jaffna</option>
                                <option value="Negombo" <?php echo e(($filters['location'] ?? '') == 'Negombo' ? 'selected' : ''); ?>>Negombo</option>
                                <option value="Batticaloa" <?php echo e(($filters['location'] ?? '') == 'Batticaloa' ? 'selected' : ''); ?>>Batticaloa</option>
                                <option value="Trincomalee" <?php echo e(($filters['location'] ?? '') == 'Trincomalee' ? 'selected' : ''); ?>>Trincomalee</option>
                                <option value="Anuradhapura" <?php echo e(($filters['location'] ?? '') == 'Anuradhapura' ? 'selected' : ''); ?>>Anuradhapura</option>
                                <option value="Matara" <?php echo e(($filters['location'] ?? '') == 'Matara' ? 'selected' : ''); ?>>Matara</option>
                                <option value="Kurunegala" <?php echo e(($filters['location'] ?? '') == 'Kurunegala' ? 'selected' : ''); ?>>Kurunegala</option>
                            </select>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="<?php echo e(route('services.index')); ?>" 
                               class="text-sm text-black hover:text-indigo-600 transition duration-300 focus:outline-none focus:underline"
                               aria-label="Clear all filters">
                                Clear all filters
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 rounded-xl bg-gray-200 text-black hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-300">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-gray-100 group" tabindex="0">
                        <!-- Service Image -->
                        <div class="relative h-64 bg-gradient-to-br from-indigo-600 to-purple-700 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            <?php if($service->image): ?>
                                <img src="<?php echo e(asset('storage/' . $service->image)); ?>" 
                                     alt="<?php echo e($service->service_name); ?>"
                                     class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity duration-300"
                                     loading="lazy">
                            <?php else: ?>
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            <?php endif; ?>
                            <!-- Fitness Category Badge -->
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-indigo-600" aria-hidden="true">
                                <?php echo e($service->category ?? 'Fitness'); ?>

                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Service Info -->
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition duration-300 focus:outline-none focus:text-indigo-600" tabindex="0"><?php echo e($service->service_name); ?></h3>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-3" aria-label="Service description"><?php echo e($service->description); ?></p>
                                
                                <!-- Service Highlights -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    <?php if($service->duration): ?>
                                        <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium" aria-label="Duration: <?php echo e($service->duration); ?> mins"><?php echo e($service->duration); ?> mins</span>
                                    <?php endif; ?>
                                    <?php if($service->difficulty): ?>
                                        <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-medium" aria-label="Difficulty: <?php echo e($service->difficulty); ?>"><?php echo e($service->difficulty); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if($service->trainer && $service->trainer->user): ?>
                                    <a href="<?php echo e(route('trainers.profile', $service->trainer)); ?>" 
                                       class="text-sm text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center group focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 rounded-md"
                                       aria-label="View <?php echo e($service->trainer->user->name); ?>'s profile">
                                        <svg class="w-4 h-4 mr-2 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <?php echo e($service->trainer->user->name); ?>

                                    </a>
                                <?php endif; ?>
                            </div>

                            <!-- Service Details -->
                            <div class="space-y-4 mb-6">
                                <?php if($service->trainer): ?>
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center text-sm text-gray-600">
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition duration-300" aria-label="Specialization: <?php echo e($service->trainer->specialization); ?>">
                                                <?php echo e($service->trainer->specialization); ?>

                                            </span>
                                        </div>
                                        <!-- Location -->
                                        <div class="flex items-center text-sm text-gray-600" aria-label="Location: <?php echo e($service->location); ?>">
                                            <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            </svg>
                                            <span class="truncate"><?php echo e($service->location); ?></span>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Book Now Button -->
                            <a href="<?php echo e(route('bookings.create', ['service_id' => $service->id])); ?>" 
                               class="inline-flex items-center px-4 py-2 bg-white border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                               aria-label="Book <?php echo e($service->service_name); ?> service now">
                                Book Now
                            </a>
                        </div>
                    </div> 
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>

            <!-- Pagination -->
            <div class="mt-8"> 
                <?php echo e($services->links()); ?>

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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/services/index.blade.php ENDPATH**/ ?>