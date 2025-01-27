<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center">
            {{-- <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('Our Services') }}
            </h2> --}}
        </div>
    </x-slot>
    <div class="bg-gradient-to-br from-indigo-600 to-purple-700 text-white py-16 mb-8">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <div class="flex justify-center mb-6">
                </div>
                <h1 class="text-4xl md:text-5xl font-bold mb-4 tracking-tight">
                    Transform Your Fitness Journey
                </h1>
                <p class="text-xl md:text-2xl mb-6 text-white/90 leading-relaxed">
                    Discover personalized training services tailored to your fitness goals. 
                    From weight training to yoga, find the perfect trainer to elevate your wellness.
                </p>
                <div class="flex justify-center space-x-4">
                    <a href="#services-grid" class="px-6 py-3 bg-white text-indigo-600 font-semibold rounded-lg shadow-md hover:bg-gray-100 transition duration-300">
                        Explore Services
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="py-8 bg-gradient-to-br from-indigo-50 via-purple-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Search and Filter Section -->
            <div id="services-grid" class="mb-8 mt-8 bg-white/80 backdrop-blur-lg rounded-2xl shadow-lg overflow-hidden border border-gray-100">
                <div class="p-6">
                    <form action="{{ route('services.index') }}" method="GET" class="space-y-6">
                        <!-- Search Bar -->
                        <div class="relative group">
                            <label for="search" class="sr-only">Search</label>
                            <input type="text" 
                                   id="search"
                                   name="search"
                                   value="{{ $filters['search'] ?? '' }}"
                                   placeholder="Search by service name, trainer, or description..." 
                                   class="w-full pl-12 pr-4 py-4 border border-gray-200 rounded-2xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 bg-white/50 backdrop-blur-sm group-hover:shadow-md"
                                   aria-label="Search by service name, trainer, or description">
                            <div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-indigo-500 group-hover:scale-110 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- Filters Grid -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <!-- Specialization Filter -->
                            <div class="space-y-2">
                                <label for="specialization" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Specialization
                                </label>
                                <select id="specialization" name="specialization" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                        aria-label="Select specialization">
                                    <option value="all">All Specializations</option>
                                    <option value="weight-training">Weight Training</option>
                                    <option value="cardio">Cardio</option>
                                    <option value="yoga">Yoga</option>
                                    <option value="hiit">HIIT</option>
                                    <option value="nutrition">Nutrition</option>
                                </select>
                            </div>

                            <!-- Price Range -->
                            <div class="space-y-2">
                                <label for="price_range" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path>
                                    </svg>
                                    Price Range
                                </label>
                                <select id="price_range" name="price_range" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                        aria-label="Select price range">
                                    <option value="">Any Price</option>
                                    <option value="0-1000" {{ ($filters['price_range'] ?? '') == '0-1000' ? 'selected' : '' }}>Under LKR 1,000</option>
                                    <option value="1000-2000" {{ ($filters['price_range'] ?? '') == '1000-2000' ? 'selected' : '' }}>LKR 1,000 - 2,000</option>
                                    <option value="2000+" {{ ($filters['price_range'] ?? '') == '2000+' ? 'selected' : '' }}>Over LKR 2,000</option>
                                </select>
                            </div>

                            <!-- Location Filter -->
                            <div class="space-y-2">
                                <label for="location" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Location
                                </label>
                                <div class="relative">
                                    <input type="text" 
                                           id="location" 
                                           name="location" 
                                           value="{{ $filters['location'] ?? '' }}"
                                           placeholder="Enter location or use current location" 
                                           class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm">
                                    <button type="button" 
                                            id="getCurrentLocation" 
                                            class="absolute right-2 top-1/2 transform -translate-y-1/2 text-indigo-500 hover:text-indigo-600"
                                            title="Use current location">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4zm0 6c-1.1 0-2-.9-2-2s.9-2 2-2 2 .9 2 2-.9 2-2 2z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 2C7.03 2 3 6.03 3 11c0 3.09 1.55 5.85 3.92 7.5C8.35 19.65 10.1 20 12 20s3.65-.35 5.08-1.5C19.45 16.85 21 14.09 21 11c0-4.97-4.03-9-9-9z"></path>
                                        </svg>
                                    </button>
                                    <input type="hidden" id="latitude" name="latitude" value="{{ $filters['latitude'] ?? '' }}">
                                    <input type="hidden" id="longitude" name="longitude" value="{{ $filters['longitude'] ?? '' }}">
                                </div>
                            </div>

                            <!-- Distance Range -->
                            <div class="space-y-2">
                                <label for="distance" class="block text-sm font-medium text-gray-700 flex items-center">
                                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                                    </svg>
                                    Distance Range
                                </label>
                                <select id="distance" name="distance" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm">
                                    <option value="">Any Distance</option>
                                    <option value="5" {{ ($filters['distance'] ?? '') == '5' ? 'selected' : '' }}>Within 5 km</option>
                                    <option value="10" {{ ($filters['distance'] ?? '') == '10' ? 'selected' : '' }}>Within 10 km</option>
                                    <option value="20" {{ ($filters['distance'] ?? '') == '20' ? 'selected' : '' }}>Within 20 km</option>
                                    <option value="50" {{ ($filters['distance'] ?? '') == '50' ? 'selected' : '' }}>Within 50 km</option>
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div class="space-y-2">
                                <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                                <select id="sort" name="sort" 
                                        class="w-full border border-gray-200 rounded-xl py-3 pl-4 pr-10 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-300 hover:shadow-md bg-white/50 backdrop-blur-sm"
                                        aria-label="Sort by">
                                    <option value="latest">Latest</option>
                                    <option value="price_low">Price: Low to High</option>
                                    <option value="price_high">Price: High to Low</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                            <a href="{{ route('services.index') }}" 
                               class="text-sm text-black hover:text-indigo-600 transition duration-300 focus:outline-none focus:underline"
                               aria-label="Clear all filters">
                                Clear all filters
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 rounded-xl bg-gray-200 text-black hover:bg-gray-300 focus:bg-gray-300 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-300">
                                Apply Filters
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($services as $service)
                    <div class="bg-white/90 backdrop-blur-lg rounded-2xl shadow-lg overflow-hidden hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 border border-gray-100 group" tabindex="0">
                        <!-- Service Image -->
                        <div class="relative h-64 bg-gradient-to-br from-indigo-600 to-purple-700 overflow-hidden group-hover:scale-105 transition-transform duration-500">
                            @if($service->image)
                                <img src="{{ asset('storage/' . $service->image) }}" 
                                     alt="{{ $service->service_name }}"
                                     class="w-full h-full object-cover opacity-90 group-hover:opacity-100 transition-opacity duration-300"
                                     loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <svg class="w-20 h-20 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                    </svg>
                                </div>
                            @endif
                            <!-- Fitness Category Badge -->
                            <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-sm px-3 py-1 rounded-full text-sm font-semibold text-indigo-600" aria-hidden="true">
                                {{ $service->category ?? 'Fitness' }}
                            </div>
                        </div>
                        
                        <div class="p-6">
                            <!-- Service Info -->
                            <div class="mb-4">
                                <h3 class="text-xl font-bold text-gray-900 mb-2 group-hover:text-indigo-600 transition duration-300 focus:outline-none focus:text-indigo-600" tabindex="0">{{ $service->service_name }}</h3>
                                <p class="text-gray-600 text-sm line-clamp-2 mb-3" aria-label="Service description">{{ $service->description }}</p>
                                
                                @if(isset($service->distance))
                                <div class="flex items-center text-sm text-gray-500 mb-2">
                                    <svg class="w-4 h-4 mr-1 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span>{{ number_format($service->distance, 1) }} km away</span>
                                </div>
                                @endif
                                <!-- Service Highlights -->
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @if($service->duration)
                                        <span class="bg-indigo-50 text-indigo-700 px-3 py-1 rounded-full text-xs font-medium" aria-label="Duration: {{ $service->duration }} mins">{{ $service->duration }} mins</span>
                                    @endif
                                    @if($service->difficulty)
                                        <span class="bg-purple-50 text-purple-700 px-3 py-1 rounded-full text-xs font-medium" aria-label="Difficulty: {{ $service->difficulty }}">{{ $service->difficulty }}</span>
                                    @endif
                                </div>
                                @if($service->trainer && $service->trainer->user)
                                    <a href="{{ route('trainers.profile', $service->trainer) }}" 
                                       class="text-sm text-indigo-600 hover:text-indigo-800 font-medium inline-flex items-center group focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-opacity-50 rounded-md"
                                       aria-label="View {{ $service->trainer->user->name }}'s profile">
                                        <svg class="w-4 h-4 mr-2 transform group-hover:scale-110 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        {{ $service->trainer->user->name }}
                                    </a>
                                @endif
                            </div>

                            <!-- Service Details -->
                            <div class="space-y-4 mb-6">
                                @if($service->trainer)
                                    <div class="flex flex-col gap-3">
                                        <div class="flex items-center justify-between text-sm text-gray-600">
                                            <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-medium bg-indigo-50 text-indigo-700 hover:bg-indigo-100 transition duration-300" aria-label="Specialization: {{ $service->trainer->specialization }}">
                                                {{ $service->trainer->specialization }}
                                            </span>
                                            
                                            {{-- Improved price display --}}
                                            <span class="text-base font-bold text-indigo-600">
                                                LKR {{ number_format($service->price, 2) }}
                                            </span>
                                        </div>
                                        <!-- Location -->
                                        <div class="flex items-center text-sm text-gray-600" aria-label="Location: {{ $service->location }}">
                                            <svg class="w-4 h-4 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $service->location }}
                                        </div>
                                        
                                        {{-- View Details Button --}}
                                        <div class="mt-4">
                                            <a href="{{ route('services.show', $service) }}" 
                                               class="w-full inline-flex items-center justify-center px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 space-x-2 group">
                                                <svg class="w-5 h-5 mr-2 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                View Service Details
                                            </a>
                                        </div>
                                    </div>
                                    @endif
                                </div>

                                <!-- Book Now Button -->
                                <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                                   class="inline-flex items-center px-4 py-2 bg-white border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-gray-100 focus:bg-gray-100 active:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                   aria-label="Book {{ $service->service_name }} service now">
                                    Book Now
                                </a>
                                @if($service->trainerService)
                                    <div class="flex items-center justify-between mt-4">
                                        <span class="text-lg font-bold text-primary">
                                            ${{ number_format($service->trainerService->price, 2) }}
                                        </span>
                                        <div class="flex space-x-2">
                                            <form action="{{ route('wishlist.store') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="service_id" value="{{ $service->trainerService->id }}">
                                                <button type="submit" class="bg-gray-200 text-gray-800 px-3 py-1 rounded hover:bg-gray-300 transition">
                                                    <i class="fas fa-heart mr-1"></i> Add to Wishlist
                                                </button>
                                            </form>
                                            <a href="{{ route('services.book', $service->trainerService->id) }}" class="bg-primary text-white px-3 py-1 rounded hover:bg-primary-dark transition">
                                                Book Now
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div> 
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8"> 
                {{ $services->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const getCurrentLocationBtn = document.getElementById('getCurrentLocation');
        const locationInput = document.getElementById('location');
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

        if (getCurrentLocationBtn) {
            getCurrentLocationBtn.addEventListener('click', function() {
                console.log('Location button clicked'); // Debug log
                if ("geolocation" in navigator) {
                    getCurrentLocationBtn.disabled = true;
                    getCurrentLocationBtn.classList.add('opacity-50');
                    
                    navigator.geolocation.getCurrentPosition(
                        function(position) {
                            console.log('Got position:', position); // Debug log
                            const latitude = position.coords.latitude;
                            const longitude = position.coords.longitude;
                            
                            // Set the hidden inputs
                            latitudeInput.value = latitude;
                            longitudeInput.value = longitude;
                            
                            // Reverse geocode to get address
                            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`)
                                .then(response => response.json())
                                .then(data => {
                                    console.log('Got address:', data); // Debug log
                                    locationInput.value = data.display_name;
                                })
                                .catch(error => {
                                    console.error('Error getting address:', error);
                                    locationInput.value = `${latitude}, ${longitude}`;
                                })
                                .finally(() => {
                                    getCurrentLocationBtn.disabled = false;
                                    getCurrentLocationBtn.classList.remove('opacity-50');
                                });
                        },
                        function(error) {
                            console.error('Geolocation error:', error); // Debug log
                            alert('Unable to get your location. Please enter it manually.');
                            getCurrentLocationBtn.disabled = false;
                            getCurrentLocationBtn.classList.remove('opacity-50');
                        },
                        {
                            enableHighAccuracy: true,
                            timeout: 5000,
                            maximumAge: 0
                        }
                    );
                } else {
                    alert('Geolocation is not supported by your browser');
                }
            });
        } else {
            console.error('Location button not found'); // Debug log
        }
    });
</script>
