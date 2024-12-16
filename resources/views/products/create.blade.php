<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Product - FitSpot</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">

    <!-- Header -->
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

    <!-- Page Title -->
    <section class="bg-gray-800 text-white py-12 text-center">
        <h2 class="text-4xl font-bold">Add a New Product</h2>
        <p class="mt-2 text-lg">Fill in the details below to add a new product to the store</p>
    </section>

    <!-- Form Section -->
    <section class="container mx-auto py-12 px-4">
        <div class="max-w-lg mx-auto bg-white p-8 rounded-lg shadow-md">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Product Name</label>
                    <input type="text" name="name" id="name" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"></textarea>
                </div>

                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                    <input type="number" name="price" id="price" step="0.01" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label for="quantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                    <input type="number" name="quantity" id="quantity" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
                    <input type="file" name="image" id="image" class="mt-1 block w-full text-gray-900 border-gray-300 rounded-md shadow-sm focus:border-green-500 focus:ring-green-500">
                </div>

                <div class="text-center">
                    <button type="submit" class="bg-green-500 text-white py-2 px-6 rounded hover:bg-green-600 focus:outline-none focus:ring focus:ring-green-300">Add Product</button>
                </div>
            </form>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2024 FitSpot. All rights reserved.</p>
    </footer>

</body>
</html>
    