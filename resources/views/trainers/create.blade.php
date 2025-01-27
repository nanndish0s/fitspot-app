<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-white py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto bg-white shadow-2xl rounded-2xl overflow-hidden">
            <div class="bg-gradient-to-r from-indigo-600 to-purple-700 text-white p-6 sm:p-10">
                <div class="flex items-center">
                    <svg class="w-12 h-12 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <h1 class="text-3xl font-bold tracking-tight">Create Your Trainer Profile</h1>
                </div>
                <p class="mt-2 text-indigo-100">
                    Share your expertise and connect with fitness enthusiasts
                </p>
            </div>

            <form method="POST" action="{{ route('trainer.store') }}" enctype="multipart/form-data" class="p-6 sm:p-10 space-y-8">
                @csrf

                <!-- Profile Picture Upload -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 items-center">
                    <div class="md:col-span-1">
                        <label class="block text-sm font-medium text-gray-700">Profile Picture</label>
                        <p class="text-xs text-gray-500 mt-1">JPG or PNG, max 5MB</p>
                    </div>
                    <div class="md:col-span-2 flex items-center space-x-6">
                        <div class="shrink-0">
                            <img id="preview" 
                                 class="h-24 w-24 object-cover rounded-full shadow-md" 
                                 src="{{ asset('images/default-avatar.png') }}" 
                                 alt="Profile preview" />
                        </div>
                        <label class="block">
                            <span class="sr-only">Choose profile photo</span>
                            <input type="file" 
                                   id="profile_picture" 
                                   name="profile_picture" 
                                   accept="image/*" 
                                   onchange="previewImage(event)"
                                   class="block w-full text-sm text-slate-500
                                          file:mr-4 file:py-2 file:px-4
                                          file:rounded-full file:border-0
                                          file:text-sm file:font-semibold
                                          file:bg-indigo-50 file:text-indigo-700
                                          hover:file:bg-indigo-100" />
                        </label>
                    </div>
                    @error('profile_picture')
                        <p class="text-red-500 text-xs mt-1 md:col-span-3">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Specialization Input -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="specialization" class="block text-sm font-medium text-gray-700">
                            Specialization
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Your primary fitness expertise</p>
                    </div>
                    <div class="md:col-span-2">
                        <input type="text" 
                               id="specialization" 
                               name="specialization" 
                               placeholder="e.g., Weight Training, Yoga, HIIT" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('specialization') border-red-500 @enderror" 
                               required />
                        @error('specialization')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Bio Textarea -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="md:col-span-1">
                        <label for="bio" class="block text-sm font-medium text-gray-700">
                            Professional Bio
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Tell us about your fitness journey</p>
                    </div>
                    <div class="md:col-span-2">
                        <textarea 
                            id="bio" 
                            name="bio" 
                            rows="4" 
                            placeholder="Share your training philosophy, achievements, and what motivates you" 
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 @error('bio') border-red-500 @enderror" 
                            required></textarea>
                        @error('bio')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="flex justify-end">
                    <button 
                        type="submit" 
                        class="bg-indigo-600 text-white px-6 py-3 rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors duration-300 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Create Trainer Profile
                    </button>
                </div>
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
</x-app-layout>
