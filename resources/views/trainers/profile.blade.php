<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $trainer->user->name }}'s Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Trainer Info Section -->
                    <div class="flex flex-col md:flex-row justify-center text-center">
                        <!-- Profile Picture -->
                        <div class="md:w-1/3 mb-6 md:mb-0 flex justify-center">
                            @if($trainer->profile_picture)
                                <img src="{{ Storage::url($trainer->profile_picture) }}" 
                                     alt="{{ $trainer->user->name }}" 
                                     class="w-16 h-16 rounded-full shadow-lg object-cover">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center">
                                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- Trainer Details -->
                        <div class="md:w-2/3 md:pl-8">
                            <h3 class="text-2xl font-bold text-gray-900">{{ $trainer->user->name }}</h3>
                            <div class="text-gray-700">
                                <p><span class="font-semibold">Specialization:</span> {{ $trainer->specialization }}</p>
                                <p><span class="font-semibold">Bio:</span> {{ $trainer->bio }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Services Section -->
                    <div class="mt-12">
                        <h3 class="text-xl font-semibold text-gray-900 mb-6">Available Services</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($trainer->services as $service)
                                <div class="border rounded-lg p-4 hover:shadow-md transition-shadow duration-200">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <div class="text-lg font-semibold text-gray-900">{{ $service->service_name }}</div>
                                            <p class="mt-2 text-gray-600">{{ $service->description }}</p>
                                        </div>
                                        <div class="text-lg font-bold text-indigo-600">
                                            LKR {{ number_format($service->price, 2) }}
                                        </div>
                                    </div>
                                    @auth
                                        <div class="mt-4 text-right flex justify-end space-x-4">
                                            <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Book This Service
                                            </a>
                                            <button data-test="chat-with-trainer" x-data x-on:click="$dispatch('open-chat', { trainerId: {{ $trainer->user->id }} })"
                                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Chat with Trainer
                                            </button>
                                        </div>
                                    @else
                                        <div class="mt-4 text-right flex justify-end space-x-4">
                                            <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                                               class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Book This Service
                                            </a>
                                            <button x-data x-on:click="$dispatch('open-chat', { trainerId: {{ $trainer->user->id }} })"
                                               class="inline-flex items-center px-4 py-2 bg-green-600 border border-black rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                Chat with Trainer
                                            </button>
                                        </div>
                                    @endauth
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
