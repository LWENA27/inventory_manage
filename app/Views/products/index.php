<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('products') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('productList') ?></h1>
        <a href="<?= site_url('products/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle me-2"></i> <?= lang('addProduct') ?>
        </a>
    </div>

    <!-- Search and Filter -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('search') ?> & <?= lang('filter') ?></h6>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- Search Form -->
                <div class="col-md-6 mb-3">
                    <form action="<?= site_url('products/search') ?>" method="get" class="d-flex">
                        <div class="input-group">
                            <input type="text" class="form-control" name="keyword" placeholder="<?= lang('search') ?>..." value="<?= isset($keyword) ? $keyword : '' ?>">
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
                                <option value=""><?= lang('allCategories') ?? 'All Categories' ?></option>
                                <?php if (!empty($categories)) : foreach ($categories as $cat): ?>
                                    <option value="<?= esc($cat['name']) ?>" <?= (isset($category) && $category == $cat['name']) ? 'selected' : '' ?>><?= esc($cat['name']) ?></option>
                                <?php endforeach; endif; ?>
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
                    <i class="fas fa-list"></i> <?= lang('allProducts') ?? 'All Products' ?>
                </a>
                <a href="<?= site_url('products/low-stock') ?>" class="btn btn-sm btn-outline-warning">
                    <i class="fas fa-exclamation-triangle"></i> <?= lang('lowStock') ?>
                </a>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                <?= lang('products') ?>
                <?php if (isset($keyword)): ?>
                    - <?= lang('searchResults') ?? 'Search Results' ?>: "<?= $keyword ?>"
                <?php elseif (isset($category)): ?>
                    - <?= lang('category') ?>: <?= $category ?>
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
                    <i class="fas fa-info-circle me-2"></i> <?= lang('noProducts') ?? 'No products found.' ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="productsTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="60"><?= lang('image') ?></th>
                                <th><?= lang('productName') ?></th>
                                <th><?= lang('price') ?></th>
                                <th><?= lang('category') ?></th>
                                <th><?= lang('stock') ?></th>
                                <th width="150"><?= lang('actions') ?? 'Actions' ?></th>
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
                                        <br><small class="text-muted"><?= lang('barcode') ?>: <?= $product['barcode'] ?></small>
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
                                    <a href="<?= site_url('products/' . $product['id']) ?>" class="btn btn-sm btn-info" title="<?= lang('view') ?>">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id'] . '/edit') ?>" class="btn btn-sm btn-primary" title="<?= lang('edit') ?>">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?= site_url('products/' . $product['id'] . '/delete') ?>" class="btn btn-sm btn-danger" 
                                       onclick="return confirm('<?= lang('deleteConfirm') ?? 'Are you sure you want to delete this product?' ?>')" title="<?= lang('delete') ?>">
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
                "lengthMenu": "<?= lang('show') ?? 'Show' ?> _MENU_ <?= lang('entries') ?? 'entries' ?>",
                "search": "<?= lang('search') ?>:",
                "info": "<?= lang('showing') ?? 'Showing' ?> _START_ <?= lang('to') ?? 'to' ?> _END_ <?= lang('of') ?? 'of' ?> _TOTAL_ <?= lang('entries') ?? 'entries' ?>",
                "paginate": {
                    "first": "<?= lang('first') ?? 'First' ?>",
                    "last": "<?= lang('last') ?? 'Last' ?>",
                    "next": "<?= lang('next') ?? 'Next' ?>",
                    "previous": "<?= lang('previous') ?? 'Previous' ?>"
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>