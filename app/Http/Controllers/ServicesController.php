<?php

namespace App\Http\Controllers;

use App\Models\TrainerService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServicesController extends Controller
{
    public function index(Request $request)
    {
        $query = TrainerService::with(['trainer.user']);

        // Log the total number of services before filtering
        Log::info('Total services before filtering', ['count' => TrainerService::count()]);

        // Search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('service_name', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%")
                  ->orWhereHas('trainer.user', function($q) use ($searchTerm) {
                      $q->where('name', 'like', "%{$searchTerm}%");
                  });
            });
        }

        // Specialization filter
        if ($request->filled('specialization') && $request->specialization !== 'all') {
            $query->whereHas('trainer', function($q) use ($request) {
                $q->where('specialization', $request->specialization);
            });
        }

        // Location and Distance filter
        if ($request->filled(['latitude', 'longitude'])) {
            $lat = $request->latitude;
            $lng = $request->longitude;
            $distance = $request->filled('distance') ? $request->distance : 50; // Default to 50km if not specified

            // Always calculate distance when coordinates are provided
            $query->selectRaw("
                *,
                ROUND(
                    (6371 * acos(
                        cos(radians(?)) * cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) * sin(radians(latitude))
                    ))::numeric, 1
                ) AS distance", [$lat, $lng, $lat]);

            // Only filter by distance if a specific range is selected
            if ($request->filled('distance')) {
                $query->having('distance', '<=', $distance);
            }

            // Always order by distance when coordinates are provided
            $query->orderBy('distance');
        }

        // Location filter
        if ($request->filled('location') && $request->location !== 'all') {
            $query->where('location', $request->location);
        }

        // Price range filter
        if ($request->filled('price_range')) {
            switch ($request->price_range) {
                case '0-1000':
                    $query->where('price', '<=', 1000);
                    break;
                case '1000-2000':
                    $query->whereBetween('price', [1000, 2000]);
                    break;
                case '2000+':
                    $query->where('price', '>', 2000);
                    break;
            }
        }

        // Sort filter
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'price_asc':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_desc':
                    $query->orderBy('price', 'desc');
                    break;
                case 'name':
                    $query->orderBy('service_name', 'asc');
                    break;
            }
        }

        $services = $query->paginate(9)->withQueryString();
        
        // Log the services being passed to the view
        Log::info('Services passed to view', [
            'total_services' => $services->total(),
            'service_ids' => $services->pluck('id'),
            'service_names' => $services->pluck('service_name')
        ]);

        return view('services.index', [
            'services' => $services,
            'filters' => [
                'search' => $request->search,
                'specialization' => $request->specialization,
                'location' => $request->location,
                'price_range' => $request->price_range,
                'sort' => $request->sort
            ]
        ]);
    }

    public function show(TrainerService $service)
    {
        // Eager load related trainer and user details
        $service->load(['trainer.user', 'trainer.services']);

        // Get related services from the same trainer
        $relatedServices = $service->trainer->services()
            ->where('id', '!=', $service->id)
            ->limit(3)
            ->get();

        return view('services.show', [
            'service' => $service,
            'relatedServices' => $relatedServices
        ]);
    }
}
