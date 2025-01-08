<?php

namespace App\Http\Controllers;

use App\Models\Gym;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GymController extends Controller
{
    /**
     * Display the nearby gyms page
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('gyms.nearby');
    }

    /**
     * Find gyms in Colombo
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function nearbyGyms(Request $request)
    {
        $colomboLat = 6.9271;
        $colomboLng = 79.8612;
        
        // Fetch from OpenStreetMap
        $query = '[out:json][timeout:25];
            (
                // Standard gym and fitness queries
                node["leisure"="fitness_centre"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                way["leisure"="fitness_centre"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                node["leisure"="sports_centre"]["sport"="fitness"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                way["leisure"="sports_centre"]["sport"="fitness"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                node["leisure"="gym"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                way["leisure"="gym"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                
                // Additional amenity types that might be gyms
                node["amenity"="gym"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                way["amenity"="gym"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                node["sport"="fitness"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
                way["sport"="fitness"](around:8000,' . $colomboLat . ',' . $colomboLng . ');
            );
            out body;
            >;
            out skel qt;';

        $url = 'https://overpass-api.de/api/interpreter';
        $options = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => 'data=' . urlencode($query)
            ]
        ];

        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        $data = json_decode($result, true);

        // Process OpenStreetMap results
        $gyms = [];
        foreach ($data['elements'] as $element) {
            if (isset($element['tags']) && 
                isset($element['tags']['name']) && 
                $element['tags']['name'] !== 'Unnamed Gym' && 
                !empty(trim($element['tags']['name']))) {
                $gyms[] = [
                    'id' => $element['id'],
                    'name' => $element['tags']['name'],
                    'lat' => $element['lat'] ?? null,
                    'lon' => $element['lon'] ?? null,
                    'address' => $element['tags']['addr:street'] ?? null,
                    'type' => $element['tags']['leisure'] ?? $element['tags']['amenity'] ?? $element['tags']['sport'] ?? 'gym',
                    'phone' => $element['tags']['phone'] ?? null,
                    'website' => $element['tags']['website'] ?? null
                ];
            }
        }

        // Add popular Colombo gyms that might not be in OpenStreetMap
        $popularGyms = [
            [
                'id' => 'custom1',
                'name' => 'Fitness Connection',
                'lat' => 6.9019,
                'lon' => 79.8619,
                'address' => '89 Galle Rd, Colombo 03',
                'type' => 'fitness_centre',
                'phone' => '+94 11 2 575 975',
                'website' => 'http://www.fitnessconnection.lk'
            ],
            [
                'id' => 'custom2',
                'name' => 'Gold\'s Gym',
                'lat' => 6.9114,
                'lon' => 79.8489,
                'address' => '24 Station Road, Colombo 04',
                'type' => 'fitness_centre',
                'phone' => '+94 11 2 508 808',
                'website' => 'https://www.goldsgym.lk'
            ],
            [
                'id' => 'custom3',
                'name' => 'Lifestyle Gym',
                'lat' => 6.9060,
                'lon' => 79.8552,
                'address' => '100 Horton Place, Colombo 07',
                'type' => 'fitness_centre',
                'phone' => '+94 11 2 682 682',
                'website' => null
            ],
            [
                'id' => 'custom4',
                'name' => 'Power World Gym',
                'lat' => 6.8978,
                'lon' => 79.8730,
                'address' => '590 Galle Road, Colombo 06',
                'type' => 'fitness_centre',
                'phone' => '+94 11 2 363 699',
                'website' => null
            ],
            [
                'id' => 'custom5',
                'name' => 'Spark Fitness Studio',
                'lat' => 6.9167,
                'lon' => 79.8473,
                'address' => '33 Park Road, Colombo 05',
                'type' => 'fitness_centre',
                'phone' => '+94 77 123 4567',
                'website' => null
            ]
        ];

        // Merge OpenStreetMap results with popular gyms
        $allGyms = array_merge($gyms, $popularGyms);

        return response()->json($allGyms);
    }

    /**
     * Get gym details
     *
     * @param Gym $gym
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Gym $gym)
    {
        return response()->json([
            'success' => true,
            'data' => $gym
        ]);
    }
}
