<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('Trial.statusTitle') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="h3 mb-0 text-gray-800"><?= lang('Trial.statusTitle') ?></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('Trial.statusInfo') ?? 'Trial Information' ?></h6>
                </div>
                <div class="card-body">
                    <?php if ($status['active']): ?>
                        <div class="alert alert-info">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-info-circle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading"><?= lang('Trial.active') ?? 'Your Trial is Active' ?></h5>
                                    <p class="mb-0"><?= lang('Trial.daysLeft') ?>: <strong><?= round($status['days_left']) ?> <?= lang('Trial.days') ?? 'days' ?></strong></p>
                                </div>
                            </div>
                        </div>
                        
                        <p><?= lang('Trial.enjoyFeatures') ?? 'Enjoy all features of the system during your trial period.' ?></p>
                        
                        <div class="progress mb-3">
                            <?php 
                            // Calculate percentage of trial remaining (assuming 30-day trial)
                            $totalDays = 30;
                            $daysUsed = $totalDays - $status['days_left'];
                            $percentUsed = min(100, max(0, ($daysUsed / $totalDays) * 100));
                            ?>
                            <div class="progress-bar bg-info" role="progressbar" style="width: <?= $percentUsed ?>%" 
                                 aria-valuenow="<?= $percentUsed ?>" aria-valuemin="0" aria-valuemax="100">
                                <?= round($percentUsed) ?>%
                            </div>
                        </div>
                        
                        <p class="text-muted small"><?= lang('Trial.upgradeInfo') ?? 'To continue using the system after your trial ends, please upgrade to a paid plan.' ?></p>
                        
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <div class="d-flex align-items-center">
                                <div class="me-3">
                                    <i class="fas fa-exclamation-triangle fa-2x"></i>
                                </div>
                                <div>
                                    <h5 class="alert-heading"><?= lang('Trial.expired') ?></h5>
                                    <p class="mb-0"><?= lang('Trial.expiredInfo') ?? 'Your trial period has ended.' ?></p>
                                </div>
                            </div>
                        </div>
                        
                        <p><?= lang('Trial.upgradeNow') ?? 'Please upgrade to a paid plan to continue using all features of the system.' ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('Trial.upgradePlan') ?? 'Upgrade Plan' ?></h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-crown fa-3x text-warning mb-3"></i>
                        <h5><?= lang('Trial.premiumFeatures') ?? 'Premium Features' ?></h5>
                        <p class="text-muted"><?= lang('Trial.unlockAll') ?? 'Unlock all features with a premium plan' ?></p>
                    </div>
                    
                    <ul class="list-group mb-4">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= lang('Trial.unlimitedProducts') ?? 'Unlimited Products' ?>
                            <i class="fas fa-check text-success"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= lang('Trial.multipleUsers') ?? 'Multiple Users' ?>
                            <i class="fas fa-check text-success"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= lang('Trial.advancedReports') ?? 'Advanced Reports' ?>
                            <i class="fas fa-check text-success"></i>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <?= lang('Trial.prioritySupport') ?? 'Priority Support' ?>
                            <i class="fas fa-check text-success"></i>
                        </li>
                    </ul>
                    
                    <div class="d-grid">
                        <a href="#" class="btn btn-success btn-lg">
                            <i class="fas fa-arrow-circle-up me-2"></i> <?= lang('Trial.upgradeButton') ?? 'Upgrade Now' ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
