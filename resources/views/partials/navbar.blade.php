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
            <a href="/" class="nav-link"><i class="fas fa-home me-1"></i>Home</a>
            <a href="/products" class="nav-link"><i class="fas fa-shopping-bag me-1"></i>Shop</a>
            <a href="/cart" class="nav-link"><i class="fas fa-shopping-cart me-1"></i>Cart</a>
            <a href="/orders" class="nav-link"><i class="fas fa-receipt me-1"></i>Orders</a>
            @auth
                @if(auth()->user()->role === 'user')
                    <a href="{{ route('services.index') }}" class="nav-link"><i class="fas fa-dumbbell me-1"></i>Services</a>
                @endif
                @if(auth()->user()->role === 'trainer')
                    <a href="{{ route('trainer.dashboard') }}" class="nav-link"><i class="fas fa-chalkboard-teacher me-1"></i>Dashboard</a>
                @endif
                @if(auth()->user()->role === 'seller')
                    <a href="/seller/dashboard" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600"><i class="fas fa-store me-1"></i>Seller Dashboard</a>
                @endif
                <div class="relative">
                    <button data-cy="profile-dropdown" class="nav-link">
                        <i class="fas fa-user me-1"></i>Profile
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1">
                        <a href="{{ route('orders.index') }}" data-cy="view-bookings" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">View Bookings</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-sign-out-alt me-1"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="/login" class="nav-link"><i class="fas fa-sign-in-alt me-1"></i>Login</a>
                <a href="/register" class="bg-white text-green-600 px-4 py-2 rounded hover:bg-gray-100"><i class="fas fa-user-plus me-1"></i>Register</a>
            @endauth
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
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const profileDropdown = document.querySelector('[data-cy="profile-dropdown"]');
        const dropdownMenu = profileDropdown?.nextElementSibling;

        if (profileDropdown && dropdownMenu) {
            // Initially hide the dropdown
            dropdownMenu.style.display = 'none';

            // Toggle dropdown on click
            profileDropdown.addEventListener('click', function(e) {
                e.preventDefault();
                const isHidden = dropdownMenu.style.display === 'none';
                dropdownMenu.style.display = isHidden ? 'block' : 'none';
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function(e) {
                if (!profileDropdown.contains(e.target) && !dropdownMenu.contains(e.target)) {
                    dropdownMenu.style.display = 'none';
                }
            });
        }
    });
</script>