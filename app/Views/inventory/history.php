<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.stockHistory') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">
            <?php if (isset($product)): ?>
                <?= esc($product['name']) ?> - <?= lang('App.stockHistory') ?>
            <?php else: ?>
                <?= lang('App.stockHistory') ?>
            <?php endif; ?>
        </h1>
        <div>
            <button type="button" class="btn btn-success me-2" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i> <?= lang('App.export') ?>
            </button>
            <a href="<?= site_url(isset($product) ? 'products/' . $product['id'] : 'inventory') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <!-- Filter Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.filter') ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('inventory/history') ?>" method="get" class="row g-3">
                <?php if (!isset($product)): ?>
                <div class="col-md-3">
                    <label for="product_id" class="form-label"><?= lang('App.product') ?></label>
                    <select class="form-select" id="product_id" name="product_id">
                        <option value=""><?= lang('App.allProducts') ?? 'All Products' ?></option>
                        <?php 
                        // This would normally be populated from the database
                        $products = [
                            ['id' => 1, 'name' => 'Product 1'],
                            ['id' => 2, 'name' => 'Product 2'],
                            ['id' => 3, 'name' => 'Product 3']
                        ];
                        foreach ($products as $prod): 
                        ?>
                        <option value="<?= $prod['id'] ?>" <?= isset($_GET['product_id']) && $_GET['product_id'] == $prod['id'] ? 'selected' : '' ?>>
                            <?= esc($prod['name']) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <?php endif; ?>
                
                <div class="col-md-3">
                    <label for="movement_type" class="form-label"><?= lang('App.movementType') ?? 'Movement Type' ?></label>
                    <select class="form-select" id="movement_type" name="movement_type">
                        <option value=""><?= lang('App.allTypes') ?? 'All Types' ?></option>
                        <option value="add" <?= isset($_GET['movement_type']) && $_GET['movement_type'] == 'add' ? 'selected' : '' ?>>
                            <?= lang('App.stockIn') ?>
                        </option>
                        <option value="subtract" <?= isset($_GET['movement_type']) && $_GET['movement_type'] == 'subtract' ? 'selected' : '' ?>>
                            <?= lang('App.stockOut') ?>
                        </option>
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="date_from" class="form-label"><?= lang('App.fromDate') ?></label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="<?= isset($_GET['date_from']) ? $_GET['date_from'] : '' ?>">
                </div>
                
                <div class="col-md-3">
                    <label for="date_to" class="form-label"><?= lang('App.toDate') ?></label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="<?= isset($_GET['date_to']) ? $_GET['date_to'] : '' ?>">
                </div>
                
                <div class="col-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter me-2"></i> <?= lang('App.applyFilter') ?? 'Apply Filter' ?>
                    </button>
                    <a href="<?= site_url('inventory/history' . (isset($product) ? '/' . $product['id'] : '')) ?>" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-2"></i> <?= lang('App.resetFilter') ?? 'Reset Filter' ?>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Stock Movement History Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.stockMovements') ?? 'Stock Movements' ?></h6>
        </div>
        <div class="card-body">
            <?php if (empty($movements)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> <?= lang('App.noMovements') ?? 'No stock movements found.' ?>
                </div>
                
                <!-- Sample data for demonstration -->
                <div class="alert alert-warning">
                    <i class="fas fa-exclamation-triangle me-2"></i> <?= lang('App.demoData') ?? 'This is sample data for demonstration purposes.' ?>
                </div>
                
                <?php
                // Sample data for demonstration
                $sampleMovements = [
                    [
                        'id' => 1,
                        'product_id' => isset($product) ? $product['id'] : 1,
                        'product_name' => isset($product) ? $product['name'] : 'Product 1',
                        'type' => 'add',
                        'quantity' => 10,
                        'reason' => 'Purchase',
                        'user_name' => 'Admin User',
                        'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
                    ],
                    [
                        'id' => 2,
                        'product_id' => isset($product) ? $product['id'] : 1,
                        'product_name' => isset($product) ? $product['name'] : 'Product 1',
                        'type' => 'subtract',
                        'quantity' => 3,
                        'reason' => 'Sale',
                        'user_name' => 'Seller User',
                        'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
                    ],
                    [
                        'id' => 3,
                        'product_id' => isset($product) ? $product['id'] : 1,
                        'product_name' => isset($product) ? $product['name'] : 'Product 1',
                        'type' => 'add',
                        'quantity' => 5,
                        'reason' => 'Return',
                        'user_name' => 'Admin User',
                        'created_at' => date('Y-m-d H:i:s')
                    ]
                ];
                $movements = $sampleMovements;
                ?>
            <?php endif; ?>
            
            <div class="table-responsive">
                <table class="table table-bordered table-hover" id="stockMovementsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= lang('App.date') ?></th>
                            <?php if (!isset($product)): ?>
                            <th><?= lang('App.product') ?></th>
                            <?php endif; ?>
                            <th><?= lang('App.type') ?? 'Type' ?></th>
                            <th><?= lang('App.quantity') ?></th>
                            <th><?= lang('App.batch') ?></th>
                            <th><?= lang('App.expiry') ?></th>
                            <th><?= lang('App.warehouse') ?? 'Warehouse' ?></th>
                            <th><?= lang('App.reason') ?></th>
                            <th><?= lang('App.user') ?? 'User' ?></th>
                            <th><?= lang('App.details') ?? 'Details' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($movements as $movement): ?>
                        <tr>
                            <td><?= date('d M Y H:i', strtotime($movement['created_at'])) ?></td>
                            <?php if (!isset($product)): ?>
                            <td>
                                <a href="<?= site_url('products/' . $movement['product_id']) ?>">
                                    <?= esc($movement['product_name'] ?? '') ?>
                                </a>
                            </td>
                            <?php endif; ?>
                            <td><?= stock_operation_label($movement['operation'] ?? $movement['type']) ?></td>
                            <td><?= ($movement['operation'] ?? $movement['type']) === 'in' || ($movement['type'] ?? '') === 'add' ? '+' : '-' ?><?= $movement['quantity'] ?></td>
                            <td><?= esc($movement['batch_number'] ?? '-') ?></td>
                            <td><?= !empty($movement['expiry_date']) ? date('d-m-Y', strtotime($movement['expiry_date'])) : '-' ?></td>
                            <td><?= esc($movement['warehouse_name'] ?? '-') ?></td>
                            <td><?= esc($movement['reason']) ?></td>
                            <td><?= esc($movement['user_name'] ?? '-') ?></td>
                            <td>
                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#movementModal<?= $movement['id'] ?>">
                                    <i class="fas fa-eye"></i> <?= lang('App.view') ?>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Movement Detail Modals -->
<?php foreach ($movements as $movement): ?>
<div class="modal fade" id="movementModal<?= $movement['id'] ?>" tabindex="-1" aria-labelledby="movementModalLabel<?= $movement['id'] ?>" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="movementModalLabel<?= $movement['id'] ?>">
                    <?= lang('App.movementDetails') ?? 'Movement Details' ?> #<?= $movement['id'] ?>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <th width="150"><?= lang('App.product') ?>:</th>
                        <td><?= esc($movement['product_name']) ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('App.date') ?>:</th>
                        <td><?= date('d M Y H:i', strtotime($movement['created_at'])) ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('App.type') ?? 'Type' ?>:</th>
                        <td>
                            <?php if ($movement['type'] == 'add'): ?>
                                <span class="badge bg-success"><?= lang('App.stockIn') ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= lang('App.stockOut') ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= lang('App.quantity') ?>:</th>
                        <td>
                            <?php if ($movement['type'] == 'add'): ?>
                                <span class="text-success">+<?= $movement['quantity'] ?></span>
                            <?php else: ?>
                                <span class="text-danger">-<?= $movement['quantity'] ?></span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <th><?= lang('App.reason') ?>:</th>
                        <td><?= esc($movement['reason']) ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('App.user') ?? 'User' ?>:</th>
                        <td><?= esc($movement['user_name']) ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('App.batch') ?>:</th>
                        <td><?= esc($movement['batch_number'] ?? '-') ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('App.expiry') ?>:</th>
                        <td><?= !empty($movement['expiry_date']) ? date('d-m-Y', strtotime($movement['expiry_date'])) : '-' ?></td>
                    </tr>
                    <tr>
                        <th><?= lang('App.warehouse') ?? 'Warehouse' ?>:</th>
                        <td><?= esc($movement['warehouse_name'] ?? '-') ?></td>
                    </tr>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?= lang('App.close') ?? 'Close' ?></button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#stockMovementsTable').DataTable({
            "order": [[ 0, "desc" ]], // Sort by date (newest first)
            "language": {
                "lengthMenu": "<?= lang('App.show') ?? 'Show' ?> _MENU_ <?= lang('App.entries') ?? 'entries' ?>",
                "search": "<?= lang('App.search') ?>:",
                "info": "<?= lang('App.showing') ?? 'Showing' ?> _START_ <?= lang('App.to') ?? 'to' ?> _END_ <?= lang('App.of') ?? 'of' ?> _TOTAL_ <?= lang('App.entries') ?? 'entries' ?>",
                "paginate": {
                    "first": "<?= lang('App.first') ?? 'First' ?>",
                    "last": "<?= lang('App.last') ?? 'Last' ?>",
                    "next": "<?= lang('App.next') ?? 'Next' ?>",
                    "previous": "<?= lang('App.previous') ?? 'Previous' ?>"
                }
            }
        });
    });
    
    // Export to Excel function
    function exportToExcel() {
        const table = document.getElementById('stockMovementsTable');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Stock Movements"});
        <?php if (isset($product)): ?>
        XLSX.writeFile(wb, '<?= esc($product['name']) ?>_stock_movements_<?= date('Y-m-d') ?>.xlsx');
        <?php else: ?>
        XLSX.writeFile(wb, 'stock_movements_<?= date('Y-m-d') ?>.xlsx');
        <?php endif; ?>
    }
</script>
<?= $this->endSection() ?>