<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-600">
                        FitSpot
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                        {{ __('Home') }}
                    </x-nav-link>
                    
                    @auth
                        @if(auth()->user()->isTrainer())
                            <x-nav-link :href="route('trainer.dashboard')" :active="request()->routeIs('trainer.dashboard')">
                                {{ __('Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('trainer.bookings')" :active="request()->routeIs('trainer.bookings')">
                                {{ __('Manage Bookings') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')">
                                {{ __('Find Trainers') }}
                            </x-nav-link>
                            <x-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index')">
                                {{ __('My Bookings') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <!-- Settings Dropdown -->
                <div class="ml-3 relative">
                    @auth
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                @if(auth()->user()->isTrainer())
                                    <x-dropdown-link :href="route('trainer.dashboard')">
                                        {{ __('Dashboard') }}
                                    </x-dropdown-link>
                                    <x-dropdown-link :href="route('trainer.bookings')">
                                        {{ __('Manage Bookings') }}
                                    </x-dropdown-link>
                                @else
                                    <x-dropdown-link :href="route('bookings.index')">
                                        {{ __('My Bookings') }}
                                    </x-dropdown-link>
                                @endif

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    @else
                        <div class="space-x-4">
                            <a href="{{ route('login') }}" class="text-sm text-gray-700 hover:text-indigo-600">Log in</a>
                            <a href="{{ route('register') }}" class="text-sm text-white bg-indigo-600 hover:bg-indigo-700 px-4 py-2 rounded-md">Register</a>
                        </div>
                    @endauth
                </div>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Home') }}
            </x-responsive-nav-link>
            
            @auth
                @if(auth()->user()->isTrainer())
                    <x-responsive-nav-link :href="route('trainer.dashboard')" :active="request()->routeIs('trainer.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trainer.bookings')" :active="request()->routeIs('trainer.bookings')">
                        {{ __('Manage Bookings') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('services.index')" :active="request()->routeIs('services.index')">
                        {{ __('Find Trainers') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('bookings.index')" :active="request()->routeIs('bookings.index')">
                        {{ __('My Bookings') }}
                    </x-responsive-nav-link>
                @endif
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        @auth
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                @if(auth()->user()->isTrainer())
                    <x-responsive-nav-link :href="route('trainer.dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('trainer.bookings')">
                        {{ __('Manage Bookings') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('bookings.index')">
                        {{ __('My Bookings') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
        @else
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="space-y-1">
                <x-responsive-nav-link :href="route('login')">
                    {{ __('Log in') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('register')">
                    {{ __('Register') }}
                </x-responsive-nav-link>
            </div>
        </div>
        @endauth
    </div>
</nav>
