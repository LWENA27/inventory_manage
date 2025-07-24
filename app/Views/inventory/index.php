<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.inventory') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.inventory') ?></h1>
        <div>
            <a href="<?= site_url('products/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i> <?= lang('App.addProduct') ?>
            </a>
        </div>
    </div>

    <!-- Inventory Overview Cards -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
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

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                <?= lang('App.lowStock') ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $lowStockCount ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                <?= lang('App.totalWarehouses') ?? 'Total Warehouses' ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">2</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-warehouse fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                <?= lang('App.inventoryValue') ?? 'Inventory Value' ?></div>
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
    </div>

    <!-- Inventory Management Options -->
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.inventoryManagement') ?? 'Inventory Management' ?></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-boxes fa-3x text-primary mb-3"></i>
                                    <h5><?= lang('App.stockManagement') ?? 'Stock Management' ?></h5>
                                    <p class="text-muted"><?= lang('App.stockManagementDesc') ?? 'View and manage your product stock levels.' ?></p>
                                    <a href="<?= site_url('products') ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-arrow-right me-1"></i> <?= lang('App.manage') ?? 'Manage' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-warehouse fa-3x text-info mb-3"></i>
                                    <h5><?= lang('App.warehouseManagement') ?? 'Warehouse Management' ?></h5>
                                    <p class="text-muted"><?= lang('App.warehouseManagementDesc') ?? 'Manage stock across multiple warehouses.' ?></p>
                                    <a href="<?= site_url('inventory/warehouse') ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-arrow-right me-1"></i> <?= lang('App.manage') ?? 'Manage' ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-exchange-alt fa-3x text-success mb-3"></i>
                                    <h5><?= lang('App.stockMovements') ?? 'Stock Movements' ?></h5>
                                    <p class="text-muted"><?= lang('App.stockMovementsDesc') ?? 'Track all stock movements and adjustments.' ?></p>
                                    <a href="<?= site_url('inventory/history') ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-arrow-right me-1"></i> <?= lang('App.view') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-chart-pie fa-3x text-warning mb-3"></i>
                                    <h5><?= lang('App.inventoryValuation') ?? 'Inventory Valuation' ?></h5>
                                    <p class="text-muted"><?= lang('App.inventoryValuationDesc') ?? 'View the financial value of your inventory.' ?></p>
                                    <a href="<?= site_url('inventory/valuation') ?>" class="btn btn-warning btn-sm">
                                        <i class="fas fa-arrow-right me-1"></i> <?= lang('App.view') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Low Stock Alert Card -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-warning"><?= lang('App.lowStockAlert') ?? 'Low Stock Alert' ?></h6>
                    <a href="<?= site_url('products/low-stock') ?>" class="btn btn-sm btn-warning">
                        <?= lang('App.viewAll') ?? 'View All' ?>
                    </a>
                </div>
                <div class="card-body">
                    <?php if ($lowStockCount == 0): ?>
                        <div class="alert alert-success">
                            <i class="fas fa-check-circle me-2"></i> <?= lang('App.noLowStock') ?? 'No products with low stock found.' ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-exclamation-triangle me-2"></i> <?= lang('App.lowStockWarning') ?? 'You have products with low stock that need attention.' ?>
                        </div>
                        
                        <div class="list-group">
                            <?php 
                            $lowStockProducts = array_filter($products, function($product) {
                                return $product['stock'] <= 10;
                            });
                            
                            $count = 0;
                            foreach ($lowStockProducts as $product): 
                                if ($count >= 5) break; // Show only 5 products
                                $count++;
                            ?>
                                <a href="<?= site_url('products/' . $product['id']) ?>" class="list-group-item list-group-item-action">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h6 class="mb-1"><?= esc($product['name']) ?></h6>
                                        <span class="badge bg-warning text-dark"><?= $product['stock'] ?></span>
                                    </div>
                                    <small class="text-muted"><?= esc($product['category'] ?? '-') ?></small>
                                </a>
                            <?php endforeach; ?>
                        </div>
                        
                        <?php if ($lowStockCount > 5): ?>
                            <div class="text-center mt-3">
                                <small class="text-muted"><?= lang('App.andMore') ?? 'And' ?> <?= $lowStockCount - 5 ?> <?= lang('App.more') ?? 'more' ?></small>
                            </div>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>