<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="container mt-4">
    <h2><?= lang('App.profile') ?></h2>
    <div class="card mt-3">
        <div class="card-body">
            <?php if ($user): ?>
                <p><strong><?= lang('userName') ?>:</strong> <?= esc($user['username'] ?? '-') ?></p>
                <p><strong><?= lang('App.email') ?>:</strong> <?= esc($user['email'] ?? '-') ?></p>
            <?php else: ?>
                <p><?= lang('noRecords') ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
