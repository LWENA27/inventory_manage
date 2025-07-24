<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.stockAdjustment') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.stockAdjustment') ?></h1>
        <div>
            <a href="<?= site_url('products/' . $product['id']) ?>" class="btn btn-info me-2">
                <i class="fas fa-eye me-2"></i> <?= lang('App.viewProduct') ?? 'View Product' ?>
            </a>
            <a href="<?= site_url('inventory') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Product Info Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.productDetails') ?></h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <?php if (!empty($product['image'])): ?>
                            <img src="<?= base_url($product['image']) ?>" alt="<?= esc($product['name']) ?>" class="img-fluid rounded" style="max-height: 150px;">
                        <?php else: ?>
                            <div class="border rounded p-3 d-flex align-items-center justify-content-center" style="height: 150px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-image fa-4x"></i>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <h5 class="text-center mb-3"><?= esc($product['name']) ?></h5>
                    
                    <table class="table table-borderless">
                        <tr>
                            <th width="120"><?= lang('App.price') ?>:</th>
                            <td><strong class="text-primary">TZS <?= number_format($product['price'], 2) ?></strong></td>
                        </tr>
                        <tr>
                            <th><?= lang('App.category') ?>:</th>
                            <td><?= esc($product['category'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th><?= lang('App.sku') ?>:</th>
                            <td><?= esc($product['sku'] ?? '-') ?></td>
                        </tr>
                        <tr>
                            <th><?= lang('App.currentStock') ?>:</th>
                            <td>
                                <span class="badge <?= $product['stock'] <= 10 ? 'bg-warning text-dark' : 'bg-success' ?> p-2">
                                    <?= $product['stock'] ?>
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Stock Adjustment Form -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.adjustStock') ?? 'Adjust Stock' ?></h6>
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

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('inventory/adjust/' . $product['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row mb-3">
                            <label class="col-sm-3 col-form-label"><?= lang('App.operation') ?? 'Operation' ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="operation" id="operationAdd" value="add" checked>
                                    <label class="form-check-label" for="operationAdd">
                                        <i class="fas fa-plus-circle text-success me-1"></i> <?= lang('App.addStock') ?>
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="operation" id="operationSubtract" value="subtract">
                                    <label class="form-check-label" for="operationSubtract">
                                        <i class="fas fa-minus-circle text-danger me-1"></i> <?= lang('App.reduceStock') ?>
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="quantity" class="col-sm-3 col-form-label"><?= lang('App.quantity') ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="quantity" name="quantity" value="<?= old('quantity', '1') ?>" min="1" required>
                                <div class="form-text" id="stockWarning"></div>
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="reason" class="col-sm-3 col-form-label"><?= lang('App.reason') ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="reason" name="reason" required>
                                    <option value=""><?= lang('App.selectReason') ?? 'Select Reason' ?></option>
                                    <option value="Purchase"><?= lang('App.purchase') ?? 'Purchase' ?></option>
                                    <option value="Sale"><?= lang('App.sale') ?? 'Sale' ?></option>
                                    <option value="Return"><?= lang('App.return') ?? 'Return' ?></option>
                                    <option value="Damage"><?= lang('App.damage') ?? 'Damage' ?></option>
                                    <option value="Correction"><?= lang('App.correction') ?? 'Correction' ?></option>
                                    <option value="Other"><?= lang('App.other') ?? 'Other' ?></option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row mb-3" id="otherReasonContainer" style="display: none;">
                            <label for="otherReason" class="col-sm-3 col-form-label"><?= lang('App.specifyReason') ?? 'Specify Reason' ?></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="otherReason" name="other_reason" value="<?= old('other_reason') ?>">
                            </div>
                        </div>
                        
                        <div class="row mb-3">
                            <label for="batch_number" class="col-sm-3 col-form-label"><?= lang('App.batch') ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" id="batch_number" name="batch_number" value="<?= old('batch_number') ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="expiry_date" class="col-sm-3 col-form-label"><?= lang('App.expiry') ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <input type="date" class="form-control" id="expiry_date" name="expiry_date" value="<?= old('expiry_date') ?>" required>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="warehouse_id" class="col-sm-3 col-form-label"><?= lang('App.warehouse') ?? 'Warehouse' ?> <span class="text-danger">*</span></label>
                            <div class="col-sm-9">
                                <select class="form-select" id="warehouse_id" name="warehouse_id" required>
                                    <option value=""><?= lang('App.selectWarehouse') ?? 'Select Warehouse' ?></option>
                                    <?php foreach (model('App\\Models\\WarehouseModel')->where('tenant_id', session()->get('tenant_id'))->findAll() as $warehouse): ?>
                                        <option value="<?= $warehouse['id'] ?>" <?= old('warehouse_id') == $warehouse['id'] ? 'selected' : '' ?>><?= esc($warehouse['name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="notes" class="col-sm-3 col-form-label"><?= lang('App.notes') ?? 'Notes' ?></label>
                            <div class="col-sm-9">
                                <textarea class="form-control" id="notes" name="notes" rows="3"><?= old('notes') ?></textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i> <?= lang('App.saveAdjustment') ?? 'Save Adjustment' ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Stock Movement History -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.recentMovements') ?? 'Recent Stock Movements' ?></h6>
                    <a href="<?= site_url('inventory/history/' . $product['id']) ?>" class="btn btn-sm btn-info">
                        <?= lang('App.viewAll') ?? 'View All' ?>
                    </a>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> <?= lang('App.noMovements') ?? 'No recent stock movements found for this product.' ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Show/hide other reason field
        $('#reason').change(function() {
            if ($(this).val() === 'Other') {
                $('#otherReasonContainer').show();
                $('#otherReason').prop('required', true);
            } else {
                $('#otherReasonContainer').hide();
                $('#otherReason').prop('required', false);
            }
        });
        
        // Stock warning for subtract operation
        $('#quantity, input[name="operation"]').on('input change', function() {
            const currentStock = <?= $product['stock'] ?>;
            const quantity = parseInt($('#quantity').val()) || 0;
            const operation = $('input[name="operation"]:checked').val();
            
            if (operation === 'subtract' && quantity > currentStock) {
                $('#stockWarning').html('<span class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i> <?= lang('App.notEnoughStock') ?? 'Not enough stock available' ?></span>');
            } else {
                $('#stockWarning').html('');
            }
        });
    });
</script>
<?= $this->endSection() ?>