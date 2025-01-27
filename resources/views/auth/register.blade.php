<x-guest-layout>
    <div class="min-h-screen bg-gray-100 py-6 flex flex-col justify-center sm:py-12">
        <div class="relative py-3 sm:max-w-xl sm:mx-auto">
            <div class="absolute inset-0 bg-gradient-to-r from-green-400 to-blue-500 shadow-lg transform -skew-y-6 sm:skew-y-0 sm:-rotate-6 sm:rounded-3xl"></div>
            <div class="relative px-4 py-10 bg-white shadow-lg sm:rounded-3xl sm:p-20">
                <div class="max-w-md mx-auto">
                    <div class="text-center mb-8">
                        <h1 class="text-4xl font-extrabold text-gray-800 mb-2">Welcome to FitSpot</h1>
                        <p class="text-lg text-gray-600">Your fitness journey starts here!</p>
                    </div>

                    <form method="POST" action="{{ route('register') }}" class="space-y-6">
                        @csrf

                        <!-- Name -->
                        <div>
                            <x-input-label for="name" :value="__('Full Name')" class="text-sm font-bold text-gray-600 block" />
                            <x-text-input 
                                id="name" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-green-500 focus:bg-white focus:outline-none" 
                                type="text" 
                                name="name" 
                                :value="old('name')" 
                                required 
                                autofocus 
                                autocomplete="name" 
                                placeholder="Enter your full name"
                            />
                            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-500" />
                        </div>

                        <!-- Email Address -->
                        <div>
                            <x-input-label for="email" :value="__('Email Address')" class="text-sm font-bold text-gray-600 block" />
                            <x-text-input 
                                id="email" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-green-500 focus:bg-white focus:outline-none" 
                                type="email" 
                                name="email" 
                                :value="old('email')" 
                                required 
                                autocomplete="username" 
                                placeholder="Enter your email"
                            />
                            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-500" />
                        </div>

                        <!-- Role -->
                        <div>
                            <x-input-label for="role" :value="__('Select Your Role')" class="text-sm font-bold text-gray-600 block" />
                            <div class="mt-2">
                                <select 
                                    name="role" 
                                    id="role" 
                                    class="w-full px-4 py-3 rounded-lg bg-gray-200 border focus:border-green-500 focus:outline-none"
                                    required
                                >
                                    <option value="" disabled selected>Choose your role</option>
                                    <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Fitness Enthusiast</option>
                                    <option value="trainer" {{ old('role') == 'trainer' ? 'selected' : '' }}>Fitness Trainer</option>
                                    <option value="seller" {{ old('role') == 'seller' ? 'selected' : '' }}>Fitness Gear Seller</option>
                                </select>
                            </div>
                            <x-input-error :messages="$errors->get('role')" class="mt-2 text-red-500" />
                        </div>

                        <!-- Password -->
                        <div>
                            <x-input-label for="password" :value="__('Password')" class="text-sm font-bold text-gray-600 block" />
                            <x-text-input 
                                id="password" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-green-500 focus:bg-white focus:outline-none" 
                                type="password"
                                name="password"
                                required 
                                autocomplete="new-password" 
                                placeholder="Create a strong password"
                            />
                            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-500" />
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-bold text-gray-600 block" />
                            <x-text-input 
                                id="password_confirmation" 
                                class="w-full px-4 py-3 rounded-lg bg-gray-200 mt-2 border focus:border-green-500 focus:bg-white focus:outline-none" 
                                type="password"
                                name="password_confirmation" 
                                required 
                                autocomplete="new-password" 
                                placeholder="Confirm your password"
                            />
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-500" />
                        </div>

                        <div>
                            <x-primary-button class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                {{ __('Create Your Account') }}
                            </x-primary-button>
                        </div>

                        <div class="mt-6 text-center">
                            <p class="text-sm text-gray-600">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="font-medium text-green-600 hover:text-green-500">
                                    Log in
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>
