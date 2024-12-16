@push('styles')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush

@include('components.navbar')

<x-services-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manage Bookings') }}
            </h2>
            <a href="{{ route('trainer.dashboard') }}" class="text-indigo-600 hover:text-indigo-900">Back to Dashboard</a>
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
                    @else
                        <!-- Pending Bookings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Pending Bookings</h3>
                            @if(isset($bookings['pending']) && $bookings['pending']->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($bookings['pending'] as $booking)
                                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200 bg-yellow-50">
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    {{ $booking->service->service_name }}
                                                </h4>
                                                <p class="text-sm text-gray-600">Client: {{ $booking->user->name }}</p>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Date:</span>
                                                    <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('M j, Y') }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Time:</span>
                                                    <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('g:i A') }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Service Price:</span>
                                                    <span class="text-gray-900">LKR {{ $booking->service->price }}</span>
                                                </div>
                                                @if($booking->notes)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600">Notes: {{ $booking->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="mt-4 flex justify-between items-center space-x-2">
                                                <form action="{{ route('trainer.bookings.accept', $booking) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 focus:bg-green-700 active:bg-green-900 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Accept
                                                    </button>
                                                </form>
                                                <form action="{{ route('trainer.bookings.decline', $booking) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    <button type="submit" 
                                                            class="w-full inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 focus:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                                        Decline
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No pending bookings.</p>
                            @endif
                        </div>

                        <!-- Confirmed Bookings -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Confirmed Bookings</h3>
                            @if(isset($bookings['confirmed']) && $bookings['confirmed']->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($bookings['confirmed'] as $booking)
                                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200 bg-green-50">
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    {{ $booking->service->service_name }}
                                                </h4>
                                                <p class="text-sm text-gray-600">Client: {{ $booking->user->name }}</p>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Date:</span>
                                                    <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('M j, Y') }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Time:</span>
                                                    <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('g:i A') }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Service Price:</span>
                                                    <span class="text-gray-900">LKR {{ $booking->service->price }}</span>
                                                </div>
                                                @if($booking->notes)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600">Notes: {{ $booking->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No confirmed bookings.</p>
                            @endif
                        </div>

                        <!-- Cancelled Bookings -->
                        <div>
                            <div class="flex justify-between items-center mb-4">
                                <h3 class="text-lg font-semibold text-gray-900">Cancelled Bookings</h3>
                                @if(isset($bookings['cancelled']) && $bookings['cancelled']->count() > 0)
                                    <form action="{{ route('trainer.bookings.clear-cancelled') }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 transition ease-in-out duration-150"
                                                onclick="return confirm('Are you sure you want to clear all cancelled bookings? This action cannot be undone.')">
                                            Clear Cancelled Bookings
                                        </button>
                                    </form>
                                @endif
                            </div>
                            @if(isset($bookings['cancelled']) && $bookings['cancelled']->count() > 0)
                                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                    @foreach($bookings['cancelled'] as $booking)
                                        <div class="border rounded-lg p-4 shadow hover:shadow-md transition-shadow duration-200 bg-red-50">
                                            <div class="mb-4">
                                                <h4 class="text-lg font-semibold text-gray-900">
                                                    {{ $booking->service->service_name }}
                                                </h4>
                                                <p class="text-sm text-gray-600">Client: {{ $booking->user->name }}</p>
                                            </div>
                                            
                                            <div class="space-y-2">
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Date:</span>
                                                    <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('M j, Y') }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Time:</span>
                                                    <span class="text-gray-900">{{ Carbon\Carbon::parse($booking->session_date)->format('g:i A') }}</span>
                                                </div>
                                                <div class="flex justify-between">
                                                    <span class="text-gray-600">Service Price:</span>
                                                    <span class="text-gray-900">LKR {{ $booking->service->price }}</span>
                                                </div>
                                                @if($booking->notes)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600">Notes: {{ $booking->notes }}</p>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-500">No cancelled bookings.</p>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-services-layout>
