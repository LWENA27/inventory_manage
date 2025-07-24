<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= esc($product['name']) ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.productDetails') ?></h1>
        <div>
            <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-primary me-2">
                <i class="fas fa-edit me-2"></i> <?= lang('App.edit') ?>
            </a>
            <a href="<?= site_url('products') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Product Details Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-primary"><?= esc($product['name']) ?></h6>
                    <span class="badge bg-<?= $product['stock'] > 10 ? 'success' : 'warning' ?>">
                        <?= lang('App.inStock') ?? 'In Stock' ?>: <?= $product['stock'] ?>
                    </span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
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
                                    <th><?= lang('App.barcode') ?>:</th>
                                    <td><?= esc($product['barcode'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('App.unit') ?>:</th>
                                    <td><?= esc($product['unit'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('App.variant') ?>:</th>
                                    <td><?= esc($product['variant'] ?? '-') ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('App.warehouse') ?>:</th>
                                    <td>
                                        <?php 
                                        // This would normally be populated from the database
                                        $warehouses = [
                                            1 => 'Main Warehouse',
                                            2 => 'Store Warehouse'
                                        ];
                                        echo $warehouses[$product['warehouse_id']] ?? lang('App.defaultWarehouse') ?? 'Default Warehouse';
                                        ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th><?= lang('App.createdAt') ?? 'Created' ?>:</th>
                                    <td><?= date('d M Y H:i', strtotime($product['created_at'])) ?></td>
                                </tr>
                                <tr>
                                    <th><?= lang('App.updatedAt') ?? 'Updated' ?>:</th>
                                    <td><?= date('d M Y H:i', strtotime($product['updated_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 text-center">
                            <?php if (!empty($product['image'])): ?>
                                <img src="<?= base_url($product['image']) ?>" alt="<?= esc($product['name']) ?>" class="img-fluid rounded" style="max-height: 300px;">
                            <?php else: ?>
                                <div class="border rounded p-5 d-flex align-items-center justify-content-center" style="height: 300px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-image fa-5x mb-3"></i>
                                        <p><?= lang('App.noImage') ?? 'No image available' ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Quick Actions Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.quickActions') ?? 'Quick Actions' ?></h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="<?= site_url('inventory/adjust/' . $product['id']) ?>" class="btn btn-info btn-block">
                            <i class="fas fa-balance-scale me-2"></i> <?= lang('App.stockAdjustment') ?>
                        </a>
                        <a href="<?= site_url('pos?product=' . $product['id']) ?>" class="btn btn-success btn-block">
                            <i class="fas fa-shopping-cart me-2"></i> <?= lang('App.addToCart') ?>
                        </a>
                        <a href="<?= site_url('products/' . $product['id'] . '/barcode') ?>" class="btn btn-secondary btn-block">
                            <i class="fas fa-barcode me-2"></i> <?= lang('App.printBarcode') ?? 'Print Barcode' ?>
                        </a>
                        <a href="<?= site_url('products/' . $product['id'] . '/delete') ?>" class="btn btn-danger btn-block" 
                           onclick="return confirm('<?= lang('App.deleteConfirm') ?? 'Are you sure you want to delete this product?' ?>')">
                            <i class="fas fa-trash me-2"></i> <?= lang('App.delete') ?>
                        </a>
                    </div>
                </div>
            </div>
            
            <!-- Stock History Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.stockHistory') ?></h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i> <?= lang('App.stockHistoryEmpty') ?? 'No stock history available yet.' ?>
                    </div>
                    <div class="text-center">
                        <a href="<?= site_url('inventory/history/' . $product['id']) ?>" class="btn btn-sm btn-primary">
                            <i class="fas fa-history me-2"></i> <?= lang('App.viewFullHistory') ?? 'View Full History' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>