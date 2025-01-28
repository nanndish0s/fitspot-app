<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful - FitSpot</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <header class="bg-green-500 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">FitSpot</h1>
            <nav>
                <a href="/" class="text-white px-4 py-2 hover:bg-green-600 rounded">Home</a>
                <a href="/products" class="text-white px-4 py-2 hover:bg-green-600 rounded">Products</a>
                <a href="/cart" class="text-white px-4 py-2 hover:bg-green-600 rounded">Cart</a>
            </nav>
        </div>
    </header>

    <!-- Success Message -->
    <div class="container mx-auto py-20 px-4 text-center">
        <div class="bg-white rounded-lg shadow-md p-8 max-w-2xl mx-auto">
            <div class="text-green-500 mb-4">
                <svg class="w-20 h-20 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-bold mb-4">Payment Successful!</h2>
            <p class="text-gray-600 mb-8">Thank you for your purchase. Your order has been confirmed.</p>
            <a href="/" class="bg-green-500 text-white px-8 py-3 rounded-lg text-xl font-semibold hover:bg-green-600 transition duration-300">
                Continue Shopping
            </a>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\Users\Nanndish\Desktop\Sprint 3\fitspot-app\resources\views/checkout/success.blade.php ENDPATH**/ ?>