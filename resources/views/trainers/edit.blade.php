<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Trainer Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="container mx-auto px-4 py-8 max-w-2xl">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Your Profile</h1>

        <form method="POST" action="{{ route('trainer.update') }}" enctype="multipart/form-data" class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label for="profile_picture" class="block text-gray-700 text-sm font-bold mb-2">Profile Picture</label>
                <div class="mt-1 flex items-center">
                    <span class="inline-block h-32 w-32 rounded-full overflow-hidden bg-gray-100">
                        <img id="preview" 
                             src="{{ $trainer->profile_picture ? Storage::url($trainer->profile_picture) : asset('images/default-avatar.png') }}" 
                             alt="Profile preview" 
                             class="h-full w-full object-cover">
                    </span>
                    <label class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 cursor-pointer">
                        <span>Change</span>
                        <input type="file" id="profile_picture" name="profile_picture" class="hidden" accept="image/*" onchange="previewImage(event)">
                    </label>
                </div>
                @error('profile_picture')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label for="specialization" class="block text-gray-700 text-sm font-bold mb-2">Specialization</label>
                <input type="text" 
                       id="specialization" 
                       name="specialization" 
                       value="{{ old('specialization', $trainer->specialization) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('specialization') border-red-500 @enderror" 
                       required>
                @error('specialization')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- <div class="mb-6">
                <label for="hourly_rate" class="block text-gray-700 text-sm font-bold mb-2">Hourly Rate ($)</label>
                <input type="number" 
                       id="hourly_rate" 
                       name="hourly_rate" 
                       value="{{ old('hourly_rate', $trainer->hourly_rate) }}"
                       class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('hourly_rate') border-red-500 @enderror" 
                       required>
                @error('hourly_rate')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div> --}}

            <div class="mb-6">
                <label for="bio" class="block text-gray-700 text-sm font-bold mb-2">Bio</label>
                <textarea id="bio" 
                          name="bio" 
                          rows="4" 
                          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('bio') border-red-500 @enderror" 
                          required>{{ old('bio', $trainer->bio) }}</textarea>
                @error('bio')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between mt-6">
                <div class="flex items-center space-x-4">
                    <a href="{{ route('trainer.dashboard') }}" 
                       class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Cancel
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <button type="submit" 
                            class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                        Save Changes
                    </button>
                </div>
            </div>
        </form>

        <!-- Separate form for delete action -->
        <div class="mt-8 border-t pt-6">
            <h2 class="text-lg font-semibold text-red-600 mb-4">Danger Zone</h2>
            <p class="text-gray-600 mb-4">Once you delete your trainer profile, there is no going back. Please be certain.</p>
            <form action="{{ route('trainer.destroy') }}" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete your trainer profile? This will also delete all your services. This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                    Delete Profile
                </button>
            </form>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const preview = document.getElementById('preview');
                preview.src = reader.result;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>
