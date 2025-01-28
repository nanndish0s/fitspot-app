<nav class="navbar navbar-expand-lg navbar-dark bg-success py-3">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="<?php echo e(route('home')); ?>">
            <img src="<?php echo e(asset('storage/logo.png')); ?>" alt="FitSpot Logo" height="50" width="50" class="me-2 rounded-circle">
            <span class="fw-bold">FitSpot</span>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item mx-2">
                    <a class="nav-link <?php echo e(request()->routeIs('home') ? 'active' : ''); ?>" href="<?php echo e(route('home')); ?>">
                        <i class="fas fa-home me-1"></i>Home
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link <?php echo e(request()->routeIs('products.index') ? 'active' : ''); ?>" href="<?php echo e(route('products.index')); ?>">
                        <i class="fas fa-shopping-bag me-1"></i>Shop
                    </a>
                </li>
                <li class="nav-item mx-2">
                    <a class="nav-link <?php echo e(request()->routeIs('services.index') ? 'active' : ''); ?>" href="<?php echo e(route('services.index')); ?>">
                        <i class="fas fa-dumbbell me-1"></i>Services
                    </a>
                </li>
                <?php if(auth()->guard()->check()): ?>
                    <?php if(auth()->user()->role === 'trainer'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link <?php echo e(request()->routeIs('trainer.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('trainer.dashboard')); ?>">
                                <i class="fas fa-chalkboard-teacher me-1"></i>Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if(auth()->user()->role === 'seller'): ?>
                        <li class="nav-item mx-2">
                            <a class="nav-link <?php echo e(request()->routeIs('seller.dashboard') ? 'active' : ''); ?>" href="<?php echo e(route('seller.dashboard')); ?>">
                                <i class="fas fa-store me-1"></i>Seller Dashboard
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item mx-1">
                    <a class="nav-link <?php echo e(request()->routeIs('cart') ? 'active' : ''); ?>" href="<?php echo e(route('cart')); ?>">
                        <i class="fas fa-shopping-cart"></i>
                        Cart
                        <?php echo e(auth()->check() ? auth()->user()->cart()->count() : 0); ?>

                    </a>
                </li>
                <?php if(auth()->guard()->check()): ?>
                    <li class="nav-item dropdown mx-1">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="true" data-cy="profile-dropdown">
                            <i class="fas fa-user me-1"></i><?php echo e(Str::limit(Auth::user()->name, 10)); ?>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <li><a class="dropdown-item" href="<?php echo e(route('profile.edit')); ?>">
                                <i class="fas fa-user-cog me-2"></i>Profile
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('orders.index')); ?>">
                                <i class="fas fa-receipt me-2"></i>My Orders
                            </a></li>
                            <li><a class="dropdown-item" href="<?php echo e(route('bookings.index')); ?>" data-cy="view-bookings">
                                <i class="fas fa-calendar-check me-2"></i>View Bookings
                            </a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form method="POST" action="<?php echo e(route('logout')); ?>" class="d-block">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <li class="nav-item mx-1">
                        <a class="btn btn-outline-light" href="<?php echo e(route('login')); ?>">
                            <i class="fas fa-sign-in-alt me-1"></i>Login
                        </a>
                    </li>
                    <li class="nav-item mx-1">
                        <a class="btn btn-light text-success" href="<?php echo e(route('register')); ?>">
                            <i class="fas fa-user-plus me-1"></i>Register
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">
<style>
    .navbar {
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        transition: background-color 0.3s ease;
    }
    .navbar .nav-link {
        color: rgba(255,255,255,0.8) !important;
        transition: color 0.3s ease;
        position: relative;
    }
    .navbar .nav-link:hover,
    .navbar .nav-link.active {
        color: white !important;
    }
    .navbar .nav-link.active::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background-color: white;
    }
    .navbar-brand img {
        transition: transform 0.3s ease;
    }
    .navbar-brand:hover img {
        transform: scale(1.1);
    }
</style>
<?php $__env->stopPush(); ?>
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/components/navbar.blade.php ENDPATH**/ ?>