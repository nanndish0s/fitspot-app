<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                {{ __('My Bookings') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($bookings->isEmpty())
                        <p class="text-gray-500 text-center py-4">You don't have any bookings yet.</p>
                        <div class="text-center">
                            <a href="{{ route('services.index') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-black uppercase tracking-widest hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Browse Services
                            </a>
                        </div>
                    @else
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            @foreach($bookings as $booking)
                                <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200">
                                    <div class="mb-4">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            {{ $booking->service->service_name }}
                                        </h3>
                                        <p class="text-sm text-gray-600">with {{ $booking->trainer->user->name }}</p>
                                    </div>
                                    
                                    <div class="space-y-2">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Service:</span>
                                            <span class="text-gray-900">{{ $booking->service->service_name }} (LKR {{ $booking->service->price }})</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Date:</span>
                                            <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('M j, Y') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Time:</span>
                                            <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('g:i A') }}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Status:</span>
                                            <span class="
                                                @if($booking->status === 'confirmed') text-green-600
                                                @elseif($booking->status === 'cancelled') text-red-600
                                                @else text-yellow-600
                                                @endif font-medium">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        @if($booking->notes)
                                            <div class="mt-2">
                                                <p class="text-sm text-gray-600">Notes: {{ $booking->notes }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="mt-4 flex justify-between items-center">
                                        <a href="{{ route('bookings.show', $booking) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                            View Details
                                        </a>
                                        @if($booking->status !== 'cancelled')
                                            <form action="{{ route('bookings.cancel', $booking) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 text-sm font-medium"
                                                        onclick="return confirm('Are you sure you want to cancel this booking?')">
                                                    Cancel Booking
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<div class="bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h5>FitSpot</h5>
                <p>Your ultimate destination for fitness and wellness.</p>
            </div>
            <div class="col-md-4">
                <h5>Quick Links</h5>
                <ul class="list-unstyled">
                    <li><a href="{{ route('services.index') }}" class="text-white-50">Services</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-white-50">Products</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h5>Connect With Us</h5>
                <div class="social-links">
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-facebook"></i></a>
                    <a href="#" class="text-white-50 me-3"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-white-50"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <hr class="my-4 bg-white">
        <div class="text-center">
            <p>&copy; 2024 FitSpot. All Rights Reserved.</p>
        </div>
    </div>
</div>
