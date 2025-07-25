<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.manageCategory') ?? 'Manage Categories' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-tags me-2"></i> <?= lang('App.manageCategory') ?? 'Manage Categories' ?></h1>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.categoryList') ?? 'Category List' ?>
            <button class="btn btn-success btn-sm float-end" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fas fa-plus"></i> <?= lang('App.addCategory') ?? 'Add Category' ?>
            </button>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th><?= lang('App.category') ?></th>
                        <th><?= lang('App.actions') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($categories)): ?>
                        <?php foreach ($categories as $cat): ?>
                            <tr>
                                <td><?= esc($cat['name']) ?></td>
                                <td>
                                    <a href="<?= site_url('settings/category/edit/' . $cat['id']) ?>" class="btn btn-sm btn-primary"><i class="fas fa-edit"></i></a>
                                    <a href="<?= site_url('settings/category/delete/' . $cat['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this category?')"><i class="fas fa-trash"></i></a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="2" class="text-center">No categories found.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <!-- Add Category Modal -->
    <div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="<?= site_url('settings/category/add') ?>" method="post">
                    <?= csrf_field() ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="addCategoryModalLabel"><?= lang('App.addCategory') ?? 'Add Category' ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="category_name" class="form-label">Category Name</label>
                            <input type="text" class="form-control" id="category_name" name="name" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
