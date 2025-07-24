<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.transfers') ?? 'Warehouse Transfers' ?></h1>
        <a href="<?= site_url('transfers/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> <?= lang('App.createTransfer') ?? 'Create Transfer' ?>
        </a>
    </div>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.transfersList') ?? 'Transfers List' ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="transfersTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= lang('App.transferNumber') ?? 'Transfer Number' ?></th>
                            <th><?= lang('App.fromWarehouse') ?? 'From Warehouse' ?></th>
                            <th><?= lang('App.toWarehouse') ?? 'To Warehouse' ?></th>
                            <th><?= lang('App.date') ?? 'Date' ?></th>
                            <th><?= lang('App.status') ?? 'Status' ?></th>
                            <th><?= lang('App.actions') ?? 'Actions' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" class="text-center"><?= lang('App.noTransfers') ?? 'No transfers found' ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    $(document).ready(function() {
        $('#transfersTable').DataTable();
    });
</script>
<?= $this->endSection() ?>