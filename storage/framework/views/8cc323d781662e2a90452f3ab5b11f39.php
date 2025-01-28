<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'FitSpot')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
        
        <!-- Additional Styles -->
        <?php echo $__env->yieldPushContent('styles'); ?>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <div class="min-h-screen bg-gray-100">
            <!-- Page Heading -->
            <?php if(isset($header)): ?>
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        <?php echo e($header); ?>

                    </div>
                </header>
            <?php endif; ?>

            <!-- Page Content -->
            <main>
                <?php echo e($slot); ?>

            </main>
                        <!-- Footer -->
                        <footer class="bg-green-500 mt-8 py-6">
                            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                                <div class="flex flex-col md:flex-row justify-between items-center text-black">  <!-- Added text-black here -->
                                    <div class="text-center md:text-left mb-4 md:mb-0">
                                        <p class="text-lg font-medium">© <?php echo e(date('Y')); ?> FitSpot. All rights reserved.</p>
                                    </div>
                                    <div class="text-center md:text-right">
                                        <a href="#" class="text-black hover:text-gray-300 mx-2">Privacy Policy</a>
                                        <a href="#" class="text-black hover:text-gray-300 mx-2">Terms of Service</a>
                                        <a href="#" class="text-black hover:text-gray-300 mx-2">Contact Us</a>
                                    </div>
                                </div>
                            </div>
                        </footer>
        </div>

        <!-- Additional Scripts -->
        <?php echo $__env->yieldPushContent('scripts'); ?>
    </body>
</html>
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/layouts/no-nav-services.blade.php ENDPATH**/ ?>