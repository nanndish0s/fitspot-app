<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Book Session') }}</h2>
            <div class="space-x-4">
                <a href="{{ route('services.index') }}" class="text-indigo-600 hover:text-indigo-900">Back to Services</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Service Details</h3>
                        <div class="mt-2">
                            <p><span class="font-medium">Service:</span> {{ $service->service_name }}</p>
                            <p><span class="font-medium">Trainer:</span> {{ $service->trainer->user->name }}</p>
                            <p><span class="font-medium">Price:</span> LKR {{ $service->price }}</p>
                            <p><span class="font-medium">Description:</span> {{ $service->description }}</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('bookings.store') }}" class="space-y-6" id="payment-form">
                        @csrf
                        <input type="hidden" name="service_id" value="{{ $service->id }}">
                        <input type="hidden" name="payment_intent_id" id="payment-intent-id">
                        
                        <!-- Session Date -->
                        <div>
                            <x-input-label for="session_date" :value="__('Preferred Session Date')" />
                            <div class="relative">
                                <input type="text" id="session_date_display" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Select date" readonly>
                                <input type="hidden" id="session_date" name="session_date" required>
                            </div>
                            <x-input-error class="mt-2" :messages="$errors->get('session_date')" />
                        </div>

                        <!-- Payment Section -->
                        <div class="mt-6">
                            <h4 class="text-lg font-medium text-gray-900">Payment Details</h4>
                            <div class="mt-4">
                                <div id="payment-element"></div>
                                <div id="payment-message" class="mt-2 text-red-600" role="alert"></div>
                            </div>
                        </div>

                        <!-- Notes -->
                        <div>
                            <x-input-label for="notes" :value="__('Additional Notes')" />
                            <textarea id="notes" name="notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></textarea>
                            <x-input-error class="mt-2" :messages="$errors->get('notes')" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button id="submit-button" class="ml-4">
                                {{ __('Book Session') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        .flatpickr-calendar {
            background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        .flatpickr-day.selected {
            background: #4f46e5 !important;
            border-color: #4f46e5 !important;
        }
        .flatpickr-day:hover {
            background: #f3f4f6;
        }
        .flatpickr-day.today {
            border-color: #4f46e5;
        }
    </style>
    @endpush

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialize date picker
            flatpickr("#session_date_display", {
                enableTime: true,
                dateFormat: "Y-m-d H:i",
                minDate: "today",
                time_24hr: false,
                minuteIncrement: 30,
                defaultHour: 9,
                minTime: "06:00",
                maxTime: "22:00",
                onChange: function(selectedDates, dateStr) {
                    document.getElementById('session_date').value = dateStr;
                }
            });

            // Initialize Stripe
            const stripe = Stripe('{{ config('services.stripe.key') }}');
            const clientSecret = '{{ $clientSecret }}';

            const options = {
                clientSecret: clientSecret,
                appearance: {
                    theme: 'stripe',
                },
            };

            // Create payment element
            const elements = stripe.elements(options);
            const paymentElement = elements.create('payment');
            paymentElement.mount('#payment-element');

            // Handle form submission
            const form = document.getElementById('payment-form');
            const submitButton = document.getElementById('submit-button');
            const paymentMessage = document.getElementById('payment-message');

            form.addEventListener('submit', async (event) => {
                event.preventDefault();

                // Validate the session date
                const sessionDate = document.getElementById('session_date').value;
                if (!sessionDate) {
                    paymentMessage.textContent = 'Please select a session date';
                    return;
                }
                
                // Disable submit button and show loading state
                submitButton.disabled = true;
                submitButton.textContent = 'Processing...';
                paymentMessage.textContent = '';
                
                try {
                    // Submit the form data first
                    const formData = new FormData(form);
                    const response = await fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    });

                    if (!response.ok) {
                        throw new Error('Failed to submit booking details');
                    }

                    // Confirm the payment
                    const {error} = await stripe.confirmPayment({
                        elements,
                        confirmParams: {
                            return_url: window.location.origin + '/bookings/payment-complete',
                        }
                    });

                    if (error) {
                        throw error;
                    }
                } catch (error) {
                    paymentMessage.textContent = error.message;
                    submitButton.disabled = false;
                    submitButton.textContent = 'Book Session';
                }
            });
        });
    </script>
    @endpush
</x-app-layout>

<footer class="bg-dark text-white py-5">
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
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
