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
    <div class="admin-container">
        <!-- Header Section -->
        <div class="page-header" data-aos="fade-down">
            <div class="header-content">
                <div class="header-icon">
                    <i class="fas fa-edit"></i>
                </div>
                <div>
                    <h1 class="page-title">Edit Van Details</h1>
                    <p class="page-subtitle">Update your van information and images</p>
                </div>
            </div>
            <div class="header-actions">
                <a href="<?php echo e(route('admin.vans.index')); ?>" class="btn-back">
                    <i class="fas fa-arrow-left"></i>
                    Back to Vans
                </a>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="form-container" data-aos="fade-up" data-aos-delay="200">
            <form action="<?php echo e(route('admin.vans.update', $van->id)); ?>" method="POST" enctype="multipart/form-data" class="edit-form">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Form Steps Indicator -->
                <div class="form-steps">
                    <div class="step active">
                        <div class="step-number">1</div>
                        <div class="step-text">Basic Information</div>
                    </div>
                    <div class="step">
                        <div class="step-number">2</div>
                        <div class="step-text">Pricing & Capacity</div>
                    </div>
                    <div class="step">
                        <div class="step-number">3</div>
                        <div class="step-text">Image Management</div>
                    </div>
                </div>

                <div class="form-sections">
                    <!-- Basic Information Section -->
                    <div class="form-section active">
                        <div class="section-header">
                            <i class="fas fa-info-circle"></i>
                            <h3>Basic Information</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Van Name
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" name="name" value="<?php echo e(old('name', $van->name)); ?>"
                                           class="form-input" placeholder="Enter van name" required>
                                    <i class="fas fa-van-shuttle input-icon"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-cog"></i>
                                    Model
                                </label>
                                <div class="input-wrapper">
                                    <input type="text" name="model" value="<?php echo e(old('model', $van->model)); ?>"
                                           class="form-input" placeholder="Enter model" required>
                                    <i class="fas fa-car input-icon"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pricing & Capacity Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-dollar-sign"></i>
                            <h3>Pricing & Capacity</h3>
                        </div>

                        <div class="form-grid">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-users"></i>
                                    Seating Capacity
                                </label>
                                <div class="input-wrapper">
                                    <input type="number" name="seats" value="<?php echo e(old('seats', $van->seats)); ?>"
                                           class="form-input" placeholder="Number of seats" min="1" required>
                                    <i class="fas fa-chair input-icon"></i>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tag"></i>
                                    Daily Rate (LKR)
                                </label>
                                <div class="input-wrapper">
                                    <input type="number" name="price_per_day" value="<?php echo e(old('price_per_day', $van->price_per_day)); ?>"
                                           class="form-input" placeholder="Price per day" min="0" step="0.01" required>
                                    <i class="fas fa-money-bill-wave input-icon"></i>
                                </div>
                                <div class="price-preview">
                                    <span class="price-amount">LKR <?php echo e(number_format($van->price_per_day, 2)); ?></span>
                                    <span class="price-period">per day</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Management Section -->
                    <div class="form-section">
                        <div class="section-header">
                            <i class="fas fa-image"></i>
                            <h3>Image Management</h3>
                        </div>

                        <div class="image-management">
                            <!-- Current Image Preview -->
                            <div class="current-image-section">
                                <h4 class="section-subtitle">Current Image</h4>
                                <div class="image-preview-container">
                                    <div class="image-card">
                                        <img id="image-preview"
                                             src="<?php echo e($van->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($van->image) ? \Illuminate\Support\Facades\Storage::url($van->image) : asset('images/default-van.png')); ?>"
                                             alt="<?php echo e($van->name); ?>"
                                             class="preview-image">
                                        <div class="image-overlay">
                                            <div class="image-actions">
                                                <button type="button" class="btn-action btn-view" onclick="openImageModal()">
                                                    <i class="fas fa-expand"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Image Upload -->
                            <div class="upload-section">
                                <h4 class="section-subtitle">Update Image</h4>
                                <div class="upload-area" id="upload-area">
                                    <div class="upload-content">
                                        <i class="fas fa-cloud-upload-alt upload-icon"></i>
                                        <div class="upload-text">
                                            <p class="upload-title">Click to upload or drag and drop</p>
                                            <p class="upload-subtitle">PNG, JPG, JPEG up to 5MB</p>
                                        </div>
                                        <input type="file" name="image" id="image-input" class="file-input" accept="image/*">
                                    </div>
                                </div>

                                <!-- Image Actions -->
                                <div class="image-actions-panel">
                                    <button type="button" id="reset-image" class="btn-action btn-secondary">
                                        <i class="fas fa-undo"></i>
                                        Reset to Original
                                    </button>
                                    <button type="button" id="remove-image" class="btn-action btn-danger">
                                        <i class="fas fa-trash"></i>
                                        Remove Image
                                    </button>
                                </div>

                                <!-- Hidden input for remove image -->
                                <input type="hidden" name="remove_image" id="remove-image-input" value="0">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="form-actions">
                    <button type="submit" class="btn-primary btn-update">
                        <i class="fas fa-save"></i>
                        Update Van
                    </button>
                    <a href="<?php echo e(route('admin.vans.index')); ?>" class="btn-cancel">
                        <i class="fas fa-times"></i>
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="modal">
        <div class="modal-content">
            <span class="close-modal" onclick="closeImageModal()">&times;</span>
            <img id="modal-image" src="" alt="Van Image" class="modal-image">
        </div>
    </div>

    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #10b981;
            --warning: #f59e0b;
            --danger: #ef4444;
            --dark: #1e293b;
            --light: #f8fafc;
            --gray: #64748b;
            --gray-light: #e2e8f0;
        }

        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 2rem;
        }

        /* Header Styles */
        .page-header {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-left: 4px solid var(--primary);
        }

        .header-content {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .header-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
        }

        .page-title {
            font-size: 2rem;
            font-weight: 700;
            color: var(--dark);
            margin: 0;
        }

        .page-subtitle {
            color: var(--gray);
            margin: 0.25rem 0 0 0;
        }

        .btn-back {
            background: var(--gray-light);
            color: var(--dark);
            padding: 0.75rem 1.5rem;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-back:hover {
            background: var(--gray);
            color: white;
            transform: translateX(-5px);
        }

        /* Form Container */
        .form-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        /* Form Steps */
        .form-steps {
            display: flex;
            background: var(--light);
            padding: 2rem;
            border-bottom: 1px solid var(--gray-light);
        }

        .step {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            opacity: 0.5;
            transition: all 0.3s ease;
        }

        .step.active {
            opacity: 1;
        }

        .step-number {
            width: 40px;
            height: 40px;
            background: var(--gray-light);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--dark);
            transition: all 0.3s ease;
        }

        .step.active .step-number {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
        }

        .step-text {
            font-weight: 600;
            color: var(--dark);
        }

        /* Form Sections */
        .form-sections {
            padding: 2rem;
        }

        .form-section {
            display: none;
        }

        .form-section.active {
            display: block;
            animation: fadeIn 0.5s ease;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 2px solid var(--gray-light);
        }

        .section-header i {
            color: var(--primary);
            font-size: 1.5rem;
        }

        .section-header h3 {
            font-size: 1.5rem;
            font-weight: 600;
            color: var(--dark);
            margin: 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 2rem;
        }

        /* Form Elements */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .form-label i {
            color: var(--primary);
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 1rem 1rem 1rem 3rem;
            border: 2px solid var(--gray-light);
            border-radius: 12px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: white;
        }

        .form-input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
            transform: translateY(-2px);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
        }

        .price-preview {
            margin-top: 0.5rem;
            padding: 1rem;
            background: linear-gradient(135deg, #f8faff 0%, #f0f4ff 100%);
            border-radius: 10px;
            text-align: center;
        }

        .price-amount {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        .price-period {
            color: var(--gray);
            font-size: 0.875rem;
        }

        /* Image Management */
        .image-management {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 3rem;
        }

        .section-subtitle {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 1rem;
        }

        .image-preview-container {
            position: relative;
        }

        .image-card {
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .image-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .preview-image {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .image-card:hover .preview-image {
            transform: scale(1.05);
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            display: flex;
            align-items: center;
            justify-content: center;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .image-card:hover .image-overlay {
            opacity: 1;
        }

        .image-actions {
            display: flex;
            gap: 0.5rem;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed var(--gray-light);
            border-radius: 16px;
            padding: 3rem 2rem;
            text-align: center;
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
        }

        .upload-area:hover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.02);
        }

        .upload-area.dragover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.05);
            transform: scale(1.02);
        }

        .upload-content {
            position: relative;
            z-index: 2;
        }

        .upload-icon {
            font-size: 3rem;
            color: var(--primary);
            margin-bottom: 1rem;
        }

        .upload-title {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
        }

        .upload-subtitle {
            color: var(--gray);
            font-size: 0.875rem;
        }

        .file-input {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
        }

        /* Action Buttons */
        .image-actions-panel {
            display: flex;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .btn-action {
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 10px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-secondary {
            background: var(--gray-light);
            color: var(--dark);
        }

        .btn-secondary:hover {
            background: var(--gray);
            color: white;
            transform: translateY(-2px);
        }

        .btn-danger {
            background: rgba(239, 68, 68, 0.1);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.2);
        }

        .btn-danger:hover {
            background: var(--danger);
            color: white;
            transform: translateY(-2px);
        }

        .btn-view {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--dark);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .btn-view:hover {
            background: white;
            transform: scale(1.1);
        }

        /* Form Actions */
        .form-actions {
            padding: 2rem;
            background: var(--light);
            border-top: 1px solid var(--gray-light);
            display: flex;
            gap: 1rem;
            justify-content: flex-end;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(67, 97, 238, 0.3);
        }

        /* Cancel Button (improved look) */
        .btn-cancel {
            background: transparent;
            color: var(--gray);
            padding: 1rem 1.5rem;
            border: 2px solid var(--gray-light);
            border-radius: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }

        .btn-cancel i {
            color: var(--gray);
        }

        .btn-cancel:hover {
            background: linear-gradient(135deg, rgba(67,97,238,0.06) 0%, rgba(63,55,201,0.04) 100%);
            border-color: rgba(67,97,238,0.18);
            color: var(--primary);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(67, 97, 238, 0.08);
            text-decoration: none;
        }

        /* Modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(5px);
        }

        .modal-content {
            position: relative;
            margin: 5% auto;
            width: 90%;
            max-width: 800px;
            animation: modalSlideIn 0.3s ease;
        }

        .close-modal {
            position: absolute;
            top: -40px;
            right: 0;
            color: white;
            font-size: 2rem;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: var(--primary);
        }

        .modal-image {
            width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        @keyframes modalSlideIn {
            from { opacity: 0; transform: scale(0.8); }
            to { opacity: 1; transform: scale(1); }
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem;
            }

            .page-header {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .image-management {
                grid-template-columns: 1fr;
            }

            .form-steps {
                flex-direction: column;
                gap: 1rem;
            }

            .form-actions {
                flex-direction: column;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const imageInput = document.getElementById('image-input');
            const imagePreview = document.getElementById('image-preview');
            const resetButton = document.getElementById('reset-image');
            const removeButton = document.getElementById('remove-image');
            const removeInput = document.getElementById('remove-image-input');
            const uploadArea = document.getElementById('upload-area');
            const formSections = document.querySelectorAll('.form-section');
            const steps = document.querySelectorAll('.step');

            // Store original image URL
            const originalImage = imagePreview.src;

            // Update preview on file select
            imageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        removeInput.value = 0;
                        uploadArea.classList.add('has-image');
                    }
                    reader.readAsDataURL(file);
                }
            });

            // Reset to original image
            resetButton.addEventListener('click', function() {
                imagePreview.src = originalImage;
                imageInput.value = '';
                removeInput.value = 0;
                uploadArea.classList.remove('has-image');

                // Add success feedback
                showNotification('Image reset to original', 'success');
            });

            // Remove image completely
            removeButton.addEventListener('click', function() {
                imagePreview.src = "<?php echo e(asset('images/default-van.png')); ?>";
                imageInput.value = '';
                removeInput.value = 1;
                uploadArea.classList.remove('has-image');

                // Add success feedback
                showNotification('Image removed successfully', 'success');
            });

            // Drag and drop functionality
            uploadArea.addEventListener('dragover', function(e) {
                e.preventDefault();
                uploadArea.classList.add('dragover');
            });

            uploadArea.addEventListener('dragleave', function() {
                uploadArea.classList.remove('dragover');
            });

            uploadArea.addEventListener('drop', function(e) {
                e.preventDefault();
                uploadArea.classList.remove('dragover');

                const files = e.dataTransfer.files;
                if (files.length > 0) {
                    imageInput.files = files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            });

            // Form step navigation (optional enhancement)
            steps.forEach((step, index) => {
                step.addEventListener('click', () => {
                    // Remove active class from all steps and sections
                    steps.forEach(s => s.classList.remove('active'));
                    formSections.forEach(s => s.classList.remove('active'));

                    // Add active class to clicked step and corresponding section
                    step.classList.add('active');
                    formSections[index].classList.add('active');
                });
            });

            // Price input real-time update
            const priceInput = document.querySelector('input[name="price_per_day"]');
            const priceAmount = document.querySelector('.price-amount');

            if (priceInput && priceAmount) {
                priceInput.addEventListener('input', function() {
                    const value = this.value ? parseFloat(this.value).toFixed(2) : '0.00';
                    priceAmount.textContent = `LKR ${parseFloat(value).toLocaleString()}`;
                });
            }

            // Form submission enhancement
            const form = document.querySelector('.edit-form');
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('.btn-update');
                const originalText = submitBtn.innerHTML;

                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Updating Van...';
                submitBtn.disabled = true;

                // Re-enable after 3 seconds if still processing
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            });
        });

        // Image modal functions
        function openImageModal() {
            const modal = document.getElementById('imageModal');
            const modalImage = document.getElementById('modal-image');
            const previewImage = document.getElementById('image-preview');

            modalImage.src = previewImage.src;
            modal.style.display = 'block';

            // Add escape key listener
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    closeImageModal();
                }
            });
        }

        function closeImageModal() {
            const modal = document.getElementById('imageModal');
            modal.style.display = 'none';
        }

        // Notification function
        function showNotification(message, type = 'info') {
            // You can integrate with a notification library like Toastify.js
            console.log(`${type.toUpperCase()}: ${message}`);
            // For now, we'll use a simple alert
            alert(message);
        }
    </script>

    <!-- Additional Libraries -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-out-cubic',
            once: true
        });
    </script>
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
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/admin/vans/edit.blade.php ENDPATH**/ ?>