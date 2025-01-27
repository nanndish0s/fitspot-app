<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FitSpot') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <!-- Additional Styles -->
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            <x-navbar />

            <!-- Page Heading -->
            @if (isset($header))
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif

            <!-- Page Content -->
            <main>
                @if (isset($slot))
                    {{ $slot }}
                @else
                    @yield('content')
                @endif
            </main>
        </div>

        <!-- Bootstrap JS and dependencies -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var dropdownToggle = document.querySelector('.dropdown-toggle');
                if (dropdownToggle) {
                    dropdownToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        var dropdown = this.nextElementSibling;
                        dropdown.classList.toggle('show');
                        this.setAttribute('aria-expanded', this.getAttribute('aria-expanded') === 'false' ? 'true' : 'false');
                    });
                }
            });
        </script>

        <!-- Global Chat Modal -->
        <div 
            x-data="chatModal()" 
            x-show="isOpen" 
            x-cloak 
            class="fixed inset-0 z-50 overflow-y-auto"
            x-on:open-chat.window="openChat($event.detail)"
        >
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div 
                    x-show="isOpen"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0"
                    x-transition:enter-end="opacity-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100"
                    x-transition:leave-end="opacity-0"
                    class="fixed inset-0 transition-opacity"
                >
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <div 
                    x-show="isOpen"
                    x-transition:enter="ease-out duration-300"
                    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave="ease-in duration-200"
                    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                >
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="chat-modal-title">
                                    Chat
                                </h3>
                                <div class="mt-2 h-96 overflow-y-auto" id="chat-messages">
                                    <!-- Chat messages will be dynamically loaded here -->
                                </div>
                                <div class="mt-4 flex">
                                    <input 
                                        type="text" 
                                        x-model="newMessage" 
                                        @keyup.enter="sendMessage"
                                        class="flex-grow mr-2 p-2 border rounded-md"
                                        placeholder="Type your message..."
                                    >
                                    <button 
                                        @click="sendMessage"
                                        class="bg-green-500 text-white px-4 py-2 rounded-md hover:bg-green-600"
                                    >
                                        Send
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            type="button" 
                            @click="closeChat"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>

        @push('scripts')
        <script>
            function chatModal() {
                return {
                    isOpen: false,
                    chatPartnerId: null,
                    newMessage: '',
                    messages: [],

                    openChat(details) {
                        console.log('Open chat details:', details);
                        this.chatPartnerId = details.userId || details.trainerId;
                        this.isOpen = true;
                        this.loadMessages();
                    },

                    async loadMessages() {
                        try {
                            console.log('Loading messages for user ID:', this.chatPartnerId);
                            const response = await axios.get(`/api/chat/conversation/${this.chatPartnerId}`);
                            this.messages = response.data;
                            this.renderMessages();
                        } catch (error) {
                            console.error('Error loading messages:', error);
                            if (error.response && error.response.status === 401) {
                                alert('Please log in to view messages');
                                window.location.href = '/login'; // Redirect to login page
                            } else {
                                alert('Failed to load messages: ' + error.response?.data?.message || error.message);
                            }
                        }
                    },

                    renderMessages() {
                        const messagesContainer = document.getElementById('chat-messages');
                        messagesContainer.innerHTML = this.messages.map(msg => `
                            <div class="mb-2 p-2 ${msg.sender_id === {{ auth()->id() }} ? 'text-right bg-blue-100' : 'text-left bg-gray-100'} rounded-md">
                                <p>${msg.message}</p>
                                <small class="text-xs text-gray-500">${new Date(msg.created_at).toLocaleString()}</small>
                            </div>
                        `).join('');
                        messagesContainer.scrollTop = messagesContainer.scrollHeight;
                    },

                    async sendMessage() {
                        if (!this.newMessage.trim()) return;

                        try {
                            console.log('Sending message to user ID:', this.chatPartnerId);
                            const response = await axios.post('/api/chat/send', {
                                receiver_id: this.chatPartnerId,
                                message: this.newMessage
                            });

                            this.messages.push(response.data.chat_message);
                            this.renderMessages();
                            this.newMessage = '';
                        } catch (error) {
                            console.error('Error sending message:', error);
                            if (error.response && error.response.status === 401) {
                                alert('Please log in to send messages');
                                window.location.href = '/login'; // Redirect to login page
                            } else {
                                alert('Failed to send message: ' + error.response?.data?.message || error.message);
                            }
                        }
                    },

                    closeChat() {
                        this.isOpen = false;
                        this.chatPartnerId = null;
                        this.messages = [];
                    }
                }
            }
        </script>
        @endpush

        @stack('scripts')
    </body>
</html>