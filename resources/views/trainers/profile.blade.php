<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition duration-300 group">
                    <svg class="w-5 h-5 mr-2 text-indigo-500 group-hover:-translate-x-1 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Services
                </a>
                <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                    {{ $trainer->user->name }}'s Profile
                </h2>
            </div>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white/90 backdrop-blur-lg shadow-2xl rounded-3xl overflow-hidden border border-gray-100 transform transition-all duration-300 hover:shadow-3xl">
                <div class="p-8 md:p-12">
                    <!-- Trainer Info Section -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center">
                        <!-- Profile Picture -->
                        <div class="flex justify-center md:justify-start">
                            @if($trainer->profile_picture)
                                <img src="{{ Storage::url($trainer->profile_picture) }}" 
                                     alt="{{ $trainer->user->name }}" 
                                     class="w-48 h-48 rounded-full object-cover shadow-2xl border-4 border-white transform transition-transform duration-300 hover:scale-105">
                            @else
                                <div class="w-48 h-48 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center shadow-2xl">
                                    <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Trainer Details -->
                        <div class="md:col-span-2 text-center md:text-left space-y-4">
                            <h3 class="text-4xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">
                                {{ $trainer->user->name }}
                            </h3>
                            <div class="text-gray-700 space-y-2">
                                <p class="text-lg">
                                    <span class="font-semibold text-indigo-600">Specialization:</span> 
                                    <span class="inline-block px-3 py-1 bg-indigo-50 text-indigo-700 rounded-full text-sm ml-2">
                                        {{ $trainer->specialization }}
                                    </span>
                                </p>
                                <p class="text-base italic text-gray-600 max-w-2xl">
                                    <span class="font-semibold text-indigo-600 not-italic">Bio:</span> 
                                    {{ $trainer->bio }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div class="mt-16">
                        <h3 class="text-2xl font-bold text-gray-900 mb-8 text-center md:text-left">Available Services</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            @foreach($trainer->services as $service)
                                <div class="bg-white rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2 border border-gray-100 overflow-hidden">
                                    <div class="p-6 space-y-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <div class="text-xl font-bold text-gray-900 mb-2">{{ $service->service_name }}</div>
                                                <p class="text-gray-600 text-sm">{{ $service->description }}</p>
                                            </div>
                                            <div class="text-xl font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                                                LKR {{ number_format($service->price, 2) }}
                                            </div>
                                        </div>
                                        @auth
                                            <div class="flex justify-end space-x-4 mt-4">
                                                <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                                                   class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center space-x-2 text-sm font-medium">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Book Service</span>
                                                </a>
                                                <button data-test="chat-with-trainer" x-data x-on:click="$dispatch('open-chat', { trainerId: {{ $trainer->user->id }} })"
                                                   class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 flex items-center space-x-2 text-sm font-medium">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                    <span>Chat with Trainer</span>
                                                </button>
                                            </div>
                                        @else
                                            <div class="flex justify-end space-x-4 mt-4">
                                                <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                                                   class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center space-x-2 text-sm font-medium">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <span>Book Service</span>
                                                </a>
                                                <button x-data x-on:click="$dispatch('open-chat', { trainerId: {{ $trainer->user->id }} })"
                                                   class="px-5 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition duration-300 flex items-center space-x-2 text-sm font-medium">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                                    </svg>
                                                    <span>Chat with Trainer</span>
                                                </button>
                                            </div>
                                        @endauth
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
