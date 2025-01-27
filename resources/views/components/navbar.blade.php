<nav x-data="{ mobileMenuOpen: false }" class="bg-green-600 shadow-md py-4 relative">
    <div class="container mx-auto px-4 flex justify-between items-center">
        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center space-x-2 text-white hover:opacity-80 transition-opacity">
            <img src="{{ asset('storage/logo.png') }}" alt="FitSpot Logo" class="h-12 w-12 rounded-full object-cover transform hover:scale-110 transition-transform">
            <span class="text-xl font-bold">FitSpot</span>
        </a>

        {{-- Mobile Menu Toggle --}}
        <button 
            @click="mobileMenuOpen = !mobileMenuOpen" 
            class="md:hidden text-white focus:outline-none"
        >
            <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
            <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>

        {{-- Desktop Navigation --}}
        <div class="hidden md:flex space-x-6 items-center">
            {{-- Main Navigation Links --}}
            <div class="flex space-x-6">
                @php
                    $navLinks = [
                        ['route' => 'home', 'icon' => 'fa-home', 'label' => 'Home'],
                        ['route' => 'products.index', 'icon' => 'fa-shopping-bag', 'label' => 'Shop'],
                        ['route' => 'services.index', 'icon' => 'fa-dumbbell', 'label' => 'Services'],
                        ['route' => 'gyms.nearby', 'icon' => 'fa-map-marker-alt', 'label' => 'Nearby Gyms'],
                        ['route' => 'forum.index', 'icon' => 'fa-comments', 'label' => 'Forum']
                    ];
                @endphp
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="text-white flex items-center space-x-1 
                        {{ request()->routeIs($link['route']) ? 'font-bold relative nav-active' : 'opacity-80 hover:opacity-100' }} 
                        transition-all duration-300 group">
                        <i class="fas {{ $link['icon'] }} mr-1"></i>
                        <span>{{ $link['label'] }}</span>
                    </a>
                @endforeach
            </div>

            {{-- Right Side Navigation --}}
            <div class="flex items-center space-x-4">
                {{-- Cart --}}
                <a href="{{ route('cart') }}" class="text-white flex items-center space-x-1 
                    {{ request()->routeIs('cart') ? 'font-bold' : 'opacity-80 hover:opacity-100' }}">
                    <i class="fas fa-shopping-cart mr-1"></i>
                    Cart 
                    <span class="bg-white text-green-600 rounded-full px-2 py-0.5 text-xs ml-1">
                        {{ auth()->check() ? auth()->user()->cart()->count() : 0 }}
                    </span>
                </a>

                {{-- Authentication Links --}}
                @auth
                    <div x-data="{ profileDropdown: false }" class="relative">
                        <button 
                            @click="profileDropdown = !profileDropdown" 
                            @click.outside="profileDropdown = false"
                            class="text-white flex items-center space-x-1 focus:outline-none"
                        >
                            <i class="fas fa-user mr-1"></i>
                            <span>{{ Str::limit(Auth::user()->name, 10) }}</span>
                            <svg class="w-4 h-4 ml-1" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>

                        <div 
                            x-show="profileDropdown" 
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100"
                            x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 mt-2 w-56 origin-top-right bg-white divide-y divide-gray-100 rounded-md shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none z-50"
                        >
                            <div class="px-1 py-1">
                                @if(auth()->user()->role === 'seller')
                                    <a href="{{ route('seller.dashboard') }}" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-green-500 hover:text-white">
                                        <i class="fas fa-store mr-2"></i>
                                        Seller Dashboard
                                    </a>
                                @endif
                                @if(auth()->user()->role === 'trainer')
                                    <a href="{{ route('trainer.dashboard') }}" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-green-500 hover:text-white">
                                        <i class="fas fa-chalkboard-teacher mr-2"></i>
                                        Trainer Dashboard
                                    </a>
                                @endif
                                <a href="{{ route('profile.edit') }}" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-green-500 hover:text-white">
                                    <i class="fas fa-user-edit mr-2"></i>
                                    Edit Profile
                                </a>
                                <a href="{{ route('wishlist.index') }}" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-green-500 hover:text-white">
                                    <i class="fas fa-heart mr-2"></i>
                                    Wishlist
                                </a>
                                <a href="{{ route('orders.index') }}" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-green-500 hover:text-white">
                                    <i class="fas fa-receipt mr-2"></i>
                                    My Orders
                                </a>
                                <a href="{{ route('bookings.index') }}" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-green-500 hover:text-white">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    View Bookings
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="w-full">
                                    @csrf
                                    <button type="submit" class="group flex w-full items-center rounded-md px-2 py-2 text-sm hover:bg-red-500 hover:text-white">
                                        <i class="fas fa-sign-out-alt mr-2"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="flex space-x-2">
                        <a href="{{ route('login') }}" class="text-white border border-white rounded px-3 py-1 hover:bg-white hover:text-green-600 transition-colors">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-green-600 rounded px-3 py-1 hover:bg-green-50 transition-colors">
                            <i class="fas fa-user-plus mr-1"></i>Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>

        {{-- Mobile Navigation --}}
        <div 
            x-show="mobileMenuOpen" 
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-90"
            class="absolute top-full left-0 w-full bg-green-600 md:hidden"
        >
            <div class="px-4 pt-2 pb-4 space-y-2">
                @foreach($navLinks as $link)
                    <a href="{{ route($link['route']) }}" class="block text-white py-2 border-b border-green-500 flex items-center 
                        {{ request()->routeIs($link['route']) ? 'font-bold' : 'opacity-80' }}">
                        <i class="fas {{ $link['icon'] }} mr-2"></i>
                        {{ $link['label'] }}
                    </a>
                @endforeach

                @auth
                    <div class="space-y-2">
                        @if(auth()->user()->role === 'seller')
                            <a href="{{ route('seller.dashboard') }}" class="block text-white py-2 border-b border-green-500 flex items-center">
                                <i class="fas fa-store mr-2"></i>
                                Seller Dashboard
                            </a>
                        @endif
                        @if(auth()->user()->role === 'trainer')
                            <a href="{{ route('trainer.dashboard') }}" class="block text-white py-2 border-b border-green-500 flex items-center">
                                <i class="fas fa-chalkboard-teacher mr-2"></i>
                                Trainer Dashboard
                            </a>
                        @endif
                        <a href="{{ route('profile.edit') }}" class="block text-white py-2 border-b border-green-500 flex items-center">
                            <i class="fas fa-user-edit mr-2"></i>
                            Edit Profile
                        </a>
                        <a href="{{ route('wishlist.index') }}" class="block text-white py-2 border-b border-green-500 flex items-center">
                            <i class="fas fa-heart mr-2"></i>
                            Wishlist
                        </a>
                        <a href="{{ route('orders.index') }}" class="block text-white py-2 border-b border-green-500 flex items-center">
                            <i class="fas fa-receipt mr-2"></i>
                            My Orders
                        </a>
                        <a href="{{ route('bookings.index') }}" class="block text-white py-2 border-b border-green-500 flex items-center">
                            <i class="fas fa-calendar-check mr-2"></i>
                            View Bookings
                        </a>
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left text-red-200 py-2 flex items-center">
                                <i class="fas fa-sign-out-alt mr-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    <div class="flex flex-col space-y-2">
                        <a href="{{ route('login') }}" class="text-white border border-white rounded px-3 py-2 text-center">
                            <i class="fas fa-sign-in-alt mr-1"></i>Login
                        </a>
                        <a href="{{ route('register') }}" class="bg-white text-green-600 rounded px-3 py-2 text-center">
                            <i class="fas fa-user-plus mr-1"></i>Register
                        </a>
                    </div>
                @endauth
            </div>
        </div>
    </div>
</nav>

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">
<style>
    .nav-active::after {
        content: '';
        position: absolute;
        bottom: -4px;
        left: 50%;
        transform: translateX(-50%);
        width: 30px;
        height: 3px;
        background-color: white;
    }
</style>
@endpush
