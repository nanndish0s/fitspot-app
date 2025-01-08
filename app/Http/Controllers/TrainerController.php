<?php

namespace App\Http\Controllers;
use App\Models\Trainer; // This imports the Trainer model
use App\Models\ChatMessage; // This imports the ChatMessage model

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TrainerController extends Controller
{
    //
    // Show the form to create a trainer profile
    public function create()
    {
        return view('trainers.create'); // The view should contain the form for creating a trainer profile
    }



    public function store(Request $request)
    {
        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'bio' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle the profile picture upload
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile-pictures', 'public');
        }

        // Create the trainer profile and associate it with the authenticated user
        $trainer = Trainer::create([
            'user_id' => auth()->id(),
            'specialization' => $validated['specialization'],
            'bio' => $validated['bio'],
            'profile_picture' => $profilePicturePath
        ]);

        // Redirect to the trainer dashboard with a success message
        return redirect()->route('trainer.dashboard')->with('success', 'Trainer profile created successfully.');
    }


public function index()
{
    $trainers = Trainer::with('services')->get();
    return view('trainers.index', compact('trainers'));
}

public function dashboard()
{
    // Get the authenticated user's trainer profile
    $trainer = Trainer::where('user_id', auth()->id())->first();

    // Get the trainer's services
    $services = $trainer ? $trainer->services : collect();

    // Get recent chats with users
    $chats = ChatMessage::where('receiver_id', auth()->id())
        ->orWhere('sender_id', auth()->id())
        ->with(['sender', 'receiver'])
        ->get()
        // Group conversations by the other user
        ->groupBy(function($message) {
            return $message->sender_id === auth()->id() 
                ? $message->receiver_id 
                : $message->sender_id;
        })
        // Get the most recent message for each conversation
        ->map(function($conversationMessages) {
            $lastMessage = $conversationMessages->sortByDesc('created_at')->first();
            $otherUser = $lastMessage->sender_id === auth()->id() 
                ? $lastMessage->receiver 
                : $lastMessage->sender;
            
            return (object)[
                'user' => $otherUser,
                'last_message' => $lastMessage->message,
                'created_at' => $lastMessage->created_at
            ];
        })
        // Sort conversations by the most recent message
        ->sortByDesc('created_at')
        ->values();

    return view('trainers.dashboard', compact('trainer', 'services', 'chats'));
}

public function addService(Request $request)
{
    $request->validate([
        'service_name' => 'required|string|max:255',
        'description' => 'required|string',
        'price' => 'required|numeric|min:0',
    ]);

    $trainer = auth()->user()->trainer;

    if (!$trainer) {
        return redirect('/trainer/dashboard')->with('error', 'You need to create a trainer profile first.');
    }

    $trainer->services()->create([
        'service_name' => $request->input('service_name'),
        'description' => $request->input('description'),
        'price' => $request->input('price'),
    ]);

    return redirect('/trainer/dashboard')->with('success', 'Service added successfully.');
}

    public function edit()
    {
        $trainer = auth()->user()->trainer;
        
        if (!$trainer) {
            return redirect()->route('trainer.dashboard')
                           ->with('error', 'You must create a trainer profile first.');
        }

        return view('trainers.edit', compact('trainer'));
    }

    public function update(Request $request)
    {
        $trainer = auth()->user()->trainer;
        
        if (!$trainer) {
            return redirect()->route('trainer.dashboard')
                           ->with('error', 'You must create a trainer profile first.');
        }

        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'bio' => 'required|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Handle profile picture update
        if ($request->hasFile('profile_picture')) {
            // Delete old profile picture if it exists
            if ($trainer->profile_picture) {
                Storage::disk('public')->delete($trainer->profile_picture);
            }
            
            $validated['profile_picture'] = $request->file('profile_picture')
                                                  ->store('profile-pictures', 'public');
        }

        $trainer->update($validated);

        return redirect()->route('trainer.dashboard')
                        ->with('success', 'Profile updated successfully.');
    }

    public function destroy()
    {
        $trainer = auth()->user()->trainer;
        
        if (!$trainer) {
            return redirect()->route('trainer.dashboard')
                           ->with('error', 'No trainer profile found.');
        }

        // Delete profile picture if it exists
        if ($trainer->profile_picture) {
            Storage::disk('public')->delete($trainer->profile_picture);
        }

        // Delete all associated services
        $trainer->services()->delete();

        // Delete the trainer profile
        $trainer->delete();

        return redirect()->route('dashboard')
                        ->with('success', 'Your trainer profile has been deleted successfully.');
    }

    // Show public trainer profile
    public function showProfile(Trainer $trainer)
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Please log in to view trainer profiles.');
        }

        $trainer->load(['user', 'services']);
        return view('trainers.profile', compact('trainer'));
    }
}
