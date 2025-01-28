<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - FitSpot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>

    <style>
        body { 
            font-family: 'Inter', sans-serif; 
        }
    </style>
</head>
<body class="bg-gray-50 antialiased">
    <?php echo $__env->make('components.navbar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Hero Section -->
    <section class="relative bg-cover bg-center bg-no-repeat" style="background-image: url('<?php echo e(asset('storage/hero/hero-image.png')); ?>')">
        <div class="absolute inset-0 bg-black/60"></div>
        <div class="relative container mx-auto px-4 py-24 lg:py-36">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <div class="text-center lg:text-left text-white">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold mb-6 tracking-tight">
                        Transform Your Fitness Journey
                    </h1>
                    <p class="text-xl text-gray-200 mb-8 max-w-xl mx-auto lg:mx-0">
                        Discover personalized training, top-quality supplements, and expert guidance to achieve your health goals.
                    </p>
                    <div class="flex flex-col sm:flex-row justify-center lg:justify-start gap-4">
                        <a href="<?php echo e(route('services.index')); ?>" class="inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300 group">
                            <i class="fas fa-dumbbell mr-2 group-hover:animate-pulse"></i>
                            Explore Services
                        </a>
                        <a href="<?php echo e(route('products.index')); ?>" class="inline-flex items-center px-6 py-3 border border-white text-white rounded-lg hover:bg-white/10 transition duration-300 group">
                            <i class="fas fa-shopping-bag mr-2 group-hover:animate-pulse"></i>
                            Shop Supplements
                        </a>
                    </div>
                </div>
                <div class="hidden lg:block text-center">
                    <img src="<?php echo e(asset('storage/hero/fitness-hero.png')); ?>" class="mx-auto rounded-full shadow-2xl max-w-sm" />
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container mx-auto px-4 py-16">
        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-green-50 text-green-600 p-4 rounded-full">
                        <i class="fas fa-user-friends text-4xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Expert Trainers</h3>
                <p class="text-gray-600">Connect with certified fitness professionals tailored to your goals.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-indigo-50 text-indigo-600 p-4 rounded-full">
                        <i class="fas fa-heartbeat text-4xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Personalized Plans</h3>
                <p class="text-gray-600">Custom workout and nutrition plans designed specifically for you.</p>
            </div>
            <div class="bg-white p-6 rounded-xl shadow-md hover:shadow-xl transition duration-300 text-center">
                <div class="flex justify-center mb-4">
                    <div class="bg-purple-50 text-purple-600 p-4 rounded-full">
                        <i class="fas fa-medal text-4xl"></i>
                    </div>
                </div>
                <h3 class="text-xl font-bold mb-3 text-gray-800">Quality Supplements</h3>
                <p class="text-gray-600">Premium, scientifically-backed supplements to support your fitness.</p>
            </div>
        </div>
    </section>

    <!-- Latest Products Section -->
    <section class="bg-gray-100 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">Latest Supplements</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <?php $__currentLoopData = $latestProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-xl transition duration-300">
                        <img src="<?php echo e(asset('storage/'.$product->image)); ?>" alt="<?php echo e($product->name); ?>" class="w-full h-56 object-cover">
                        <div class="p-6">
                            <h5 class="text-xl font-bold mb-2 text-gray-800"><?php echo e($product->name); ?></h5>
                            <p class="text-gray-600 mb-4"><?php echo e(Str::limit($product->description, 100)); ?></p>
                            <div class="flex justify-between items-center">
                                <span class="text-2xl font-bold text-green-600">LKR <?php echo e(number_format($product->price, 2)); ?></span>
                                <a href="<?php echo e(route('products.show', $product->id)); ?>" class="inline-flex items-center px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-300">
                                    View Details
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-16">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-3 gap-8">
                <div>
                    <h5 class="text-xl font-bold mb-4">FitSpot</h5>
                    <p class="text-gray-400">Your ultimate destination for fitness and wellness.</p>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Quick Links</h5>
                    <ul class="space-y-2">
                        <li><a href="<?php echo e(route('services.index')); ?>" class="text-gray-400 hover:text-white transition">Services</a></li>
                        <li><a href="<?php echo e(route('products.index')); ?>" class="text-gray-400 hover:text-white transition">Products</a></li>
                    </ul>
                </div>
                <div>
                    <h5 class="text-xl font-bold mb-4">Connect With Us</h5>
                    <div class="flex space-x-4">
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-facebook text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-instagram text-2xl"></i></a>
                        <a href="#" class="text-gray-400 hover:text-white transition"><i class="fab fa-twitter text-2xl"></i></a>
                    </div>
                </div>
            </div>
            <hr class="my-8 border-gray-700">
            <div class="text-center">
                <p class="text-gray-500">&copy; 2024 FitSpot. All Rights Reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/home.blade.php ENDPATH**/ ?>