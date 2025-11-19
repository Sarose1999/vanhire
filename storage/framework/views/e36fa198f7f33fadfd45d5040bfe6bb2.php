<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Smooth transition for hover effects */
        .transition-smooth {
            transition: all 0.3s ease-in-out;
        }
        /* Sidebar link hover */
        .sidebar-link:hover {
            background-color: #4b5563; /* Gray-700 */
            transform: translateX(4px);
        }
        /* Active link */
        .sidebar-link.active {
            background-color: #1f2937; /* Gray-900 */
        }
        /* Card hover */
        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.15);
        }
        /* Mobile menu animation */
        #mobile-menu.show {
            animation: slideDown 0.3s ease forwards;
        }
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex">

    <!-- Sidebar -->
    <div class="w-64 bg-gray-800 text-white min-h-screen hidden md:block shadow-lg">
        <div class="p-6 text-center font-bold text-2xl border-b border-gray-700">Admin Panel</div>
        <ul class="mt-6 space-y-1">
            <li>
                <a href="<?php echo e(route('admin.dashboard')); ?>" class="flex items-center gap-2 px-6 py-3 sidebar-link transition-smooth <?php echo e(request()->is('admin/dashboard') ? 'active' : ''); ?>">
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.vans.index')); ?>" class="flex items-center gap-2 px-6 py-3 sidebar-link transition-smooth <?php echo e(request()->is('admin/vans*') ? 'active' : ''); ?>">
                    <i class="fas fa-shuttle-van"></i>
                    <span>Manage Vans</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.bookings.index')); ?>" class="flex items-center gap-2 px-6 py-3 sidebar-link transition-smooth <?php echo e(request()->is('admin/bookings*') ? 'active' : ''); ?>">
                    <i class="fas fa-calendar-check"></i>
                    <span>Manage Bookings</span>
                </a>
            </li>
            <li>
                <a href="<?php echo e(route('admin.bookings.export')); ?>" class="flex items-center gap-2 px-6 py-3 sidebar-link transition-smooth">
                    <i class="fas fa-file-export"></i>
                    <span>Export Bookings</span>
                </a>
            </li>
            <li>
        <a href="<?php echo e(route('admin.banners.index')); ?>" class="flex items-center gap-2 px-6 py-3 sidebar-link transition-smooth <?php echo e(request()->is('admin/banners*') ? 'active' : ''); ?>">
            <i class="fas fa-image"></i>
            <span>Manage Banners</span>
        </a>
    </li>

            </ul>
        <div class="absolute bottom-0 w-64 p-6 border-t border-gray-700">
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full bg-red-600 py-2 rounded hover:bg-red-700 transition-smooth">Logout</button>
            </form>
        </div>
    </div>

    <!-- Mobile menu toggle -->
    <div class="md:hidden flex flex-col w-full">
        <div class="bg-gray-800 text-white p-4 flex justify-between items-center shadow-md">
            <div class="font-bold text-xl">Admin Panel</div>
            <button id="menu-toggle" class="text-white text-2xl">
                ☰
            </button>
        </div>
        <div id="mobile-menu" class="hidden bg-gray-800 text-white flex flex-col">
            <a href="<?php echo e(route('admin.dashboard')); ?>" class="px-6 py-3 hover:bg-gray-700 transition-smooth">Dashboard</a>
            <a href="<?php echo e(route('admin.vans.index')); ?>" class="px-6 py-3 hover:bg-gray-700 transition-smooth">Manage Vans</a>
            <a href="<?php echo e(route('admin.bookings.index')); ?>" class="px-6 py-3 hover:bg-gray-700 transition-smooth">Manage Bookings</a>
            <a href="<?php echo e(route('admin.bookings.export')); ?>" class="px-6 py-3 hover:bg-gray-700 transition-smooth">Export Bookings</a>
            <form method="POST" action="<?php echo e(route('logout')); ?>">
                <?php echo csrf_field(); ?>
                <button type="submit" class="w-full px-6 py-3 hover:bg-red-700 transition-smooth">Logout</button>
            </form>
        </div>
    </div>

    <!-- Main content -->
    <div class="flex-1 p-6 md:ml-64">
        <?php echo e($slot); ?>

    </div>

    <!-- Scripts -->
    <script>
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
            mobileMenu.classList.toggle('show');
        });
    </script>

    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/components/admin-layout.blade.php ENDPATH**/ ?>