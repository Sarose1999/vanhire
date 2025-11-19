<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Van</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #4361ee;
            --secondary: #3f37c9;
            --success: #10b981;
            --light: #f8f9fa;
            --dark: #212529;
            --border-radius: 12px;
            --box-shadow: 0 10px 25px rgba(0,0,0,0.08);
            --transition: all 0.3s ease;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .admin-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 2rem 1rem;
        }

        .form-card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            overflow: hidden;
            transition: var(--transition);
        }

        .form-card:hover {
            box-shadow: 0 15px 35px rgba(0,0,0,0.12);
        }

        .form-header {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            padding: 1.5rem 2rem;
            color: white;
        }

        .form-body {
            padding: 2rem;
        }

        .form-footer {
            background: #f8f9fa;
            padding: 1.5rem 2rem;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .form-group {
            margin-bottom: 1.5rem;
            position: relative;
        }

        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.5rem;
            display: flex;
            align-items: center;
        }

        .form-label i {
            margin-right: 0.5rem;
            color: var(--primary);
        }

        .form-control {
            border-radius: 8px;
            padding: 0.75rem 1rem;
            border: 1px solid #e1e5ee;
            transition: var(--transition);
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
            transform: translateY(-2px);
        }

        .form-control:hover {
            border-color: #b4b9c7;
        }

        .file-input-wrapper {
            position: relative;
            overflow: hidden;
            display: inline-block;
            width: 100%;
        }

        .file-input-wrapper input[type=file] {
            position: absolute;
            left: 0;
            top: 0;
            opacity: 0;
            width: 100%;
            height: 100%;
            cursor: pointer;
        }

        .file-input-custom {
            background: #f8f9fa;
            border: 2px dashed #dee2e6;
            border-radius: 8px;
            padding: 1.5rem;
            text-align: center;
            transition: var(--transition);
            cursor: pointer;
        }

        .file-input-custom:hover {
            border-color: var(--primary);
            background: rgba(67, 97, 238, 0.05);
        }

        .file-input-custom i {
            font-size: 2rem;
            color: var(--primary);
            margin-bottom: 0.5rem;
        }

        .file-input-text {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0.25rem;
        }

        .file-input-hint {
            font-size: 0.85rem;
            color: #6c757d;
        }

        .file-preview {
            margin-top: 1rem;
            text-align: center;
            display: none;
        }

        .file-preview img {
            max-width: 200px;
            max-height: 150px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
            border: none;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(67, 97, 238, 0.3);
        }

        .btn-outline {
            background: transparent;
            border: 1px solid #dee2e6;
            border-radius: 8px;
            padding: 0.75rem 1.5rem;
            font-weight: 600;
            transition: var(--transition);
            color: #6c757d;
            text-decoration: none;
            display: inline-block;
        }

        .btn-outline:hover {
            background: #f8f9fa;
            border-color: #adb5bd;
            color: var(--dark);
            transform: translateY(-2px);
            text-decoration: none;
        }

        .input-with-icon {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
        }

        .input-with-icon .form-control {
            padding-left: 3rem;
        }

        .form-step {
            display: flex;
            align-items: center;
            margin-bottom: 2rem;
        }

        .step-number {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(67, 97, 238, 0.1);
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            margin-right: 1rem;
        }

        .step-text {
            font-weight: 600;
            color: var(--dark);
        }

        .price-preview {
            background: linear-gradient(135deg, #f8f9ff 0%, #eef1ff 100%);
            border-radius: 8px;
            padding: 1rem;
            margin-top: 0.5rem;
            text-align: center;
            display: none;
        }

        .price-value {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary);
        }

        @media (max-width: 768px) {
            .admin-container {
                padding: 1rem 0.5rem;
            }

            .form-body {
                padding: 1.5rem;
            }

            .form-header {
                padding: 1.25rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="form-card">
            <div class="form-header">
                <h1 class="h3 mb-0"><i class="fas fa-van-shuttle me-2"></i>Add New Van</h1>
                <p class="mb-0 mt-2 opacity-75">Fill in the details to add a new van to your fleet</p>
            </div>

            <form action="<?php echo e(route('admin.vans.store')); ?>" method="POST" enctype="multipart/form-data" id="vanForm">
                <?php echo csrf_field(); ?>

                <div class="form-body">
                    <!-- Van Information Section -->
                    <div class="form-step">
                        <div class="step-number">1</div>
                        <div class="step-text">Van Information</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="name">
                                    <i class="fas fa-tag"></i>Van Name
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-tag input-icon"></i>
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Enter van name" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="model">
                                    <i class="fas fa-cog"></i>Model
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-cog input-icon"></i>
                                    <input type="text" name="model" id="model" class="form-control" placeholder="Enter model" required>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Capacity & Pricing Section -->
                    <div class="form-step">
                        <div class="step-number">2</div>
                        <div class="step-text">Capacity & Pricing</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="seats">
                                    <i class="fas fa-users"></i>Seats
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-users input-icon"></i>
                                    <input type="number" name="seats" id="seats" class="form-control" placeholder="Number of seats" min="1" required>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label" for="price_per_day">
                                    <i class="fas fa-dollar-sign"></i>Price per Day ($)
                                </label>
                                <div class="input-with-icon">
                                    <i class="fas fa-dollar-sign input-icon"></i>
                                    <input type="number" name="price_per_day" id="price_per_day" class="form-control" placeholder="Daily rate" min="0" step="0.01" required>
                                </div>
                                <div class="price-preview" id="pricePreview">
                                    <div class="price-value">$<span id="priceValue">0</span>/day</div>
                                    <small class="text-muted">This will be the rental price shown to customers</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="form-step">
                        <div class="step-number">3</div>
                        <div class="step-text">Van Image</div>
                    </div>

                    <div class="form-group">
                        <div class="file-input-wrapper">
                            <div class="file-input-custom" id="fileInputCustom">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <div class="file-input-text">Upload Van Image</div>
                                <div class="file-input-hint">Click to browse or drag and drop</div>
                                <div class="file-input-hint">PNG, JPG, JPEG up to 5MB</div>
                            </div>
                            <input type="file" name="image" id="image" accept="image/*" required>
                        </div>

                        <div class="file-preview" id="filePreview">
                            <img id="previewImage" src="#" alt="Preview">
                            <div class="mt-2">
                                <button type="button" class="btn btn-sm btn-outline" id="changeImage">
                                    <i class="fas fa-sync-alt me-1"></i>Change Image
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-footer">
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="<?php echo e(route('admin.vans.index')); ?>" class="btn-outline">
                            <i class="fas fa-arrow-left me-2"></i>Back to Vans
                        </a>
                        <button type="submit" class="btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Add Van
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Image preview functionality
            const imageInput = document.getElementById('image');
            const filePreview = document.getElementById('filePreview');
            const previewImage = document.getElementById('previewImage');
            const fileInputCustom = document.getElementById('fileInputCustom');
            const changeImageBtn = document.getElementById('changeImage');

            imageInput.addEventListener('change', function() {
                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        previewImage.src = e.target.result;
                        filePreview.style.display = 'block';
                        fileInputCustom.style.display = 'none';
                    }

                    reader.readAsDataURL(this.files[0]);
                }
            });

            changeImageBtn.addEventListener('click', function() {
                imageInput.value = '';
                filePreview.style.display = 'none';
                fileInputCustom.style.display = 'block';
            });

            // Price preview functionality
            const priceInput = document.getElementById('price_per_day');
            const pricePreview = document.getElementById('pricePreview');
            const priceValue = document.getElementById('priceValue');

            priceInput.addEventListener('input', function() {
                if (this.value) {
                    priceValue.textContent = parseFloat(this.value).toFixed(2);
                    pricePreview.style.display = 'block';
                } else {
                    pricePreview.style.display = 'none';
                }
            });

            // Form validation and enhancement
            const vanForm = document.getElementById('vanForm');

            vanForm.addEventListener('submit', function(e) {
                // You can add additional validation here if needed
                const inputs = vanForm.querySelectorAll('input[required]');
                let valid = true;

                inputs.forEach(input => {
                    if (!input.value.trim()) {
                        valid = false;
                        input.style.borderColor = '#f94144';
                    } else {
                        input.style.borderColor = '';
                    }
                });

                if (!valid) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });

            // Add focus effects to form inputs
            const formInputs = document.querySelectorAll('.form-control');

            formInputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('focused');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('focused');
                });
            });

            // Drag and drop functionality for image upload
            fileInputCustom.addEventListener('dragover', function(e) {
                e.preventDefault();
                this.style.borderColor = '#4361ee';
                this.style.background = 'rgba(67, 97, 238, 0.1)';
            });

            fileInputCustom.addEventListener('dragleave', function() {
                this.style.borderColor = '#dee2e6';
                this.style.background = '#f8f9fa';
            });

            fileInputCustom.addEventListener('drop', function(e) {
                e.preventDefault();
                this.style.borderColor = '#dee2e6';
                this.style.background = '#f8f9fa';

                if (e.dataTransfer.files.length) {
                    imageInput.files = e.dataTransfer.files;
                    const event = new Event('change');
                    imageInput.dispatchEvent(event);
                }
            });
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\trainee\Desktop\New folder\van hire last update\resources\views/admin/vans/create.blade.php ENDPATH**/ ?>