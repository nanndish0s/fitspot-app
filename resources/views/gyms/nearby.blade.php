<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Nearby Gyms in Colombo
        </h2>
    </x-slot>

    <!-- Styles -->
    <style>
        #map {
            height: 500px;
            width: 100%;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .gym-card {
            padding: 15px;
            margin-bottom: 10px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            cursor: pointer;
            transition: background-color 0.2s;
        }
        .gym-card:hover {
            background: #f8f9fa;
        }
        .gym-name {
            font-weight: bold;
            color: #2c3e50;
            font-size: 1.1em;
            margin-bottom: 5px;
        }
        .gym-address, .gym-phone {
            color: #666;
            margin-bottom: 3px;
            font-size: 0.95em;
        }
        .gym-type {
            color: #888;
            font-size: 0.9em;
            margin-bottom: 5px;
        }
        .gym-website a {
            color: #3498db;
            text-decoration: none;
            font-size: 0.9em;
        }
        .gym-website a:hover {
            text-decoration: underline;
        }
        .ol-popup {
            position: absolute;
            background-color: white;
            box-shadow: 0 1px 4px rgba(0,0,0,0.2);
            padding: 15px;
            border-radius: 10px;
            border: 1px solid #cccccc;
            bottom: 12px;
            left: -50px;
            min-width: 280px;
        }
        .ol-popup:after, .ol-popup:before {
            top: 100%;
            border: solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
        }
        .ol-popup:after {
            border-top-color: white;
            border-width: 10px;
            left: 48px;
            margin-left: -10px;
        }
        .ol-popup:before {
            border-top-color: #cccccc;
            border-width: 11px;
            left: 48px;
            margin-left: -11px;
        }
        .ol-popup-closer {
            text-decoration: none;
            position: absolute;
            top: 2px;
            right: 8px;
        }
        .ol-popup-closer:after {
            content: "✖";
        }
        #location-error {
            display: none;
            background-color: #fee2e2;
            border: 1px solid #ef4444;
            color: #dc2626;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 12px;
        }
    </style>

    <!-- Map content -->
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div id="location-error"></div>
                    <div id="map"></div>
                    <div id="popup" class="ol-popup">
                        <a href="#" id="popup-closer" class="ol-popup-closer"></a>
                        <div id="popup-content"></div>
                    </div>
                    <div id="gym-list" class="mt-4"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/ol@v7.4.0/ol.css">
    <script src="https://cdn.jsdelivr.net/npm/ol@v7.4.0/dist/ol.js"></script>
    
    <script>
        let map;
        let popup;
        let popupOverlay;
        let userLocation = null;
        const defaultCenter = [79.8612, 6.9271]; // Colombo coordinates [lon, lat]
        
        // Initialize map
        function initMap() {
            // Create popup overlay
            const container = document.getElementById('popup');
            const content = document.getElementById('popup-content');
            const closer = document.getElementById('popup-closer');

            popupOverlay = new ol.Overlay({
                element: container,
                autoPan: true,
                autoPanAnimation: {
                    duration: 250
                }
            });

            closer.onclick = function() {
                popupOverlay.setPosition(undefined);
                closer.blur();
                return false;
            };

            // Create map
            map = new ol.Map({
                target: 'map',
                layers: [
                    new ol.layer.Tile({
                        source: new ol.source.OSM()
                    })
                ],
                overlays: [popupOverlay],
                view: new ol.View({
                    center: ol.proj.fromLonLat(defaultCenter),
                    zoom: 13
                })
            });

            // Get user location
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        userLocation = [position.coords.longitude, position.coords.latitude];
                        const userFeature = new ol.Feature({
                            geometry: new ol.geom.Point(ol.proj.fromLonLat(userLocation))
                        });

                        // Style for user location
                        userFeature.setStyle(new ol.style.Style({
                            image: new ol.style.Circle({
                                radius: 8,
                                fill: new ol.style.Fill({
                                    color: '#4299e1'
                                }),
                                stroke: new ol.style.Stroke({
                                    color: '#fff',
                                    width: 2
                                })
                            })
                        }));

                        // Add user location to map
                        const userLayer = new ol.layer.Vector({
                            source: new ol.source.Vector({
                                features: [userFeature]
                            })
                        });
                        map.addLayer(userLayer);

                        // Center map on user location
                        map.getView().animate({
                            center: ol.proj.fromLonLat(userLocation),
                            duration: 1000
                        });

                        loadGyms();
                    },
                    (error) => {
                        document.getElementById('location-error').style.display = 'block';
                        document.getElementById('location-error').textContent = 
                            'Could not get your location. Showing gyms around Colombo city center.';
                        loadGyms();
                    }
                );
            } else {
                document.getElementById('location-error').style.display = 'block';
                document.getElementById('location-error').textContent = 
                    'Geolocation is not supported by your browser. Showing gyms around Colombo city center.';
                loadGyms();
            }
        }

        // Function to load and display gyms
        async function loadGyms() {
            try {
                const response = await fetch('/nearby-gyms');
                const gyms = await response.json();
                
                // Check if no gyms found
                if (gyms.length === 0) {
                    document.getElementById('location-error').style.display = 'block';
                    document.getElementById('location-error').innerHTML = `
                        <strong>No gyms found</strong><br>
                        We couldn't find any gyms in the area. Try expanding your search or checking your location settings.
                    `;
                    return;
                }
                
                // Create features for gyms
                const features = gyms.map(gym => {
                    const feature = new ol.Feature({
                        geometry: new ol.geom.Point(ol.proj.fromLonLat([parseFloat(gym.lon), parseFloat(gym.lat)])),
                        name: gym.name,
                        address: gym.address,
                        type: gym.type,
                        phone: gym.phone,
                        website: gym.website
                    });

                    // Style for gym markers
                    feature.setStyle(new ol.style.Style({
                        image: new ol.style.Icon({
                            anchor: [0.5, 1],
                            src: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
                            scale: 0.5
                        })
                    }));

                    return feature;
                });

                // Add gyms layer to map
                const vectorSource = new ol.source.Vector({
                    features: features
                });

                const vectorLayer = new ol.layer.Vector({
                    source: vectorSource
                });

                map.addLayer(vectorLayer);

                // Handle clicks on gym markers
                map.on('click', function(evt) {
                    const feature = map.forEachFeatureAtPixel(evt.pixel, function(feature) {
                        return feature;
                    });

                    if (feature) {
                        const coordinates = feature.getGeometry().getCoordinates();
                        const content = `
                            <strong>${feature.get('name')}</strong><br>
                            ${feature.get('address') || 'Address not available'}<br>
                            Type: ${feature.get('type')}<br>
                            ${feature.get('phone') ? `Phone: ${feature.get('phone')}<br>` : ''}
                            ${feature.get('website') ? `<a href="${feature.get('website')}" target="_blank" class="text-blue-500 hover:text-blue-700">Visit Website</a>` : ''}
                        `;

                        document.getElementById('popup-content').innerHTML = content;
                        popupOverlay.setPosition(coordinates);
                    }
                });

                // Update gym list
                const gymList = document.getElementById('gym-list');
                gymList.innerHTML = '';

                gyms.forEach(gym => {
                    const gymCard = document.createElement('div');
                    gymCard.className = 'gym-card';
                    gymCard.innerHTML = `
                        <div class="gym-name">${gym.name}</div>
                        <div class="gym-address">${gym.address || 'Address not available'}</div>
                        <div class="gym-type">Type: ${gym.type}</div>
                        ${gym.phone ? `<div class="gym-phone">Phone: ${gym.phone}</div>` : ''}
                        ${gym.website ? `<div class="gym-website"><a href="${gym.website}" target="_blank">Visit Website</a></div>` : ''}
                    `;
                    
                    gymCard.addEventListener('click', () => {
                        const coordinates = ol.proj.fromLonLat([parseFloat(gym.lon), parseFloat(gym.lat)]);
                        map.getView().animate({
                            center: coordinates,
                            zoom: 16,
                            duration: 1000
                        });
                    });
                    
                    gymList.appendChild(gymCard);
                });
            } catch (error) {
                console.error('Error loading gyms:', error);
                document.getElementById('location-error').style.display = 'block';
                document.getElementById('location-error').innerHTML = `
                    <strong>Error Loading Gyms</strong><br>
                    We encountered an error while trying to load gyms. Please try again later.
                `;
            }
        }

        // Initialize map when page loads
        document.addEventListener('DOMContentLoaded', initMap);
    </script>
</x-app-layout>
