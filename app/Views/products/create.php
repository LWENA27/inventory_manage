<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('addProduct') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('addProduct') ?></h1>
        <a href="<?= site_url('products') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> <?= lang('back') ?>
        </a>
    </div>

    <!-- Product Form Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('productDetails') ?></h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <h4 class="alert-heading"><?= lang('formErrors') ?? 'Form Errors' ?></h4>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('products') ?>" method="post" enctype="multipart/form-data">
                <?= csrf_field() ?>
                
                <div class="row">
                    <!-- Left Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label"><?= lang('productName') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" value="<?= old('name') ?>" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="price" class="form-label"><?= lang('price') ?> <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">TZS</span>
                                <input type="number" step="0.01" class="form-control" id="price" name="price" value="<?= old('price') ?>" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="category" class="form-label"><?= lang('category') ?></label>
                            <select class="form-select" id="category" name="category">
                                <option value=""><?= lang('selectCategory') ?? 'Select Category' ?></option>
                                <?php 
                                if (!empty($categories)) :
                                    foreach ($categories as $cat):
                                ?>
                                    <option value="<?= esc($cat['name']) ?>" <?= old('category') == $cat['name'] ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                                <?php endforeach; endif; ?>
                            </select>
                        </div>
                        
                        <div class="mb-3">
                            <label for="stock" class="form-label"><?= lang('stock') ?></label>
                            <input type="number" class="form-control" id="stock" name="stock" value="<?= old('stock') ?? '0' ?>">
                        </div>
                    </div>
                    
                    <!-- Right Column -->
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="barcode" class="form-label"><?= lang('barcode') ?></label>
                            <input type="text" class="form-control" id="barcode" name="barcode" value="<?= old('barcode') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="sku" class="form-label"><?= lang('sku') ?></label>
                            <input type="text" class="form-control" id="sku" name="sku" value="<?= old('sku') ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="unit" class="form-label"><?= lang('unit') ?></label>
                            <input type="text" class="form-control" id="unit" name="unit" value="<?= old('unit') ?>" placeholder="<?= lang('unitExample') ?? 'e.g., kg, pcs, box' ?>">
                        </div>
                        
                        <div class="mb-3">
                            <label for="variant" class="form-label"><?= lang('variant') ?></label>
                            <input type="text" class="form-control" id="variant" name="variant" value="<?= old('variant') ?>" placeholder="<?= lang('variantExample') ?? 'e.g., color, size' ?>">
                        </div>
                    </div>
                </div>
                
                <!-- Image Upload -->
                <div class="mb-3">
                    <label for="image" class="form-label"><?= lang('productImage') ?></label>
                    <input type="file" class="form-control" id="image" name="image" accept="image/*">
                    <div class="form-text"><?= lang('imageHint') ?? 'Recommended size: 500x500 pixels. Max file size: 2MB.' ?></div>
                </div>
                
                <!-- Image Preview -->
                <div class="mb-3 d-none" id="imagePreviewContainer">
                    <label class="form-label"><?= lang('imagePreview') ?? 'Image Preview' ?></label>
                    <div class="border p-2 text-center">
                        <img id="imagePreview" src="#" alt="<?= lang('preview') ?? 'Preview' ?>" style="max-height: 200px; max-width: 100%;">
                    </div>
                </div>
                
                <!-- Warehouse Selection (if multiple warehouses) -->
                <div class="mb-3">
                    <label for="warehouse_id" class="form-label"><?= lang('warehouse') ?></label>
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
                        <option value="<?= $warehouse['id'] ?>" <?= old('warehouse_id') == $warehouse['id'] ? 'selected' : '' ?>><?= $warehouse['name'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <hr>
                
                <!-- Submit Buttons -->
                <div class="d-flex justify-content-between">
                    <button type="reset" class="btn btn-secondary">
                        <i class="fas fa-undo me-2"></i> <?= lang('App.reset') ?? 'Reset' ?>
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> <?= lang('App.save') ?>
                    </button>
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
        
        // Generate SKU automatically based on name and category (optional)
        $('#name, #category').change(function() {
            if ($('#sku').val() === '') {
                const name = $('#name').val().substring(0, 3).toUpperCase();
                const category = $('#category').val() ? $('#category').val().substring(0, 2).toUpperCase() : 'XX';
                const random = Math.floor(Math.random() * 10000).toString().padStart(4, '0');
                $('#sku').val(name + '-' + category + '-' + random);
            }
        });
    });
</script>
<?= $this->endSection() ?>