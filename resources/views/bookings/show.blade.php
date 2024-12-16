<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Booking Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Status Banner -->
                    <div class="mb-6 p-4 rounded-lg {{ $booking->status === 'confirmed' ? 'bg-green-100' : ($booking->status === 'cancelled' ? 'bg-red-100' : 'bg-yellow-100') }}">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                @if($booking->status === 'confirmed')
                                    <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                @elseif($booking->status === 'cancelled')
                                    <svg class="h-5 w-5 text-red-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                @else
                                    <svg class="h-5 w-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium {{ $booking->status === 'confirmed' ? 'text-green-800' : ($booking->status === 'cancelled' ? 'text-red-800' : 'text-yellow-800') }}">
                                    Status: {{ ucfirst($booking->status) }}
                                </h3>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Service Information -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Service Details</h3>
                                <p class="mt-1 text-gray-600">{{ $booking->service->service_name }}</p>
                                <p class="mt-1 text-gray-600">{{ $booking->service->description }}</p>
                                <p class="mt-2 font-medium">Price: <span class="text-indigo-600">${{ number_format($booking->service->price, 2) }}</span></p>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Trainer</h3>
                                <p class="mt-1 text-gray-600">{{ $booking->trainer->user->name }}</p>
                                <p class="mt-1 text-sm text-gray-600">{{ $booking->trainer->specialization }}</p>
                            </div>
                        </div>

                        <!-- Session Details -->
                        <div class="space-y-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Session Details</h3>
                                <p class="mt-1 text-gray-600">
                                    Date: {{ Carbon\Carbon::parse($booking->session_date)->format('l, F j, Y') }}
                                </p>
                                <p class="mt-1 text-gray-600">
                                    Time: {{ Carbon\Carbon::parse($booking->session_date)->format('g:i A') }}
                                </p>
                            </div>

                            @if($booking->notes)
                                <div>
                                    <h3 class="text-lg font-semibold text-gray-900">Notes</h3>
                                    <p class="mt-1 text-gray-600">{{ $booking->notes }}</p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="mt-8 flex justify-end">
                        @if($booking->status === 'pending' || $booking->status === 'confirmed')
                            <form method="POST" action="{{ route('bookings.cancel', $booking) }}">
                                @csrf
                                <x-danger-button type="submit" onclick="return confirm('Are you sure you want to cancel this booking?')">
                                    {{ __('Cancel Booking') }}
                                </x-danger-button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
