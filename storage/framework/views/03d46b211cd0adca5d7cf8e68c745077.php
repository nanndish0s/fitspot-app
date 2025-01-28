<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('header', null, []); ?> 
        <div class="flex justify-center items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
                <?php echo e(__('Trainer Dashboard')); ?>

            </h2>
        </div>
     <?php $__env->endSlot(); ?>

    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="text-center mb-8">
            <p class="text-gray-600 mt-2">Manage your profile and services effortlessly.</p>
        </div>

        <?php if($trainer): ?>
        <!-- Profile Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <div class="flex items-start space-x-6">
                <div class="flex-shrink-0">
                    <div class="h-16 w-16 rounded-full overflow-hidden bg-gray-100">
                        <?php if($trainer->profile_picture): ?>
                            <img src="<?php echo e(Storage::url($trainer->profile_picture)); ?>" alt="Profile picture" class="h-full w-full object-cover">
                        <?php else: ?>
                            <img src="<?php echo e(asset('images/default-avatar.png')); ?>" alt="Default profile" class="h-full w-full object-cover">
                        <?php endif; ?>
                    </div>
                </div>
                <div class="flex-grow">
                    <div class="flex justify-between items-start">
                        <h2 class="text-xl font-semibold text-indigo-600 mb-4">Your Profile</h2>
                        <a href="<?php echo e(route('trainer.edit')); ?>" data-cy="edit-profile-button" 
                           class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md border border-black">
                            Edit Profile
                        </a>
                    </div>
                    <p class="text-gray-700">
                        <span class="font-medium">Specialization:</span> <?php echo e($trainer->specialization); ?><br>
                        <span class="font-medium">Bio:</span> <?php echo e($trainer->bio); ?>

                    </p>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-indigo-600 mb-4">Quick Actions</h2>
            <div class="flex space-x-4">
                <a href="<?php echo e(route('trainer.bookings')); ?>" 
                   class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md border border-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                    </svg>
                    View Bookings
                </a>
            </div>
        </div>

        <!-- Services Section -->
        <div class="bg-white shadow rounded-lg p-6 mb-6">
            <h2 class="text-xl font-semibold text-indigo-600 mb-4">Your Services</h2>
            <?php if($services->count()): ?>
            <ul class="divide-y divide-gray-200">
                <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li class="py-4">
                    <div class="flex justify-between items-start">
                        <div class="flex-grow flex gap-4">
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900"><?php echo e($service->service_name); ?></h3>
                                <p class="text-gray-600"><?php echo e(Str::limit($service->description, 100)); ?></p>
                            </div>
                        </div>
                        <div class="flex space-x-2">
                            <button data-cy="edit-service-button" class="edit-service-btn" data-service-id="<?php echo e($service->id); ?>"
                                    class="inline-flex items-center px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-black text-xs font-medium rounded-md border border-black">
                                Edit
                            </button>
                            <form action="<?php echo e(route('trainer.services.destroy', $service->id)); ?>" method="POST" onsubmit="return confirm('Are you sure you want to delete this service?');">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button data-cy="delete-service-button" type="submit" 
                                        class="inline-flex items-center px-3 py-1.5 bg-red-600 hover:bg-red-700 text-white text-xs font-medium rounded-md">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <?php else: ?>
            <p class="text-gray-600">You have not added any services yet.</p>
            <?php endif; ?>
        </div>

        <!-- Add New Service Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <form method="POST" action="<?php echo e(route('trainer.services.store')); ?>" class="mt-6 space-y-4" enctype="multipart/form-data">
                <?php echo csrf_field(); ?>
                <h3 class="text-lg font-semibold text-gray-700">Add a New Service</h3>
                <div class="flex flex-col gap-4">
                    <!-- Service Name -->
                    <div>
                        <label for="service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                        <input type="text" id="service_name" name="service_name" required 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="description" name="description" required rows="3"
                                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                    </div>

                    <!-- Price -->
                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Price (LKR)</label>
                        <input type="number" id="price" name="price" required step="0.01" min="0"
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700">Location</label>
                        <select id="location" name="location" required
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="">Select Location</option>
                            <option value="colombo">Colombo</option>
                            <option value="kandy">Kandy</option>
                            <option value="galle">Galle</option>
                            <option value="jaffna">Jaffna</option>
                            <option value="negombo">Negombo</option>
                            <option value="batticaloa">Batticaloa</option>
                            <option value="trincomalee">Trincomalee</option>
                            <option value="anuradhapura">Anuradhapura</option>
                            <option value="matara">Matara</option>
                            <option value="kurunegala">Kurunegala</option>
                        </select>
                    </div>

                    <!-- Latitude and Longitude (hidden fields) -->
                    <input type="hidden" id="latitude" name="latitude" value="0">
                    <input type="hidden" id="longitude" name="longitude" value="0">

                    <!-- Service Image -->
                    <div class="mb-4">
                        <label for="service_image" class="block text-gray-700 text-sm font-bold mb-2">Service Image</label>
                        <div class="flex items-center justify-center w-full">
                            <label for="service_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or GIF (MAX. 10MB)</p>
                                </div>
                                <input id="service_image" name="service_image" type="file" class="hidden" accept="image/png, image/jpeg, image/gif" />
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-black text-sm font-medium rounded-md border border-black">
                            Add Service
                        </button>
                    </div>
                </div>
            </form>
        </div>
        <?php else: ?>
        <!-- No Profile Section -->
        <div class="bg-yellow-100 border-l-4 border-yellow-400 text-yellow-700 p-4 rounded-lg">
            <p class="font-bold">You are not yet registered as a trainer.</p>
            <p>Please complete your trainer profile to access dashboard features.</p>
            <a href="<?php echo e(route('trainer.create')); ?>" class="mt-2 inline-block bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Create Trainer Profile
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- Edit Service Modal -->
    <div id="editServiceModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="editServiceModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editServiceModalLabel">Edit Service</h5>
                    <button type="button" class="close" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="editServiceForm" method="POST" action="" class="mt-6 space-y-4" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('PUT'); ?>
                        <input type="hidden" id="edit_service_id" name="service_id">
                        
                        <!-- Service Name -->
                        <div>
                            <label for="edit_service_name" class="block text-sm font-medium text-gray-700">Service Name</label>
                            <input type="text" id="edit_service_name" name="service_name" required 
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Description -->
                        <div>
                            <label for="edit_description" class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="edit_description" name="description" required rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"></textarea>
                        </div>

                        <!-- Price -->
                        <div>
                            <label for="edit_price" class="block text-sm font-medium text-gray-700">Price (LKR)</label>
                            <input type="number" id="edit_price" name="price" required step="0.01" min="0"
                                   class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                        </div>

                        <!-- Location -->
                        <div>
                            <label for="edit_location" class="block text-sm font-medium text-gray-700">Location</label>
                            <select id="edit_location" name="location" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="">Select Location</option>
                                <option value="colombo">Colombo</option>
                                <option value="kandy">Kandy</option>
                                <option value="galle">Galle</option>
                                <option value="jaffna">Jaffna</option>
                                <option value="negombo">Negombo</option>
                                <option value="batticaloa">Batticaloa</option>
                                <option value="trincomalee">Trincomalee</option>
                                <option value="anuradhapura">Anuradhapura</option>
                                <option value="matara">Matara</option>
                                <option value="kurunegala">Kurunegala</option>
                            </select>
                        </div>

                        <!-- Service Image -->
                        <div class="mb-4">
                            <label for="edit_service_image" class="block text-gray-700 text-sm font-bold mb-2">Service Image</label>
                            <div class="flex items-center justify-center w-full">
                                <label for="edit_service_image" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <svg aria-hidden="true" class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG, or GIF (MAX. 10MB)</p>
                                    </div>
                                    <input id="edit_service_image" name="service_image" type="file" class="hidden" accept="image/png, image/jpeg, image/gif" />
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" aria-label="Close">Close</button>
                    <button data-cy="save-changes" type="submit" form="editServiceForm" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <?php $__env->startPush('scripts'); ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const editServiceModal = document.getElementById('editServiceModal');
            const editServiceForm = document.getElementById('editServiceForm');
            const editButtons = document.querySelectorAll('.edit-service-btn');

            // Debug: Log elements
            console.log('Edit Service Modal:', editServiceModal);
            console.log('Edit Service Form:', editServiceForm);
            console.log('Edit Buttons:', editButtons);

            // Edit button click handler
            editButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const serviceId = this.getAttribute('data-service-id');
                    
                    // Debug: Log service ID
                    console.log('Clicked Service ID:', serviceId);
                    
                    // Fetch service details
                    fetch(`/trainer/services/${serviceId}`, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => {
                            console.log('Response Status:', response.status);
                            return response.json();
                        })
                        .then(data => {
                            // Debug: Log service details
                            console.log('Service Response:', data);

                            // Check if fetch was successful
                            if (!data.success) {
                                throw new Error(data.error || 'Failed to fetch service details');
                            }

                            const service = data.service;

                            // Get elements with null check and logging
                            const serviceIdEl = document.getElementById('edit_service_id');
                            const serviceNameEl = document.getElementById('edit_service_name');
                            const descriptionEl = document.getElementById('edit_description');
                            const priceEl = document.getElementById('edit_price');
                            const locationEl = document.getElementById('edit_location');

                            // Log each element
                            console.log('Service ID Element:', serviceIdEl);
                            console.log('Service Name Element:', serviceNameEl);
                            console.log('Description Element:', descriptionEl);
                            console.log('Price Element:', priceEl);
                            console.log('Location Element:', locationEl);

                            // Populate modal fields with null checks
                            if (serviceIdEl) serviceIdEl.value = service.id;
                            if (serviceNameEl) serviceNameEl.value = service.service_name;
                            if (descriptionEl) descriptionEl.value = service.description;
                            if (priceEl) priceEl.value = service.price;
                            if (locationEl) locationEl.value = service.location;

                            // Update form action
                            if (editServiceForm) {
                                editServiceForm.action = `/trainer/services/${serviceId}`;
                            }

                            // Show the modal using vanilla JavaScript
                            if (editServiceModal) {
                                editServiceModal.style.display = 'block';
                                document.body.classList.add('modal-open');
                                
                                // Create backdrop
                                const backdrop = document.createElement('div');
                                backdrop.classList.add('modal-backdrop', 'fade', 'show');
                                document.body.appendChild(backdrop);
                            }
                        })
                        .catch(error => {
                            console.error('Full Error:', error);
                            alert('Failed to load service details: ' + error.message);
                        });
                });
            });

            // Close modal button
            const closeModalButtons = editServiceModal.querySelectorAll('[aria-label="Close"]');
            closeModalButtons.forEach(button => {
                button.addEventListener('click', function() {
                    if (editServiceModal) {
                        editServiceModal.style.display = 'none';
                        document.body.classList.remove('modal-open');
                        
                        // Remove backdrop
                        const backdrop = document.querySelector('.modal-backdrop');
                        if (backdrop) {
                            backdrop.remove();
                        }
                    }
                });
            });

            // Form submission handler
            if (editServiceForm) {
                editServiceForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(editServiceForm);

                    fetch(editServiceForm.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(errorData => {
                                throw new Error(errorData.message || 'Failed to update service');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            // Close the modal using vanilla JavaScript
                            if (editServiceModal) {
                                editServiceModal.style.display = 'none';
                                document.body.classList.remove('modal-open');
                                
                                // Remove backdrop
                                const backdrop = document.querySelector('.modal-backdrop');
                                if (backdrop) {
                                    backdrop.remove();
                                }
                            }

                            // Update the service row in the table
                            const serviceRow = document.querySelector(`tr[data-service-id="${data.service.id}"]`);
                            if (serviceRow) {
                                serviceRow.querySelector('.service-name').textContent = data.service.service_name;
                                serviceRow.querySelector('.service-price').textContent = '$' + data.service.price;
                                serviceRow.querySelector('.service-location').textContent = data.service.location;
                            }

                            // Show success message
                            alert('Service updated successfully');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(error.message || 'Failed to update service');
                    });
                });
            }
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>

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
                    <li><a href="<?php echo e(route('services.index')); ?>" class="text-white-50">Services</a></li>
                    <li><a href="<?php echo e(route('products.index')); ?>" class="text-white-50">Products</a></li>
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
<?php /**PATH C:\Users\Nanndish\fitspot-app\resources\views/trainers/dashboard.blade.php ENDPATH**/ ?>