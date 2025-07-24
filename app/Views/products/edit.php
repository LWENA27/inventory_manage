<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.editProduct') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.editProduct') ?></h1>
        <div>
            <a href="<?= site_url('products/' . $product['id']) ?>" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i> <?= lang('App.view') ?>
            </a>
            <a href="<?= site_url('products') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <!-- Product Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.productDetails') ?></h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <h4 class="alert-heading"><?= lang('App.formErrors') ?? 'Form Errors' ?></h4>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('products/' . $product['id']) ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label"><?= lang('App.productName') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $product['name']) ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label"><?= lang('App.price') ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">TZS</span>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= old('price', $product['price']) ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label"><?= lang('App.category') ?></label>
                            <select class="form-select" id="category" name="category">
                                <option value=""><?= lang('App.selectCategory') ?? 'Select Category' ?></option>
                                <?php 
                                // This would normally be populated from the database
                                $categories = ['Electronics', 'Clothing', 'Food', 'Medicine', 'Other'];
                                foreach ($categories as $cat): 
                                ?>
                                <option value="<?= $cat ?>" <?= old('category', $product['category']) == $cat ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label"><?= lang('App.stock') ?></label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock', $product['stock']) ?>">
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="barcode" class="form-label"><?= lang('App.barcode') ?></label>
                            <input type="text" class="form-control" id="barcode" name="barcode" value="<?= old('barcode', $product['barcode']) ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="sku" class="form-label"><?= lang('App.sku') ?></label>
                            <input type="text" class="form-control" id="sku" name="sku" value="<?= old('sku', $product['sku']) ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="unit" class="form-label"><?= lang('App.unit') ?></label>
                            <input type="text" class="form-control" id="unit" name="unit" value="<?= old('unit', $product['unit']) ?>" placeholder="<?= lang('App.unitExample') ?? 'e.g., kg, pcs, box' ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="variant" class="form-label"><?= lang('App.variant') ?></label>
                            <input type="text" class="form-control" id="variant" name="variant" value="<?= old('variant', $product['variant']) ?>" placeholder="<?= lang('App.variantExample') ?? 'e.g., color, size' ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Current Image (if exists) -->
                <?php if (!empty($product['image'])): ?>
                <div class="mb-3">
                    <label class="form-label"><?= lang('App.currentImage') ?? 'Current Image' ?></label>
                    <div class="border p-2 text-center">
                        <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" style="max-height: 200px; max-width: 100%;">
                    </div>
                </div>
                <?php endif; ?>
                
                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label"><?= lang('App.productImage') ?></label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text">
                        <?= lang('App.imageHint') ?? 'Recommended size: 500x500 pixels. Max file size: 2MB.' ?>
                        <?php if (!empty($product['image'])): ?>
                            <br><?= lang('App.leaveEmptyKeep') ?? 'Leave empty to keep the current image.' ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Image Preview -->
                <div class="mb-3 d-none" id="imagePreviewContainer">
                    <label class="form-label"><?= lang('App.newImagePreview') ?? 'New Image Preview' ?></label>
                    <div class="border p-2 text-center">
                        <img id="imagePreview" src="#" alt="<?= lang('App.preview') ?? 'Preview' ?>" style="max-height: 200px; max-width: 100%;">
                    </div>
                </div>
                
                <!-- Warehouse Selection (if multiple warehouses) -->
                <div class="mb-3">
                    <label for="warehouse_id" class="form-label"><?= lang('App.warehouse') ?></label>
                    <select class="form-select" id="warehouse_id" name="warehouse_id">
                        <option value=""><?= lang('App.defaultWarehouse') ?? 'Default Warehouse' ?></option>
                        <?php 
                        // This would normally be populated from the database
                        $warehouses = [
                            ['id' => 1, 'name' => 'Main Warehouse'],
                            ['id' => 2, 'name' => 'Store Warehouse']
                        ];
                        foreach ($warehouses as $warehouse): 
                        ?>
                        <option value="<?= $warehouse['id'] ?>" <?= old('warehouse_id', $product['warehouse_id']) == $warehouse['id'] ? 'selected' : '' ?>><?= $warehouse['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <hr>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between">
                    <a href="<?= site_url('products/' . $product['id'] . '/delete') ?>" class="btn btn-danger" 
                       onclick="return confirm('<?= lang('App.deleteConfirm') ?? 'Are you sure you want to delete this product?' ?>')">
                        <i class="fas fa-trash me-2"></i> <?= lang('App.delete') ?>
                    </a>
                    <div>
                        <a href="<?= site_url('products') ?>" class="btn btn-secondary me-2">
                            <i class="fas fa-times me-2"></i> <?= lang('App.cancel') ?>
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i> <?= lang('App.save') ?>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Image preview functionality
        $('#image').change(function() {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').attr('src', e.target.result);
                    $('#imagePreviewContainer').removeClass('d-none');
                }
                reader.readAsDataURL(file);
            } else {
                $('#imagePreviewContainer').addClass('d-none');
            }
        });
    });
</script>
<?= $this->endSection() ?>