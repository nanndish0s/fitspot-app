<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 text-indigo-700 rounded-lg hover:bg-indigo-100 transition duration-300 group">
                <svg class="w-5 h-5 mr-2 text-indigo-500 group-hover:-translate-x-1 transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Services
            </a>
            <h2 class="font-bold text-2xl text-gray-900 tracking-tight">
                {{ $service->service_name }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-indigo-50 via-purple-50 to-white min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Service Details Column -->
                <div class="md:col-span-2 space-y-8">
                    <!-- Service Card -->
                    <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border border-gray-100">
                        <div class="flex flex-col md:flex-row items-start space-y-4 md:space-y-0 md:space-x-6">
                            <!-- Service Image -->
                            <div class="w-full md:w-1/3">
                                @if($service->image)
                                    <img src="{{ Storage::url($service->image) }}" 
                                         alt="{{ $service->service_name }}" 
                                         class="w-full h-64 object-cover rounded-2xl shadow-lg">
                                @else
                                    <div class="w-full h-64 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-2xl flex items-center justify-center">
                                        <svg class="w-24 h-24 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <!-- Service Info -->
                            <div class="w-full md:w-2/3 space-y-4">
                                <div>
                                    <h3 class="text-3xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600 mb-2">
                                        {{ $service->service_name }}
                                    </h3>
                                    <div class="flex items-center space-x-4 mb-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700">
                                            {{ $service->trainer->specialization }}
                                        </span>
                                        <span class="text-lg font-bold text-indigo-600 bg-indigo-50 px-3 py-1 rounded-full">
                                            LKR {{ number_format($service->price, 2) }}
                                        </span>
                                    </div>
                                </div>
                                
                                <p class="text-gray-600 leading-relaxed">
                                    {{ $service->description }}
                                </p>

                                <div class="flex space-x-4 mt-6">
                                    <a href="{{ route('bookings.create', ['service_id' => $service->id]) }}" 
                                       class="px-6 py-3 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition duration-300 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span>Book Service</span>
                                    </a>
                                    <a href="{{ route('trainers.profile', ['trainer' => $service->trainer->id]) }}" 
                                       class="px-6 py-3 bg-purple-50 text-purple-700 rounded-lg hover:bg-purple-100 transition duration-300 flex items-center space-x-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span>View Trainer Profile</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Trainer Info -->
                    <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-8 border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">About the Trainer</h3>
                        <div class="flex items-center space-x-6">
                            @if($service->trainer->profile_picture)
                                <img src="{{ Storage::url($service->trainer->profile_picture) }}" 
                                     alt="{{ $service->trainer->user->name }}" 
                                     class="w-24 h-24 rounded-full object-cover shadow-lg">
                            @else
                                <div class="w-24 h-24 bg-gradient-to-br from-indigo-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <h4 class="text-xl font-bold text-indigo-600">{{ $service->trainer->user->name }}</h4>
                                <p class="text-gray-600">{{ $service->trainer->bio }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Services Column -->
                <div>
                    <div class="bg-white/90 backdrop-blur-lg rounded-3xl shadow-2xl p-6 border border-gray-100">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Related Services</h3>
                        @if($relatedServices->count() > 0)
                            <div class="space-y-6">
                                @foreach($relatedServices as $relatedService)
                                    <div class="bg-indigo-50 rounded-2xl p-4 hover:bg-indigo-100 transition duration-300">
                                        <a href="{{ route('services.show', $relatedService) }}" class="block">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <h4 class="text-lg font-semibold text-gray-900">{{ $relatedService->service_name }}</h4>
                                                    <p class="text-sm text-gray-600">{{ $relatedService->trainer->specialization }}</p>
                                                </div>
                                                <span class="text-indigo-600 font-bold">
                                                    LKR {{ number_format($relatedService->price, 2) }}
                                                </span>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500 text-center">No related services found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
