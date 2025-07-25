<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.editCategory') ?? 'Edit Category' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><i class="fas fa-tags me-2"></i> <?= lang('App.editCategory') ?? 'Edit Category' ?></h1>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.editCategory') ?? 'Edit Category' ?>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger"> <?= session()->getFlashdata('error') ?> </div>
            <?php endif; ?>
            <form action="<?= site_url('settings/category/edit/' . $category['id']) ?>" method="post">
                <?= csrf_field() ?>
                <div class="mb-3">
                    <label for="category_name" class="form-label">Category Name</label>
                    <input type="text" class="form-control" id="category_name" name="name" value="<?= esc($category['name']) ?>" required>
                </div>
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <a href="<?= site_url('settings/manage_category') ?>" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
