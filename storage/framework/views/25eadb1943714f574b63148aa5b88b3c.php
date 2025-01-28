<?php $__env->startSection('content'); ?>
    <div class="container">
        <h1>Nearby Gyms <small class="text-muted">(within 10 km)</small></h1>
        
        <div id="location-status" class="alert alert-info" style="display:none;">
            Searching for your location...
        </div>
        
        <div id="map" style="height: 500px; display:none;"></div>
        
        <div id="gym-list" class="mt-4" style="display:none;">
            <h2>Gyms Near You</h2>
            <ul id="gyms-results" class="list-group">
                <!-- Gyms will be populated dynamically -->
            </ul>
        </div>

        <div id="error-message" class="alert alert-danger" style="display:none;">
            Unable to find your location. Please check your device settings.
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
<style>
    .gym-details {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .gym-distance {
        color: #6c757d;
        font-size: 0.9em;
    }
    .radius-circle {
        stroke: rgba(0,123,255,0.5);
        stroke-width: 2;
        fill: rgba(0,123,255,0.1);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // DOM elements
    const locationStatus = document.getElementById('location-status');
    const mapContainer = document.getElementById('map');
    const gymListContainer = document.getElementById('gym-list');
    const gymsList = document.getElementById('gyms-results');
    const errorMessage = document.getElementById('error-message');

    // Configuration
    const MAX_DISTANCE = 10; // kilometers

    // Initialize map (will be set later)
    let map = null;

    // Try to get user's current location
    function getUserLocation() {
        // Show loading status
        locationStatus.textContent = 'Searching for your location...';
        locationStatus.style.display = 'block';

        // Hide other containers
        mapContainer.style.display = 'none';
        gymListContainer.style.display = 'none';
        errorMessage.style.display = 'none';

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                successCallback, 
                errorCallback, 
                { 
                    enableHighAccuracy: true, 
                    timeout: 10000, 
                    maximumAge: 0 
                }
            );
        } else {
            showError('Geolocation is not supported by this browser.');
        }
    }

    // Success callback for geolocation
    function successCallback(position) {
        const lat = position.coords.latitude;
        const lon = position.coords.longitude;

        // Hide location status
        locationStatus.style.display = 'none';

        // Show map and gym list containers
        mapContainer.style.display = 'block';
        gymListContainer.style.display = 'block';

        // Initialize or update map
        if (!map) {
            map = L.map('map').setView([lat, lon], 13);
            
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: ' OpenStreetMap contributors'
            }).addTo(map);
        } else {
            map.setView([lat, lon], 13);
        }

        // Add marker for user's location
        const userMarker = L.marker([lat, lon])
            .addTo(map)
            .bindPopup('Your Location')
            .openPopup();

        // Add 10 km radius circle
        L.circle([lat, lon], {
            color: 'blue',
            fillColor: '#30f',
            fillOpacity: 0.1,
            radius: MAX_DISTANCE * 1000 // convert km to meters
        }).addTo(map);

        // Fetch nearby gyms
        fetchNearbyGyms(lat, lon);
    }

    // Error callback for geolocation
    function errorCallback(error) {
        let errorMsg = 'Unable to retrieve your location';
        switch(error.code) {
            case error.PERMISSION_DENIED:
                errorMsg = "User denied the request for Geolocation.";
                break;
            case error.POSITION_UNAVAILABLE:
                errorMsg = "Location information is unavailable.";
                break;
            case error.TIMEOUT:
                errorMsg = "The request to get user location timed out.";
                break;
            case error.UNKNOWN_ERROR:
                errorMsg = "An unknown error occurred.";
                break;
        }
        showError(errorMsg);
    }

    // Show error message
    function showError(message) {
        locationStatus.style.display = 'none';
        mapContainer.style.display = 'none';
        gymListContainer.style.display = 'none';
        
        errorMessage.textContent = message;
        errorMessage.style.display = 'block';
    }

    // Fetch gyms near user's location
    function fetchNearbyGyms(lat, lon) {
        console.log(`Fetching gyms near: ${lat}, ${lon}`);
        fetch(`/api/gyms/nearby?latitude=${lat}&longitude=${lon}`)
            .then(response => {
                console.log('Response status:', response.status);
                return response.json();
            })
            .then(gyms => {
                console.log('Received gyms:', gyms);
                
                // Clear previous results
                gymsList.innerHTML = '';
                
                if (gyms.length === 0) {
                    var li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.textContent = `No gyms found within ${MAX_DISTANCE} km of your location.`;
                    gymsList.appendChild(li);
                    return;
                }
                
                // Feature group to fit map bounds
                var group = new L.featureGroup();

                gyms.forEach(gym => {
                    console.log('Processing gym:', gym);
                    
                    // Add marker for each gym
                    var marker = L.marker([gym.lat, gym.lon])
                        .addTo(map)
                        .bindPopup(`
                            <strong>${gym.name}</strong><br>
                            Distance: ${gym.distance} km
                        `);
                    
                    // Add to feature group for bounds
                    group.addLayer(marker);
                    
                    // Create list item
                    var li = document.createElement('li');
                    li.className = 'list-group-item';
                    li.innerHTML = `
                        <div class="gym-details">
                            <div>
                                <strong>${gym.name}</strong><br>
                                <small>Type: ${gym.type}</small>
                            </div>
                            <div class="gym-distance">
                                ${gym.distance} km
                            </div>
                        </div>
                    `;
                    gymsList.appendChild(li);
                });

                // Adjust map view to show all markers
                map.fitBounds(group.getBounds().pad(0.1));
            })
            .catch(error => {
                console.error('Error fetching gyms:', error);
                showError(`Failed to fetch nearby gyms within ${MAX_DISTANCE} km`);
            });
    }

    // Start by getting user's location
    getUserLocation();

    // Optional: Add a button to retry location
    const retryButton = document.createElement('button');
    retryButton.textContent = 'Retry Location';
    retryButton.className = 'btn btn-primary mt-3';
    retryButton.addEventListener('click', getUserLocation);
    errorMessage.appendChild(retryButton);
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/gyms/finder.blade.php ENDPATH**/ ?>