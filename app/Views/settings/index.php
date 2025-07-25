<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('settings') ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= lang('systemSettings') ?></h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong><?= lang('systemSettings') ?></strong>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('settings/update') ?>" method="post">
                        <?= csrf_field() ?>
                        <div class="mb-3">
                            <label for="system_name" class="form-label"><?= lang('systemName') ?></label>
                            <input type="text" class="form-control" id="system_name" name="system_name" value="<?= esc($settings['system_name']) ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="logo" class="form-label"><?= lang('logoUrl') ?></label>
                            <input type="text" class="form-control" id="logo" name="logo" value="<?= esc($settings['logo']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="footer" class="form-label"><?= lang('footerText') ?></label>
                            <input type="text" class="form-control" id="footer" name="footer" value="<?= esc($settings['footer']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="currency" class="form-label"><?= lang('currency') ?></label>
                            <input type="text" class="form-control" id="currency" name="currency" value="<?= esc($settings['currency']) ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tax" class="form-label"><?= lang('defaultTax') ?></label>
                            <input type="number" class="form-control" id="tax" name="tax" value="<?= esc($settings['tax']) ?>">
                        </div>
                        <button type="submit" class="btn btn-primary"><?= lang('saveSettings') ?></button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-light">
                    <strong><?= lang('productSettings') ?></strong>
                </div>
                <div class="card-body">
                    <a href="<?= site_url('settings/manage_category') ?>" class="btn btn-outline-primary mb-2">
                        <i class="fas fa-tags"></i> <?= lang('manageCategory') ?>
                    </a>
                    <p class="text-muted"><?= lang('categoryHelpText') ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
