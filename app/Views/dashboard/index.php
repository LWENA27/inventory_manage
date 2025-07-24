<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.dashboard') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800"><?= lang('App.dashboard') ?></h1>
        </div>
    </div>

    <!-- Trial Status Alert -->
    <?php if (isset($status)): ?>
        <?php if ($status['active']): ?>
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i>
                <?= lang('Dashboard.trialStatus') ?>: <?= lang('Trial.daysLeft') ?>: <strong><?= round($status['days_left']) ?></strong>
            </div>
        <?php else: ?>
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?= lang('Dashboard.trialStatus') ?>: <strong><?= lang('Trial.expired') ?></strong>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Quick Stats -->
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                <?= lang('App.todaySales') ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">TZS <?= esc(number_format($todaySales ?? 0, 2)) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
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
                                <?= lang('App.monthSales') ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">TZS <?= esc(number_format($monthSales ?? 0, 2)) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
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
                                <?= lang('App.products') ?></div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($productCount ?? 0) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box fa-2x text-gray-300"></i>
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
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= esc($lowStockCount ?? 0) ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Sales & Top Products -->
    <div class="row">
        <!-- Recent Sales -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.recentSales') ?></h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentSales)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th><?= lang('App.date') ?></th>
                                        <th><?= lang('App.customer') ?></th>
                                        <th><?= lang('App.total') ?></th>
                                        <th><?= lang('App.status') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recentSales as $sale): ?>
                                        <tr>
                                            <td><?= esc(date('Y-m-d', strtotime($sale['created_at']))) ?></td>
                                            <td><?= esc($sale['customer_name'] ?? '-') ?></td>
                                            <td><?= esc(number_format($sale['total'], 2)) ?></td>
                                            <td><?= esc($sale['status']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <?= lang('noRecords') ?? 'No sales records found. Start selling to see data here.' ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Top Products -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.topProducts') ?></h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($topProducts)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0">
                                <thead>
                                    <tr>
                                        <th><?= lang('App.productName') ?></th>
                                        <th><?= lang('App.quantity') ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($topProducts as $tp): ?>
                                        <tr>
                                            <td><?= esc($tp['name']) ?></td>
                                            <td><?= esc($tp['qty']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            <?= lang('noRecords') ?? 'No product data available yet.' ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Getting Started Guide -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.gettingStarted') ?? 'Getting Started' ?></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-primary h-100">
                                <div class="card-body">
                                    <h5><i class="fas fa-box me-2"></i> <?= lang('addProducts') ?? 'Add Products' ?></h5>
                                    <p><?= lang('addProductsDesc') ?? 'Start by adding your products to the inventory.' ?></p>
                                    <a href="<?= site_url('products/create') ?>" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i> <?= lang('App.addProduct') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-success h-100">
                                <div class="card-body">
                                    <h5><i class="fas fa-cash-register me-2"></i> <?= lang('makeSale') ?? 'Make a Sale' ?></h5>
                                    <p><?= lang('makeSaleDesc') ?? 'Use the POS system to record sales and generate receipts.' ?></p>
                                    <a href="<?= site_url('pos') ?>" class="btn btn-success btn-sm">
                                        <i class="fas fa-cash-register me-1"></i> <?= lang('App.pos') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card border-left-info h-100">
                                <div class="card-body">
                                    <h5><i class="fas fa-cog me-2"></i> <?= lang('setupSystem') ?? 'Setup System' ?></h5>
                                    <p><?= lang('setupSystemDesc') ?? 'Configure your business settings, users, and preferences.' ?></p>
                                    <a href="<?= site_url('settings') ?>" class="btn btn-info btn-sm">
                                        <i class="fas fa-cog me-1"></i> <?= lang('App.settings') ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    // Dashboard specific JavaScript can go here
    $(document).ready(function() {
        console.log('Dashboard loaded');
    });
</script>
<?= $this->endSection() ?>
