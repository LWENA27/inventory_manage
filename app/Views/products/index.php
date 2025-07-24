<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.products') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.productList') ?></h1>
        <a href="<?= site_url('products/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> <?= lang('App.addProduct') ?>
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.search') ?> & <?= lang('App.filter') ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Search Form -->
                <div class="col-md-6 mb-3">
                    <form action="<?= site_url('products/search') ?>" method="get" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="<?= lang('App.search') ?>..." value="<?= isset($keyword) ? $keyword : '' ?>">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                
                <!-- Category Filter -->
                <div class="col-md-6 mb-3">
                    <form action="<?= site_url('products/category') ?>" method="get" class="d-flex">
                        <div class="input-group">
                            <select name="category" class="form-select">
                                <option value=""><?= lang('App.allCategories') ?? 'All Categories' ?></option>
                                <?php 
                                // This would normally be populated from the database
                                $categories = ['Electronics', 'Clothing', 'Food', 'Medicine', 'Other'];
                                foreach ($categories as $cat): 
                                ?>
                                <option value="<?= $cat ?>" <?= (isset($category) && $category == $cat) ? 'selected' : '' ?>><?= $cat ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button class="btn btn-secondary" type="submit">
                                <i class="fas fa-filter"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <!-- Quick Links -->
            <div class="mt-2">
                <a href="<?= site_url('products') ?>" class="btn btn-sm btn-outline-secondary me-2">
                    <i class="fas fa-list"></i> <?= lang('App.allProducts') ?? 'All Products' ?>
                </a>
                <a href="<?= site_url('products/low-stock') ?>" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-exclamation-triangle"></i> <?= lang('App.lowStock') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?= lang('App.products') ?>
                <?php if (isset($keyword)): ?>
                    - <?= lang('App.searchResults') ?? 'Search Results' ?>: "<?= $keyword ?>"
                <?php elseif (isset($category)): ?>
                    - <?= lang('App.category') ?>: <?= $category ?>
                <?php endif; ?>
            </h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            
            <?php if (empty($products)): ?>
                <div class="alert alert-info">
                    <i class="fas fa-info-circle me-2"></i> <?= lang('App.noProducts') ?? 'No products found.' ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="productsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="60"><?= lang('App.image') ?></th>
                                <th><?= lang('App.productName') ?></th>
                                <th><?= lang('App.price') ?></th>
                                <th><?= lang('App.category') ?></th>
                                <th><?= lang('App.stock') ?></th>
                                <th width="150"><?= lang('App.actions') ?? 'Actions' ?></th>
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
                                    <?= esc($product['name']) ?>
                                    <?php if ($product['barcode']): ?>
                                        <br><small class="text-muted"><?= lang('App.barcode') ?>: <?= $product['barcode'] ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><?= number_format($product['price'], 2) ?></td>
                                <td><?= esc($product['category'] ?? '-') ?></td>
                                <td>
                                    <?php if ($product['stock'] <= 10): ?>
                                        <span class="badge bg-warning text-dark"><?= $product['stock'] ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-success"><?= $product['stock'] ?></span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= site_url('products/' . $product['id']) ?>" class="btn btn-sm btn-info" title="<?= lang('App.view') ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-sm btn-primary" title="<?= lang('App.edit') ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id'] . '/delete') ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('<?= lang('App.deleteConfirm') ?? 'Are you sure you want to delete this product?' ?>')" title="<?= lang('App.delete') ?>">
                                        <i class="fas fa-trash"></i>
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
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        // Initialize DataTable for better sorting and pagination
        $('#productsTable').DataTable({
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