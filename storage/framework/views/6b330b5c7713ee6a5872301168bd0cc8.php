<!-- Navbar Styles -->
<style>
    body { font-family: 'Roboto', sans-serif; }
    .bg-hero-image {
        background-image: url('storage/hero/hero-image.png'); /* REPLACE with your hero image URL */
    }
    .nav-link {
        @apply text-white px-4 py-2 rounded hover:bg-green-600;
        transition: background-color 0.3s ease; /* Smooth transition for hover */
    }
    .feature-icon {
        @apply text-5xl text-green-500 mb-4;
    }
</style>

<!-- Header -->
<header class="bg-green-500 text-white p-4 shadow-md fixed w-full z-10">
    <div class="container mx-auto flex justify-between items-center">
        <div class="flex items-center">
            <h1 class="text-3xl font-bold mr-4">FitSpot</h1>
        </div>
        <nav id="nav-menu" class="hidden md:flex space-x-8">  <!-- Increased spacing -->
            <a href="/" class="nav-link">Home</a>
            <a href="/products" class="nav-link">Shop</a>
            <a href="/cart" class="nav-link">Cart</a>
            <a href="/orders" class="nav-link">Orders</a>
            <?php if(auth()->guard()->check()): ?>
                <?php if(auth()->user()->role === 'user'): ?>
                    <a href="<?php echo e(route('services.index')); ?>" class="nav-link">Services</a>
                <?php endif; ?>
                <?php if(auth()->user()->role === 'trainer'): ?>
                    <a href="<?php echo e(route('trainer.dashboard')); ?>" class="nav-link">Dashboard</a>
                <?php endif; ?>
                <?php if(auth()->user()->role === 'seller'): ?>
                    <a href="/seller/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Seller Dashboard</a>
                <?php endif; ?>
                <form action="<?php echo e(route('logout')); ?>" method="POST" class="inline">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="text-white px-4 py-2 bg-red-500 rounded hover:bg-red-600">Logout</button>
                </form>
            <?php else: ?>
                <a href="/login" class="nav-link">Login</a>
                <a href="/register" class="bg-white text-green-600 px-4 py-2 rounded hover:bg-gray-100">Register</a>
            <?php endif; ?>
        </nav>
        <button id="hamburger" class="md:hidden p-2 rounded focus:outline-none focus:ring-2 focus:ring-white">
            <svg class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>
</header>

<!-- Add padding to body to prevent content from being hidden behind fixed navbar -->
<script>
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobile-menu');

    hamburger.addEventListener('click', () => {
        mobileMenu.classList.toggle('hidden');
    });
</script><?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/partials/navbar.blade.php ENDPATH**/ ?>