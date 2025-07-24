<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.warehouseInventory') ?? 'Warehouse Inventory' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800">
            <?php if ($currentWarehouse): ?>
                <?= esc($currentWarehouse['name']) ?> - <?= lang('App.inventory') ?>
            <?php else: ?>
                <?= lang('App.warehouseInventory') ?? 'Warehouse Inventory' ?>
            <?php endif; ?>
        </h1>
        <div>
            <a href="<?= site_url('products/create') ?>" class="btn btn-primary me-2">
                <i class="fas fa-plus-circle me-2"></i> <?= lang('App.addProduct') ?>
            </a>
            <a href="<?= site_url('inventory') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <!-- Warehouse Selection Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.selectWarehouse') ?? 'Select Warehouse' ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($warehouses as $warehouse): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 <?= ($currentWarehouse && $currentWarehouse['id'] == $warehouse['id']) ? 'border-primary' : '' ?>">
                        <div class="card-body text-center">
                            <i class="fas fa-warehouse fa-3x <?= ($currentWarehouse && $currentWarehouse['id'] == $warehouse['id']) ? 'text-primary' : 'text-secondary' ?> mb-3"></i>
                            <h5><?= esc($warehouse['name']) ?></h5>
                            <?php
                            // Count products in this warehouse
                            $productCount = 0;
                            if ($currentWarehouse && $currentWarehouse['id'] == $warehouse['id']) {
                                $productCount = count($products);
                            } else {
                                foreach ($products as $product) {
                                    if ($product['warehouse_id'] == $warehouse['id']) {
                                        $productCount++;
                                    }
                                }
                            }
                            ?>
                            <p class="text-muted"><?= $productCount ?> <?= lang('App.products') ?></p>
                            <a href="<?= site_url('inventory/warehouse/' . $warehouse['id']) ?>" class="btn btn-<?= ($currentWarehouse && $currentWarehouse['id'] == $warehouse['id']) ? 'primary' : 'outline-primary' ?> btn-sm">
                                <?= ($currentWarehouse && $currentWarehouse['id'] == $warehouse['id']) ? lang('App.currentlyViewing') ?? 'Currently Viewing' : lang('App.view') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                
                <div class="col-md-4 mb-4">
                    <div class="card h-100 <?= (!$currentWarehouse) ? 'border-primary' : '' ?>">
                        <div class="card-body text-center">
                            <i class="fas fa-boxes fa-3x <?= (!$currentWarehouse) ? 'text-primary' : 'text-secondary' ?> mb-3"></i>
                            <h5><?= lang('App.allWarehouses') ?? 'All Warehouses' ?></h5>
                            <p class="text-muted"><?= count($products) ?> <?= lang('App.products') ?></p>
                            <a href="<?= site_url('inventory/warehouse') ?>" class="btn btn-<?= (!$currentWarehouse) ? 'primary' : 'outline-primary' ?> btn-sm">
                                <?= (!$currentWarehouse) ? lang('App.currentlyViewing') ?? 'Currently Viewing' : lang('App.view') ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">
                <?php if ($currentWarehouse): ?>
                    <?= esc($currentWarehouse['name']) ?> - <?= lang('App.products') ?>
                <?php else: ?>
                    <?= lang('App.allProducts') ?? 'All Products' ?>
                <?php endif; ?>
            </h6>
            <div>
                <button type="button" class="btn btn-sm btn-success" onclick="exportToExcel()">
                    <i class="fas fa-file-excel me-1"></i> <?= lang('App.export') ?>
                </button>
            </div>
        </div>
        <div class="card-body">
            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> <?= lang('App.noProducts') ?? 'No products found.' ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="warehouseProductsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th><?= lang('App.productName') ?></th>
                                <th><?= lang('App.sku') ?></th>
                                <th><?= lang('App.category') ?></th>
                                <th><?= lang('App.price') ?></th>
                                <th><?= lang('App.stock') ?></th>
                                <th><?= lang('App.warehouse') ?></th>
                                <th><?= lang('App.actions') ?? 'Actions' ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td>
                                    <a href="<?= site_url('products/' . $product['id']) ?>">
                                        <?= esc($product['name']) ?>
                                    </a>
                                </td>
                                <td><?= esc($product['sku'] ?? '-') ?></td>
                                <td><?= esc($product['category'] ?? '-') ?></td>
                                <td>TZS <?= number_format($product['price'], 2) ?></td>
                                <td>
                                    <?php if ($product['stock'] <= 10): ?>
                                        <span class="badge bg-warning text-dark"><?= $product['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $product['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    $warehouseName = 'Default';
                                    foreach ($warehouses as $warehouse) {
                                        if ($warehouse['id'] == $product['warehouse_id']) {
                                            $warehouseName = $warehouse['name'];
                                            break;
                                        }
                                    }
                                    echo esc($warehouseName);
                                    ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('inventory/adjust/' . $product['id']) ?>" class="btn btn-sm btn-success" title="<?= lang('App.adjustStock') ?? 'Adjust Stock' ?>">
                                        <i class="fas fa-balance-scale"></i>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-sm btn-primary" title="<?= lang('App.edit') ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id']) ?>" class="btn btn-sm btn-info" title="<?= lang('App.view') ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Warehouse Statistics Card -->
    <?php if ($currentWarehouse): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= esc($currentWarehouse['name']) ?> - <?= lang('App.statistics') ?? 'Statistics' ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="card border-left-primary h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        <?= lang('App.totalProducts') ?? 'Total Products' ?></div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= count($products) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-boxes fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card border-left-success h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        <?= lang('App.totalValue') ?? 'Total Value' ?></div>
                                    <?php
                                    $totalValue = 0;
                                    foreach ($products as $product) {
                                        $totalValue += $product['price'] * $product['stock'];
                                    }
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">TZS <?= number_format($totalValue, 2) ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4 mb-4">
                    <div class="card border-left-warning h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        <?= lang('App.lowStock') ?></div>
                                    <?php
                                    $lowStockCount = 0;
                                    foreach ($products as $product) {
                                        if ($product['stock'] <= 10) {
                                            $lowStockCount++;
                                        }
                                    }
                                    ?>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $lowStockCount ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#warehouseProductsTable').DataTable({
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
        const table = document.getElementById('warehouseProductsTable');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Warehouse Inventory"});
        <?php if ($currentWarehouse): ?>
        XLSX.writeFile(wb, '<?= esc($currentWarehouse['name']) ?>_inventory_<?= date('Y-m-d') ?>.xlsx');
        <?php else: ?>
        XLSX.writeFile(wb, 'all_warehouses_inventory_<?= date('Y-m-d') ?>.xlsx');
        <?php endif; ?>
    }
</script>
<?= $this->endSection() ?>