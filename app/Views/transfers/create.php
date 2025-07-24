<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= lang('App.createTransfer') ?? 'Create Transfer' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-exchange-alt me-2"></i> <?= lang('App.createTransfer') ?? 'Create Transfer' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.createTransfer') ?? 'Create Transfer' ?>
        </div>
        <div class="card-body">
            <form method="post" action="<?= site_url('transfers/store') ?>">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="from_warehouse" class="form-label"><?= lang('App.fromWarehouse') ?? 'From Warehouse' ?></label>
                    <select class="form-select" id="from_warehouse" name="from_warehouse" required>
                        <option value="">-- <?= lang('App.selectWarehouse') ?? 'Select Warehouse' ?> --</option>
                        <!-- Populate with warehouses -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="to_warehouse" class="form-label"><?= lang('App.toWarehouse') ?? 'To Warehouse' ?></label>
                    <select class="form-select" id="to_warehouse" name="to_warehouse" required>
                        <option value="">-- <?= lang('App.selectWarehouse') ?? 'Select Warehouse' ?> --</option>
                        <!-- Populate with warehouses -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="product" class="form-label"><?= lang('App.product') ?? 'Product' ?></label>
                    <select class="form-select" id="product" name="product" required>
                        <option value="">-- <?= lang('App.selectProduct') ?? 'Select Product' ?> --</option>
                        <!-- Populate with products -->
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label"><?= lang('App.quantity') ?? 'Quantity' ?></label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                </div>
                <button type="submit" class="btn btn-primary"><?= lang('App.save') ?? 'Save' ?></button>
                <a href="<?= site_url('transfers') ?>" class="btn btn-secondary ms-2"><?= lang('App.cancel') ?? 'Cancel' ?></a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
