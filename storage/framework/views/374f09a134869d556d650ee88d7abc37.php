<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Payments - FitSpot</title>
    <!-- Add Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.1.2/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-900">
    <!-- Navbar -->
    <header class="bg-green-500 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-3xl font-bold">FitSpot Trainer Payments</h1>
            <nav>
                <a href="/" class="text-white px-4 py-2 hover:bg-green-600 rounded">Home</a>
                <a href="/trainer/dashboard" class="text-white px-4 py-2 hover:bg-green-600 rounded">Dashboard</a>
                <a href="/trainer/payments" class="text-white px-4 py-2 hover:bg-green-600 rounded">Payments</a>
            </nav>
        </div>
    </header>

    <!-- Page Title Section -->
    <section class="bg-gray-800 text-white text-center py-20">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold">Your Payment History</h2>
            <p class="mt-4 text-xl">Total Earnings: LKR <?php echo e(number_format($totalEarnings, 2)); ?></p>
        </div>
    </section>

    <!-- Payments Section -->
    <section class="container mx-auto py-20 px-4">
        <?php if($bookings->isEmpty()): ?>
            <p class="text-center text-xl">No payment history found.</p>
        <?php else: ?>
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Client</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Service</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo e($booking->created_at->format('F d, Y')); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo e($booking->user->name); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo e($booking->service->name); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    LKR <?php echo e(number_format($booking->total_amount, 2)); ?>

                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="<?php echo e(route('trainer.payment.show', $booking)); ?>" 
                                       class="text-green-600 hover:text-green-900">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-4 text-center">
        <p>&copy; 2024 FitSpot. All rights reserved.</p>
    </footer>
</body>
</html>
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/trainer/payments.blade.php ENDPATH**/ ?>