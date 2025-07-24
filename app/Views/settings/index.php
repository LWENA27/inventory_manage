<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.settings') ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= lang('App.systemSettings') ?? 'System Settings' ?></h1>
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success"> <?= session()->getFlashdata('success') ?> </div>
    <?php endif; ?>
    <form action="<?= site_url('settings/update') ?>" method="post">
        <?= csrf_field() ?>
        <div class="mb-3">
            <label for="system_name" class="form-label">System Name</label>
            <input type="text" class="form-control" id="system_name" name="system_name" value="<?= esc($settings['system_name'] ?? '') ?>" required>
        </div>
        <div class="mb-3">
            <label for="logo" class="form-label">Logo URL</label>
            <input type="text" class="form-control" id="logo" name="logo" value="<?= esc($settings['logo'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="footer" class="form-label">Footer Text</label>
            <input type="text" class="form-control" id="footer" name="footer" value="<?= esc($settings['footer'] ?? '') ?>">
        </div>
        <div class="mb-3">
            <label for="currency" class="form-label">Currency</label>
            <input type="text" class="form-control" id="currency" name="currency" value="<?= esc($settings['currency'] ?? 'TZS') ?>">
        </div>
        <div class="mb-3">
            <label for="tax" class="form-label">Default Tax (%)</label>
            <input type="number" class="form-control" id="tax" name="tax" value="<?= esc($settings['tax'] ?? '0') ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Settings</button>
    </form>
</div>
<?= $this->endSection() ?>
