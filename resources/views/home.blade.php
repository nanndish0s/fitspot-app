<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page - FitSpot</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaiu8w/5mhw5/f+wP7/R7t0/0s4l/z0c/b/g9n/8357+eQ9+f/Xh8+K//w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { 
            font-family: 'Roboto', sans-serif; 
            background-color: #f4f6f9;
        }
        .bg-hero-image {
            background-image: url('storage/hero/hero-image.png'); 
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero-overlay {
            background: rgba(0, 0, 0, 0.5);
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
        }
        .feature-icon {
            color: #28a745;
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        /* Debugging Font Awesome */
        i.fas {
            display: inline-block !important;
            color: white !important;
        }
    </style>
</head>
<body>
    @include('components.navbar')

    <!-- Hero Section -->
    <section class="bg-hero-image text-white position-relative">
        <div class="hero-overlay"></div>
        <div class="container position-relative py-5">
            <div class="row align-items-center">
                <div class="col-lg-6 text-center text-lg-start">
                    <h1 class="display-4 fw-bold mb-4">Transform Your Fitness Journey</h1>
                    <p class="lead mb-4">Discover personalized training, top-quality supplements, and expert guidance to achieve your health goals.</p>
                    <div class="d-flex justify-content-center justify-content-lg-start gap-3">
                        <a href="{{ route('services.index') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-dumbbell me-2"></i>Explore Services
                        </a>
                        <a href="{{ route('products.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="fas fa-shopping-bag me-2"></i>Shop Supplements
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center d-none d-lg-block">
                    <img src="{{ asset('storage/hero/fitness-hero.png') }}" alt="" class="img-fluid rounded-circle shadow-lg" style="max-width: 400px;">
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <i class="fas fa-user-friends feature-icon"></i>
                    <h3 class="h4 mb-3">Expert Trainers</h3>
                    <p class="text-muted">Connect with certified fitness professionals tailored to your goals.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <i class="fas fa-heartbeat feature-icon"></i>
                    <h3 class="h4 mb-3">Personalized Plans</h3>
                    <p class="text-muted">Custom workout and nutrition plans designed specifically for you.</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="p-4 bg-white rounded shadow-sm h-100">
                    <i class="fas fa-medal feature-icon"></i>
                    <h3 class="h4 mb-3">Quality Supplements</h3>
                    <p class="text-muted">Premium, scientifically-backed supplements to support your fitness.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Latest Products Section -->
    <section class="bg-light py-5">
        <div class="container">
            <h2 class="text-center mb-4">Latest Supplements</h2>
            <div class="row">
                @foreach($latestProducts as $product)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="{{ asset('storage/'.$product->image) }}" class="card-img-top" alt="{{ $product->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $product->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($product->description, 100) }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="h5 mb-0">LKR {{ number_format($product->price, 2) }}</span>
                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-sm btn-success">View Details</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <!-- Footer -->
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
                        <li><a href="{{ route('services.index') }}" class="text-white-50">Services</a></li>
                        <li><a href="{{ route('products.index') }}" class="text-white-50">Products</a></li>
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
</body>
</html>
