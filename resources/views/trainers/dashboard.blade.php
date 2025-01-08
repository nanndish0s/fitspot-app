<x-app-layout> 
    <x-slot name="header">
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('Trainer Dashboard') }}
            </h2>
        </div>
    </x-slot>

    {{-- Add Leaflet CSS in the head section --}}
    @push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <style>
        #map { height: 300px; width: 100%; }
        #edit-map { height: 300px; width: 100%; }
        .leaflet-control-geocoder { z-index: 1000; }
    </style>
    @endpush

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <p class="text-gray-600 mt-2">Manage your profile and services effortlessly.</p>
        </div>

        @if ($trainer)
        <!-- Profile Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex items-start space-x-6">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-100">
                        @if($trainer->profile_picture)
                            <img src="{{ Storage::url($trainer->profile_picture) }}" alt="Profile picture" class="h-full w-full object-cover">
                        @else
                            <img src="{{ asset('images/default-avatar.png') }}" alt="Default profile" class="h-full w-full object-cover">
                        @endif
                    </div>
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-indigo-600 mb-4">Your Profile</h2>
                        <a href="{{ route('trainer.edit') }}" data-cy="edit-profile-button" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md border border-black">
                            Edit Profile
                        </a>
                    </div>
                    <p class="text-gray-700">
                        <span class="font-medium">Specialization:</span> {{ $trainer->specialization }}<br>
                        <span class="font-medium">Bio:</span> {{ $trainer->bio }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-indigo-600 mb-4">Quick Actions</h2>
            <div class="flex space-x-4">
                <a href="{{ route('trainer.bookings') }}" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md border border-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    View Bookings
                </a>
            </div>
        </div>

        <!-- Services Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-indigo-600 mb-4">Your Services</h2>
            @if ($services->count())
            <ul class="divide-y divide-gray-200">
                @foreach ($services as $service)
                <li class="py-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-grow flex gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">{{ $service->service_name }}</h3>
                                <p class="text-gray-600">{{ Str::limit($service->description, 100) }}</p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button data-cy="edit-service-button" class="edit-service-btn" data-service-id="{{ $service->id }}"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-black text-xs font-medium rounded-md border border-black">
                                Edit
                            </button>
                            <form action="{{ route('trainer.services.destroy', $service->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                @csrf
                                @method('DELETE')
                                <button data-cy="delete-service-button" type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                @endforeach
            </ul>
            @else
            <p class="text-gray-600">You have not added any services yet.</p>
            @endif
        </div>

        <!-- Chats Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-indigo-600 mb-4">User Chats</h2>
            @if ($chats->count())
                <div class="divide-y divide-gray-200">
                    @foreach ($chats as $chat)
                        <div class="py-4 flex justify-between items-center hover:bg-gray-50 transition duration-150 ease-in-out">
                            <div class="flex items-center space-x-4">
                                <div class="flex-shrink-0">
                                    <img class="h-12 w-12 rounded-full object-cover" 
                                         src="{{ $chat->user->profile_picture ? Storage::url($chat->user->profile_picture) : asset('images/default-avatar.png') }}" 
                                         alt="{{ $chat->user->name }}">
                                </div>
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $chat->user->name }}</h3>
                                    <p class="text-sm text-gray-500 max-w-md truncate">
                                        {{ $chat->last_message }}
                                    </p>
                                    @if($chat->created_at)
                                        <span class="text-xs text-gray-400">
                                            {{ $chat->created_at->diffForHumans() }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center space-x-3">
                                <button 
                                    x-data 
                                    x-on:click="$dispatch('open-chat', { userId: {{ $chat->user->id }} })"
                                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700 transition duration-150 ease-in-out">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                    Open Chat
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center text-gray-500 py-6">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <p class="text-lg font-semibold">No conversations yet</p>
                    <p class="text-sm text-gray-400">Users will appear here when they send you a message</p>
                </div>
            @endif
        </div>

        <!-- Add New Service Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="{{ route('trainer.services.store') }}" class="mt-6 space-y-4" enctype="multipart/form-data">
                @csrf
                <h3 class="text-lg font-semibold text-gray-700">Add a New Service</h3>
                <div class="flex flex-col gap-4">
                    <!-- Service Name -->
                    <div>
                        <label for="service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input type="text" id="service_name" name="service_name" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" required rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price (LKR)</label>
                        <input type="number" id="price" name="price" required step="0.01" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    <!-- Location Map -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Service Location</label>
                        <div id="map" class="mt-1 rounded-md border border-gray-300"></div>
                        <input type="hidden" id="latitude" name="latitude" required>
                        <input type="hidden" id="longitude" name="longitude" required>
                        <input type="hidden" id="location" name="location" required>
                        <div class="mt-2">
                            <label for="location_address" class="block text-sm font-medium text-gray-700">Selected Location</label>
                            <input type="text" id="location_address" name="location_address" readonly
                                   class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>
                        <p class="mt-1 text-sm text-gray-500">Click on the map or search for a location</p>
                    </div>

                    <!-- Service Image -->
                    <div class="mb-4">
                        <label for="service_image" class="block text-gray-700 text-sm font-bold mb-2">Service Image</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="service_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or GIF (MAX. 10MB)</p>
                                </div>
                                <input id="service_image" name="service_image" type="file" class="hidden" accept="image/png, image/jpeg, image/gif" />
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md border border-black">
                            Add Service
                        </button>
                    </div>
                </div>
            </form>
        </div>
        @else
        <!-- No Profile Section -->
        <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-lg">
            <p class="font-bold">You are not yet registered as a trainer.</p>
            <p>Please complete your trainer profile to access dashboard features.</p>
            <a href="{{ route('trainer.create') }}" class="mt-2 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Create Trainer Profile
            </a>
        </div>
        @endif
    </div>

    {{-- Add Leaflet JS and initialization script before closing body --}}
    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Function to get address from coordinates
            async function getAddressFromCoordinates(lat, lng, targetElement) {
                try {
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}`);
                    const data = await response.json();
                    if (data.display_name) {
                        targetElement.value = data.display_name;
                        // Also update the location field with the city or area
                        document.getElementById('location').value = data.address.city || data.address.town || data.address.suburb || data.address.county || data.display_name;
                    }
                } catch (error) {
                    console.error('Error getting address:', error);
                }
            }

            // Initialize the map
            var map = L.map('map').setView([51.505, -0.09], 13);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(map);

            var marker;

            // Add search control
            var geocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                map.fitBounds(poly.getBounds());
                
                if (marker) {
                    map.removeLayer(marker);
                }
                
                var latlng = e.geocode.center;
                marker = L.marker(latlng).addTo(map);
                
                document.getElementById('latitude').value = latlng.lat;
                document.getElementById('longitude').value = latlng.lng;
                
                // Update address field with the searched location
                if (e.geocode.name) {
                    document.getElementById('location_address').value = e.geocode.name;
                    document.getElementById('location').value = e.geocode.name;
                }
            })
            .addTo(map);

            // Try to get user's location
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const lat = position.coords.latitude;
                    const lng = position.coords.longitude;
                    map.setView([lat, lng], 13);
                    // Get initial address
                    getAddressFromCoordinates(lat, lng, document.getElementById('location_address'));
                });
            }

            // Handle map clicks
            map.on('click', function(e) {
                if (marker) {
                    map.removeLayer(marker);
                }
                marker = L.marker(e.latlng).addTo(map);
                document.getElementById('latitude').value = e.latlng.lat;
                document.getElementById('longitude').value = e.latlng.lng;
                
                // Get address for clicked location
                getAddressFromCoordinates(e.latlng.lat, e.latlng.lng, document.getElementById('location_address'));
            });

            // Form validation before submit
            document.querySelector('form').addEventListener('submit', function(e) {
                const lat = document.getElementById('latitude').value;
                const lng = document.getElementById('longitude').value;
                const location = document.getElementById('location').value;
                const locationAddress = document.getElementById('location_address').value;

                if (!lat || !lng || !location || !locationAddress) {
                    e.preventDefault();
                    alert('Please select a location on the map');
                }
            });
        });
    </script>
    @endpush

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editServiceForm" method="POST" action="" class="mt-6 space-y-4" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit_service_id" name="service_id">
                        
                        <!-- Service Name -->
                        <div>
                            <label for="edit_service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                            <input type="text" id="edit_service_name" name="service_name" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="edit_description" name="description" required rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="edit_price" class="block text-sm font-medium text-gray-700">Price (LKR)</label>
                            <input type="number" id="edit_price" name="price" required step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        </div>

                        <!-- Location Map -->
                        <div>
                            <label for="location" class="block text-sm font-medium text-gray-700">Service Location</label>
                            <div id="edit-map" class="mt-1 rounded-md border border-gray-300"></div>
                            <input type="hidden" id="edit_latitude" name="latitude" required>
                            <input type="hidden" id="edit_longitude" name="longitude" required>
                            <input type="hidden" id="edit_location" name="location" required>
                            <div class="mt-2">
                                <label for="edit_location_address" class="block text-sm font-medium text-gray-700">Selected Location</label>
                                <input type="text" id="edit_location_address" name="location_address" readonly
                                       class="mt-1 block w-full rounded-md border-gray-300 bg-gray-50 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            </div>
                            <p class="mt-1 text-sm text-gray-500">Click on the map or search for a location</p>
                        </div>

                        <!-- Service Image -->
                        <div class="mb-4">
                            <label for="edit_service_image" class="block text-gray-700 text-sm font-bold mb-2">Service Image</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="edit_service_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or GIF (MAX. 10MB)</p>
                                    </div>
                                    <input id="edit_service_image" name="service_image" type="file" class="hidden" accept="image/png, image/jpeg, image/gif" />
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" aria-label="Close">Close</button>
                    <button data-cy="save-changes" type="submit" form="editServiceForm" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Leaflet JS and initialization script before closing body --}}
    @push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the map
            var editMap = L.map('edit-map').setView([51.505, -0.09], 13);
            
            // Add OpenStreetMap tiles
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '© OpenStreetMap contributors'
            }).addTo(editMap);

            var editMarker;

            // Add search control to edit map
            var editGeocoder = L.Control.geocoder({
                defaultMarkGeocode: false
            })
            .on('markgeocode', function(e) {
                var bbox = e.geocode.bbox;
                var poly = L.polygon([
                    bbox.getSouthEast(),
                    bbox.getNorthEast(),
                    bbox.getNorthWest(),
                    bbox.getSouthWest()
                ]);
                editMap.fitBounds(poly.getBounds());
                
                if (editMarker) {
                    editMap.removeLayer(editMarker);
                }
                
                var latlng = e.geocode.center;
                editMarker = L.marker(latlng).addTo(editMap);
                
                document.getElementById('edit_latitude').value = latlng.lat;
                document.getElementById('edit_longitude').value = latlng.lng;
                
                // Update address field with the searched location
                if (e.geocode.name) {
                    document.getElementById('edit_location_address').value = e.geocode.name;
                    document.getElementById('edit_location').value = e.geocode.name;
                }
            })
            .addTo(editMap);

            editMap.on('click', function(e) {
                if (editMarker) {
                    editMap.removeLayer(editMarker);
                }
                editMarker = L.marker(e.latlng).addTo(editMap);
                document.getElementById('edit_latitude').value = e.latlng.lat;
                document.getElementById('edit_longitude').value = e.latlng.lng;
                
                // Get address for clicked location
                getAddressFromCoordinates(e.latlng.lat, e.latlng.lng, document.getElementById('edit_location_address'));
            });

            // Force map to recalculate its container size
            editMap.invalidateSize();
        });
    </script>
    @endpush

    <!-- Chat Modal -->
    <div 
        x-data="chatModal()" 
        x-show="isOpen" 
        x-cloak 
        class="fixed inset-0 z-50 overflow-y-auto"
        x-on:open-chat.window="openChat($event.detail)"
    >
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div 
                x-show="isOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 transition-opacity"
            >
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <div 
                x-show="isOpen"
                x-transition:enter="ease-out duration-300"
                x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave="ease-in duration-200"
                x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
            >
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="chat-modal-title">
                                Chat
                            </h3>
                            <div class="mt-2 h-96 overflow-y-auto" id="chat-messages">
                                <!-- Chat messages will be dynamically loaded here -->
                            </div>
                            <div class="mt-4 flex">
                                <input 
                                    type="text" 
                                    x-model="newMessage" 
                                    @keyup.enter="sendMessage"
                                    class="flex-grow mr-2 p-2 border rounded-md"
                                    placeholder="Type your message..."
                                >
                                <button 
                                    @click="sendMessage"
                                    class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
                                >
                                    Send
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button 
                        type="button" 
                        @click="closeChat"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editServiceModal = document.getElementById('editServiceModal');
            const editServiceForm = document.getElementById('editServiceForm');
            const editButtons = document.querySelectorAll('.edit-service-btn');

            // Debug: Log elements
            console.log('Edit Service Modal:', editServiceModal);
            console.log('Edit Service Form:', editServiceForm);
            console.log('Edit Buttons:', editButtons);

            // Edit button click handler
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-service-id');
                    
                    // Debug: Log service ID
                    console.log('Clicked Service ID:', serviceId);
                    
                    // Fetch service details
                    fetch(`/trainer/services/${serviceId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => {
                            console.log('Response Status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            // Debug: Log service details
                            console.log('Service Response:', data);

                            // Check if fetch was successful
                            if (!data.success) {
                                throw new Error(data.error || 'Failed to fetch service details');
                            }

                            const service = data.service;

                            // Get elements with null check and logging
                            const serviceIdEl = document.getElementById('edit_service_id');
                            const serviceNameEl = document.getElementById('edit_service_name');
                            const descriptionEl = document.getElementById('edit_description');
                            const priceEl = document.getElementById('edit_price');
                            const locationEl = document.getElementById('edit_location');

                            // Log each element
                            console.log('Service ID Element:', serviceIdEl);
                            console.log('Service Name Element:', serviceNameEl);
                            console.log('Description Element:', descriptionEl);
                            console.log('Price Element:', priceEl);
                            console.log('Location Element:', locationEl);

                            // Populate modal fields with null checks
                            if (serviceIdEl) serviceIdEl.value = service.id;
                            if (serviceNameEl) serviceNameEl.value = service.service_name;
                            if (descriptionEl) descriptionEl.value = service.description;
                            if (priceEl) priceEl.value = service.price;
                            if (locationEl) locationEl.value = service.location;

                            // Update form action
                            if (editServiceForm) {
                                editServiceForm.action = `/trainer/services/${serviceId}`;
                            }

                            // Show the modal using vanilla JavaScript
                            if (editServiceModal) {
                                editServiceModal.style.display = 'block';
                                document.body.classList.add('modal-open');
                                
                                // Create backdrop
                                const backdrop = document.createElement('div');
                                backdrop.classList.add('modal-backdrop', 'fade', 'show');
                                document.body.appendChild(backdrop);
                            }
                        })
                        .catch(error => {
                            console.error('Full Error:', error);
                            alert('Failed to load service details: ' + error.message);
                        });
                });
            });

            // Close modal button
            const closeModalButtons = editServiceModal.querySelectorAll('[aria-label="Close"]');
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (editServiceModal) {
                        editServiceModal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                        
                        // Remove backdrop
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    }
                });
            });

            // Form submission handler
            if (editServiceForm) {
                editServiceForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(editServiceForm);

                    fetch(editServiceForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Failed to update service');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close the modal using vanilla JavaScript
                            if (editServiceModal) {
                                editServiceModal.style.display = 'none';
                                document.body.classList.remove('modal-open');
                                
                                // Remove backdrop
                                const backdrop = document.querySelector('.modal-backdrop');
                                if (backdrop) {
                                    backdrop.remove();
                                }
                            }

                            // Update the service row in the table
                            const serviceRow = document.querySelector(`tr[data-service-id="${data.service.id}"]`);
                            if (serviceRow) {
                                serviceRow.querySelector('.service-name').textContent = data.service.service_name;
                                serviceRow.querySelector('.service-price').textContent = '$' + data.service.price;
                                serviceRow.querySelector('.service-location').textContent = data.service.location;
                            }

                            // Show success message
                            alert('Service updated successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'Failed to update service');
                    });
                });
            }
        });

        function chatModal() {
            return {
                isOpen: false,
                chatPartnerId: null,
                newMessage: '',
                messages: [],

                openChat(details) {
                    this.chatPartnerId = details.userId || details.trainerId;
                    this.isOpen = true;
                    this.loadMessages();
                },

                closeChat() {
                    this.isOpen = false;
                    this.chatPartnerId = null;
                    this.messages = [];
                },

                async loadMessages() {
                    try {
                        const response = await axios.get(`/api/chat/conversation/${this.chatPartnerId}`);
                        this.messages = response.data;
                        this.renderMessages();
                    } catch (error) {
                        console.error('Error loading messages:', error);
                    }
                },

                renderMessages() {
                    const messagesContainer = document.getElementById('chat-messages');
                    messagesContainer.innerHTML = this.messages.map(msg => `
                        <div class="mb-2 p-2 ${msg.sender_id === {{ auth()->id() }} ? 'text-right bg-blue-100' : 'text-left bg-gray-100'} rounded-md">
                            <p>${msg.message}</p>
                            <small class="text-xs text-gray-500">${new Date(msg.created_at).toLocaleString()}</small>
                        </div>
                    `).join('');
                    messagesContainer.scrollTop = messagesContainer.scrollHeight;
                },

                async sendMessage() {
                    if (!this.newMessage.trim()) return;

                    try {
                        const response = await axios.post('/api/chat/send', {
                            receiver_id: this.chatPartnerId,
                            message: this.newMessage
                        });

                        this.messages.push(response.data.chat_message);
                        this.renderMessages();
                        this.newMessage = '';
                    } catch (error) {
                        console.error('Error sending message:', error);
                    }
                }
            }
        }
    </script>
    @endpush
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
