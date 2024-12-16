<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TrainerService;
use App\Models\Trainer;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class TrainerServiceController extends Controller
{
    //
    public function store(Request $request)
    {
        try {
            // Log the entire request for debugging
            Log::info('Service Creation Request', [
                'user_id' => Auth::id(),
                'request_data' => $request->all()
            ]);

            $validated = $request->validate([
                'service_name' => 'required|string|max:255',
                'description' => 'required|string',
                'price' => 'required|numeric|min:0',
                'location' => 'required|string|max:255',
                'latitude' => 'nullable|numeric|between:-90,90',
                'longitude' => 'nullable|numeric|between:-180,180',
                'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
            ]);

            // Ensure user is authenticated
            if (!Auth::check()) {
                Log::error('Unauthorized service creation attempt');
                return redirect()->back()->withErrors(['error' => 'You must be logged in to create a service.']);
            }

            // Get the trainer
            $trainer = Auth::user()->trainer;

            if (!$trainer) {
                Log::error('No trainer profile found', ['user_id' => Auth::id()]);
                return redirect()->back()->withErrors(['error' => 'You must create a trainer profile first.']);
            }

            // Handle image upload
            $imagePath = null;
            if ($request->hasFile('service_image')) {
                try {
                    $imagePath = $request->file('service_image')->store('service-images', 'public');
                } catch (\Exception $e) {
                    Log::error('Image upload failed', [
                        'error' => $e->getMessage(),
                        'user_id' => Auth::id()
                    ]);
                    // Continue without image
                }
            }

            // Prepare data for creation
            $serviceData = [
                'trainer_id' => $trainer->id,
                'service_name' => $validated['service_name'],
                'description' => $validated['description'],
                'price' => $validated['price'],
                'location' => $validated['location'],
                'latitude' => $validated['latitude'] ?? 0,
                'longitude' => $validated['longitude'] ?? 0,
                'image' => $imagePath
            ];

            // Create service
            $service = TrainerService::create($serviceData);

            // Log successful service creation
            Log::info('Service Created Successfully', [
                'service_id' => $service->id,
                'service_name' => $service->service_name,
                'trainer_id' => $trainer->id
            ]);

            return redirect('/trainer/dashboard')->with('success', 'Service added successfully.');
        } catch (ValidationException $e) {
            // Log validation errors
            Log::error('Service Creation Validation Failed', [
                'errors' => $e->errors(),
                'user_id' => Auth::id()
            ]);
            
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            // Log any unexpected errors
            Log::error('Unexpected Service Creation Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id()
            ]);

            return redirect()->back()->withErrors(['error' => 'An unexpected error occurred. Please try again.']);
        }
    }

    public function index()
    {
        $services = TrainerService::with('trainer.user')->get();
        return view('services.index', compact('services'));
    }

    public function show($id)
    {
        try {
            $service = auth()->user()->trainer->services()->findOrFail($id);
            return response()->json([
                'success' => true,
                'service' => $service
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching service details', [
                'service_id' => $id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id()
            ]);
            return response()->json([
                'success' => false,
                'error' => 'Service not found or you do not have permission to view this service'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $service = auth()->user()->trainer->services()->findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'service_name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'location' => 'required|string|max:255',
            'service_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle image upload if a new image is provided
        if ($request->hasFile('service_image')) {
            // Delete the old image if it exists
            if ($service->image) {
                Storage::disk('public')->delete($service->image);
            }
            
            // Store the new image
            $imagePath = $request->file('service_image')->store('service-images', 'public');
            $validated['image'] = $imagePath;
        }

        // Update the service
        $service->update($validated);

        // Check if this is an AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Service updated successfully',
                'service' => $service
            ]);
        }

        // Fallback for non-AJAX requests
        return redirect()->route('trainer.dashboard')->with('success', 'Service updated successfully.');
    }

    public function destroy($id)
    {
        $service = auth()->user()->trainer->services()->findOrFail($id);
        
        // Delete the service image if it exists
        if ($service->image) {
            Storage::disk('public')->delete($service->image);
        }
        
        $service->delete();
        return redirect('/trainer/dashboard')->with('success', 'Service deleted successfully.');
    }
}
