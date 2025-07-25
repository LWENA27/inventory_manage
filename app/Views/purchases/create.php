<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('createPurchase') ?? 'Create Purchase' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-shopping-cart me-2"></i> <?= lang('createPurchase') ?? 'Create Purchase' ?></h1>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('purchaseDetails') ?? 'Purchase Details' ?>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
            <?php endif; ?>
            <form action="<?= site_url('purchases/store') ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="product_id" class="form-label">Product</label>
                    <select class="form-select" id="product_id" name="product_id" required>
                        <option value="">Select Product</option>
                        <?php if (!empty($products)) : foreach ($products as $product): ?>
                            <option value="<?= esc($product['id']) ?>"><?= esc($product['name']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="quantity" class="form-label">Quantity</label>
                    <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Unit Price</label>
                    <input type="number" step="0.01" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="supplier_id" class="form-label">Supplier</label>
                    <select class="form-select" id="supplier_id" name="supplier_id" required>
                        <option value="">Select Supplier</option>
                        <?php if (!empty($suppliers)) : foreach ($suppliers as $supplier): ?>
                            <option value="<?= esc($supplier['id']) ?>"><?= esc($supplier['name']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="warehouse_id" class="form-label">Warehouse</label>
                    <select class="form-select" id="warehouse_id" name="warehouse_id" required>
                        <option value="">Select Warehouse</option>
                        <?php if (!empty($warehouses)) : foreach ($warehouses as $warehouse): ?>
                            <option value="<?= esc($warehouse['id']) ?>"><?= esc($warehouse['name']) ?></option>
                        <?php endforeach; endif; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="purchase_date" class="form-label">Purchase Date</label>
                    <input type="date" class="form-control" id="purchase_date" name="purchase_date" value="<?= date('Y-m-d') ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Purchase</button>
                <a href="<?= site_url('purchases') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
