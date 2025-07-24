<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.lowStock') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.lowStock') ?></h1>
        <div>
            <a href="<?= site_url('products/create') ?>" class="btn btn-primary me-2">
                <i class="fas fa-plus-circle me-2"></i> <?= lang('App.addProduct') ?>
            </a>
            <a href="<?= site_url('products') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <!-- Threshold Setting Card -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.stockAlert') ?></h6>
        </div>
        <div class="card-body">
            <form action="<?= site_url('products/low-stock') ?>" method="get" class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <label for="threshold" class="form-label"><?= lang('App.minStock') ?></label>
                    <div class="input-group">
                        <input type="number" class="form-control" id="threshold" name="threshold" value="<?= $threshold ?? 10 ?>" min="1">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-filter me-2"></i> <?= lang('App.filter') ?>
                        </button>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="alert alert-warning mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i> 
                        <?= lang('App.lowStockAlert') ?? 'Products with stock below the threshold will be displayed.' ?>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Low Stock Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?= lang('App.lowStockProducts') ?? 'Low Stock Products' ?> 
                (<?= lang('App.threshold') ?? 'Threshold' ?>: <?= $threshold ?? 10 ?>)
            </h6>
        </div>
        <div class="card-body">
            <?php if (empty($products)): ?>
                <div class="alert alert-success">
                    <i class="fas fa-check-circle me-2"></i> <?= lang('App.noLowStock') ?? 'No products with low stock found. Your inventory is in good shape!' ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="lowStockTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="60"><?= lang('App.image') ?></th>
                                <th><?= lang('App.productName') ?></th>
                                <th><?= lang('App.price') ?></th>
                                <th><?= lang('App.category') ?></th>
                                <th><?= lang('App.stock') ?></th>
                                <th width="200"><?= lang('App.actions') ?? 'Actions' ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($products as $product): ?>
                            <tr>
                                <td class="text-center">
                                    <?php if ($product['image']): ?>
                                        <img src="<?= base_url($product['image']) ?>" alt="<?= $product['name'] ?>" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                    <?php else: ?>
                                        <i class="fas fa-box fa-2x text-secondary"></i>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('products/' . $product['id']) ?>">
                                        <?= esc($product['name']) ?>
                                    </a>
                                    <?php if ($product['barcode']): ?>
                                        <br><small class="text-muted"><?= lang('App.barcode') ?>: <?= $product['barcode'] ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($product['price'], 2) ?></td>
                                <td><?= esc($product['category'] ?? '-') ?></td>
                                <td>
                                    <span class="badge bg-warning text-dark"><?= $product['stock'] ?></span>
                                </td>
                                <td>
                                    <a href="<?= site_url('inventory/adjust/' . $product['id']) ?>" class="btn btn-sm btn-success" title="<?= lang('App.addStock') ?>">
                                        <i class="fas fa-plus-circle"></i> <?= lang('App.addStock') ?>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-sm btn-primary" title="<?= lang('App.edit') ?>">
                                        <i class="fas fa-edit"></i>
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
    
    <!-- Restock Suggestions -->
    <?php if (!empty($products)): ?>
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.restockSuggestions') ?? 'Restock Suggestions' ?></h6>
        </div>
        <div class="card-body">
            <div class="alert alert-info">
                <i class="fas fa-info-circle me-2"></i> <?= lang('App.restockInfo') ?? 'Based on your inventory levels, we recommend restocking the following products:' ?>
            </div>
            
            <div class="row">
                <?php foreach (array_slice($products, 0, 3) as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= esc($product['name']) ?></h5>
                            <p class="card-text">
                                <strong><?= lang('App.currentStock') ?>:</strong> <?= $product['stock'] ?><br>
                                <strong><?= lang('App.suggestedOrder') ?? 'Suggested Order' ?>:</strong> <?= max(10, $product['stock'] * 3) ?>
                            </p>
                        </div>
                        <div class="card-footer">
                            <a href="<?= site_url('inventory/adjust/' . $product['id']) ?>" class="btn btn-sm btn-success w-100">
                                <i class="fas fa-plus-circle me-2"></i> <?= lang('App.addStock') ?>
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTable for better sorting and pagination
        $('#lowStockTable').DataTable({
            "order": [[ 4, "asc" ]], // Sort by stock (ascending)
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
</script>
<?= $this->endSection() ?>