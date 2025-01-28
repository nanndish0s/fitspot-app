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
    <div class="wishlist-hero bg-primary text-white py-5 mb-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <h1 class="display-4 mb-3">
                        <i class="fas fa-heart me-3"></i>My Wishlist
                    </h1>
                    <p class="lead mb-4">
                        Your curated collection of fitness essentials and services to elevate your wellness journey.
                    </p>
                </div>
                <div class="col-lg-4 d-none d-lg-block text-end">
                    <img src="<?php echo e(asset('images/wishlist-hero.png')); ?>" 
                         alt="Wishlist" class="img-fluid hero-image" style="max-width: 250px; transform: rotate(-15deg);">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-4" id="wishlist-content">
        <?php if(session('success')): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo e(session('success')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(session('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo e(session('error')); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if($wishlistServices->count() > 0 || $wishlistProducts->count() > 0): ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                
                <?php $__currentLoopData = $wishlistServices; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col wishlist-item">
                        <div class="card h-100 border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0"><?php echo e($item->service->name); ?></h5>
                                    <form action="<?php echo e(route('wishlist.destroy', $item->id)); ?>" method="POST" class="ms-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                title="Remove from Wishlist"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top">
                                            <i class="fas fa-trash me-1"></i>Remove
                                        </button>
                                    </form>
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    <?php echo e(Str::limit($item->service->description, 100)); ?>

                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h4 text-success mb-0">
                                        $<?php echo e(number_format($item->service->price, 2)); ?>

                                    </span>
                                    <a href="<?php echo e(route('services.show', $item->service->id)); ?>" class="btn btn-primary btn-sm">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                
                <?php $__currentLoopData = $wishlistProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col wishlist-item">
                        <div class="card h-100 border-0 shadow-sm">
                            <?php if($item->product->image): ?>
                                <img src="<?php echo e(asset('storage/'.$item->product->image)); ?>" 
                                     class="card-img-top" 
                                     alt="<?php echo e($item->product->name); ?>"
                                     style="height: 250px; object-fit: cover;">
                            <?php else: ?>
                                <img src="https://via.placeholder.com/300x250" 
                                     class="card-img-top" 
                                     alt="<?php echo e($item->product->name); ?>">
                            <?php endif; ?>
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <h5 class="card-title mb-0"><?php echo e($item->product->name); ?></h5>
                                    <form action="<?php echo e(route('wishlist.destroy', $item->id)); ?>" method="POST" class="ms-2">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                title="Remove from Wishlist"
                                                data-bs-toggle="tooltip" 
                                                data-bs-placement="top">
                                            <i class="fas fa-trash me-1"></i>Remove
                                        </button>
                                    </form>
                                </div>
                                <p class="card-text text-muted small mb-3">
                                    <?php echo e(Str::limit($item->product->description, 100)); ?>

                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="product-price">
                                        <?php if($item->product->discount > 0): ?>
                                            <span class="text-muted text-decoration-line-through me-2">
                                                $<?php echo e(number_format($item->product->original_price, 2)); ?>

                                            </span>
                                        <?php endif; ?>
                                        <span class="fw-bold text-success">
                                            $<?php echo e(number_format($item->product->price, 2)); ?>

                                        </span>
                                    </div>
                                    <div class="btn-group" role="group">
                                        <form action="<?php echo e(route('cart.add', $item->product->id)); ?>" method="POST" class="me-2">
                                            <?php echo csrf_field(); ?>
                                            <button type="submit" class="btn btn-primary btn-sm">
                                                <i class="fas fa-cart-plus me-2"></i>Add to Cart
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <i class="fas fa-heart-broken text-muted" style="font-size: 5rem;"></i>
                <h2 class="mt-3 mb-4">Your Wishlist is Empty</h2>
                <p class="lead text-muted mb-4">
                    Discover amazing fitness products and services that can transform your wellness journey.
                </p>
                <div class="d-flex justify-content-center gap-3">
                    <a href="<?php echo e(route('services.index')); ?>" class="btn btn-primary btn-lg">
                        <i class="fas fa-dumbbell me-2"></i>Explore Services
                    </a>
                    <a href="<?php echo e(route('products.index')); ?>" class="btn btn-outline-primary btn-lg">
                        <i class="fas fa-shopping-bag me-2"></i>Browse Products
                    </a>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
        .wishlist-hero {
            background: linear-gradient(135deg, #6a11cb 0%, #2575fc 100%);
            position: relative;
            overflow: hidden;
        }
        .wishlist-hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" width="100%" height="100%" viewBox="0 0 1600 800" preserveAspectRatio="none"%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1102.5 734.8c2.5-1.2 24.8-8.6 25.6-7.5.5.7-5.4 23.4-6.6 24.4-1.4-.3-19.4-3.4-19-17.9z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1226.3 782.3c13.6-7.9 14-25.4 1-33.8-13.6-8.5-32.6-.7-34.6 15-1.4 13.5 8.4 24.7 20.9 24.8 5.2 0 10.9-1.6 12.7-6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M1152.7 782.4c-9.7 5-9.9 16.4-1.4 21.8 8.5 5.3 22.6.7 24.2-8.4 1.1-6.8-4.4-15.3-12.8-13.4-4.3 1-7.4 4.4-10 8z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1234.8 762.3c-8.6 7-11.4 13.3-8.6 21.8 3.9 12 18.8 10.5 23.4 3.5 3.7-5.8 2.2-15.6-5.4-19.3-4.4-2.1-9.4-1.7-9.4 6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M1206.1 718.8c1-5.7-1.9-11.2-7.9-13.5-12.2-4.4-26 2.8-25.8 15.7-.1 10.2 9.5 16.3 19.3 14.4 7.6-1.7 12.1-7.2 14.4-16.6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.1" d="M1071.5 798.3c15.4-7.3 14.6-25.4 1.5-33.7-13.6-8.8-32.9-.7-34.6 15-1.4 13.5 8.4 24.7 20.9 24.8 5.2 0 10.9-1.6 12.2-6z"/%3E%3Cpath fill="%23ffffff" fill-opacity="0.05" d="M1062 774.5c-7.6 4.5-6.5 14.7 1.8 20.2 12.6 8 30.3-.2 28.1-13.5-1.6-10.5-16.9-12.3-29.9-6.7z"/%3E%3C/svg%3E');
            opacity: 0.1;
        }
        .wishlist-item .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .wishlist-item .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
        }
    </style>
    <?php $__env->stopPush(); ?>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize tooltips
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
        });
    </script>
    <?php $__env->stopPush(); ?>
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
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/wishlist/index.blade.php ENDPATH**/ ?>