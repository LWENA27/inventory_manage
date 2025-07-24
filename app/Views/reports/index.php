<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.reports') ?? 'Reports' ?></h1>
    </div>

    <div class="row">
        <!-- Sales Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.salesReport') ?? 'Sales Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.salesReportDesc') ?? 'View sales data, revenue, and trends over time.' ?></p>
                    <a href="<?= site_url('reports/sales') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-chart-line me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Purchases Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.purchasesReport') ?? 'Purchases Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.purchasesReportDesc') ?? 'Track purchase orders, expenses, and supplier performance.' ?></p>
                    <a href="<?= site_url('reports/purchases') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-shopping-cart me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Inventory Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.inventoryReport') ?? 'Inventory Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.inventoryReportDesc') ?? 'Monitor stock levels, valuation, and inventory turnover.' ?></p>
                    <a href="<?= site_url('reports/inventory') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-boxes me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Profit Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.profitReport') ?? 'Profit Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.profitReportDesc') ?? 'Analyze profit margins, revenue, and cost of goods sold.' ?></p>
                    <a href="<?= site_url('reports/profit') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-dollar-sign me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Tax Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.taxReport') ?? 'Tax Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.taxReportDesc') ?? 'Track tax collected and paid for compliance reporting.' ?></p>
                    <a href="<?= site_url('reports/taxes') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-file-invoice-dollar me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Customer Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.customerReport') ?? 'Customer Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.customerReportDesc') ?? 'Analyze customer purchasing patterns and sales by customer.' ?></p>
                    <a href="<?= site_url('reports/customers') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-users me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>

        <!-- Supplier Report Card -->
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card shadow h-100">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.supplierReport') ?? 'Supplier Report' ?></h6>
                </div>
                <div class="card-body">
                    <p><?= lang('App.supplierReportDesc') ?? 'Track supplier performance, purchases, and payment history.' ?></p>
                    <a href="<?= site_url('reports/suppliers') ?>" class="btn btn-primary btn-block">
                        <i class="fas fa-truck me-1"></i> <?= lang('App.viewReport') ?? 'View Report' ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>