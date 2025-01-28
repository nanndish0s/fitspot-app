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
    <div class="container-fluid forum-page py-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="display-4 text-primary">
                        <i class="fas fa-comments me-3"></i>Community Forum
                    </h1>
                    <?php if(auth()->guard()->check()): ?>
                    <a href="<?php echo e(route('forum.create')); ?>" class="btn btn-primary btn-lg shadow-sm">
                        <i class="fas fa-plus-circle me-2"></i>Create New Post
                    </a>
                    <?php endif; ?>
                </div>

                <div class="row">
                    <div class="col-md-3 mb-4">
                        <div class="card border-0 shadow-sm category-sidebar">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-tags me-2"></i>Forum Categories
                            </div>
                            <ul class="list-group list-group-flush">
                                <?php
                                    $categories = [
                                        'fitness-tips' => 'Fitness Tips',
                                        'nutrition' => 'Nutrition',
                                        'workout-routines' => 'Workout Routines',
                                        'general-discussion' => 'General Discussion'
                                    ];
                                ?>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slug => $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo e($category); ?>

                                    <span class="badge bg-primary rounded-pill">
                                        <?php echo e($posts->where('category', $category)->count()); ?>

                                    </span>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>

                        <?php if(auth()->guard()->guest()): ?>
                        <div class="card border-0 shadow-sm mt-3">
                            <div class="card-body text-center">
                                <h5 class="card-title mb-3">Join the Conversation</h5>
                                <p class="card-text text-muted mb-3">
                                    Log in or register to create your own forum posts and engage with the community.
                                </p>
                                <div class="d-grid gap-2">
                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Log In
                                    </a>
                                    <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-md-9">
                        <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="card mb-4 post-card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1">
                                        <h4 class="card-title text-primary">
                                            <a href="<?php echo e(route('forum.show', $post->id)); ?>" class="text-decoration-none">
                                                <?php echo e($post->title); ?>

                                            </a>
                                        </h4>
                                        <h6 class="card-subtitle text-muted">
                                            <i class="fas fa-user me-2"></i><?php echo e($post->user->name); ?> 
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-clock me-2"></i><?php echo e($post->created_at->diffForHumans()); ?>

                                            <?php if($post->category): ?>
                                            <span class="mx-2">•</span>
                                            <i class="fas fa-tag me-2"></i><?php echo e($post->category); ?>

                                            <?php endif; ?>
                                        </h6>
                                    </div>
                                    
                                    <?php if(auth()->guard()->check()): ?>
                                    <?php if(Auth::id() === $post->user_id): ?>
                                    <div>
                                        <form action="<?php echo e(route('forum.destroy', $post->id)); ?>" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this post?');">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>

                                <p class="card-text text-muted mb-3">
                                    <?php echo e(Str::limit($post->content, 200)); ?>

                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="post-stats text-muted">
                                        <span class="me-3">
                                            <i class="fas fa-comment me-2"></i><?php echo e($post->comments_count); ?> Comments
                                        </span>
                                        <span>
                                            <i class="fas fa-heart me-2"></i><?php echo e($post->likes->count()); ?> Likes
                                        </span>
                                    </div>
                                    <a href="<?php echo e(route('forum.show', $post->id)); ?>" class="btn btn-outline-primary btn-sm">
                                        Read More <i class="fas fa-arrow-right ms-2"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="card border-0 shadow-sm">
                            <div class="card-body text-center">
                                <i class="fas fa-comment-slash text-muted mb-3" style="font-size: 3rem;"></i>
                                <h4 class="card-title mb-3">No Forum Posts Yet</h4>
                                <p class="card-text text-muted mb-4">
                                    Be the first to start a discussion in our community!
                                </p>
                                <?php if(auth()->guard()->check()): ?>
                                <a href="<?php echo e(route('forum.create')); ?>" class="btn btn-primary">
                                    <i class="fas fa-plus-circle me-2"></i>Create First Post
                                </a>
                                <?php endif; ?>
                                <?php if(auth()->guard()->guest()): ?>
                                <div class="d-flex justify-content-center gap-3">
                                    <a href="<?php echo e(route('login')); ?>" class="btn btn-primary">
                                        <i class="fas fa-sign-in-alt me-2"></i>Log In
                                    </a>
                                    <a href="<?php echo e(route('register')); ?>" class="btn btn-outline-primary">
                                        <i class="fas fa-user-plus me-2"></i>Register
                                    </a>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="d-flex justify-content-center mt-4">
                            <?php echo e($posts->links('pagination::bootstrap-4')); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('styles'); ?>
    <style>
        .forum-page {
            background-color: #f4f6f9;
        }
        .category-sidebar .list-group-item {
            transition: all 0.3s ease;
        }
        .category-sidebar .list-group-item:hover {
            background-color: #f8f9fa;
            transform: translateX(5px);
        }
        .post-card {
            transition: all 0.3s ease;
        }
        .post-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }
        .post-stats i {
            color: #6c757d;
        }
    </style>
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
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/forum/index.blade.php ENDPATH**/ ?>