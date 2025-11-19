<?php if (isset($component)) { $__componentOriginal91fdd17964e43374ae18c674f95cdaa3 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3 = $attributes; } ?>
<?php $component = App\View\Components\AdminLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('admin-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AdminLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="container mx-auto mt-6">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold">Manage Vans</h2>
            <a href="<?php echo e(route('admin.vans.create')); ?>"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">+ Add New Van</a>
        </div>

        <?php if(session('success')): ?>
            <div class="mb-4 bg-green-100 text-green-800 px-4 py-2 rounded">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-medium">ID</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Image</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Model</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Seats</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Price/Day ($)</th>
                        <th class="px-6 py-3 text-left text-sm font-medium">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $vans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $van): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-100 transition">
                        <td class="px-6 py-4"><?php echo e($van->id); ?></td>
                        <td class="px-6 py-4 flex items-center">
                            <?php if($van->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($van->image)): ?>
                                <img src="<?php echo e(\Illuminate\Support\Facades\Storage::url($van->image)); ?>"
                                     alt="<?php echo e($van->name); ?>" class="h-16 w-24 object-cover rounded">
                            <?php else: ?>
                                <span class="text-red-600 font-bold mr-2">⚠</span>
                                <span class="text-gray-500 text-sm">No Image</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4"><?php echo e($van->name); ?></td>
                        <td class="px-6 py-4"><?php echo e($van->model); ?></td>
                        <td class="px-6 py-4"><?php echo e($van->seats); ?></td>
                        <td class="px-6 py-4"><?php echo e($van->price_per_day); ?></td>
                        <td class="px-6 py-4 space-x-2">
                            <a href="<?php echo e(route('admin.vans.edit', $van->id)); ?>"
                               class="text-yellow-600 hover:text-yellow-800">Edit</a>
                            <form action="<?php echo e(route('admin.vans.destroy', $van->id)); ?>" method="POST" class="inline">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="text-red-600 hover:text-red-800"
                                        onclick="return confirm('Are you sure you want to delete this van?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <a href="<?php echo e(route('admin.dashboard')); ?>"
           class="inline-block mt-4 bg-gray-600 text-white px-4 py-2 rounded hover:bg-gray-700 transition">
           Back
        </a>
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $attributes = $__attributesOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__attributesOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3)): ?>
<?php $component = $__componentOriginal91fdd17964e43374ae18c674f95cdaa3; ?>
<?php unset($__componentOriginal91fdd17964e43374ae18c674f95cdaa3); ?>
<?php endif; ?>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/admin/vans/index.blade.php ENDPATH**/ ?>