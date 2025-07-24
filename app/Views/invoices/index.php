<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= $title ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.invoices') ?? 'Invoices' ?></h1>
        <a href="<?= site_url('invoices/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus-circle me-1"></i> <?= lang('App.createInvoice') ?? 'Create Invoice' ?>
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
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.invoicesList') ?? 'Invoices List' ?></h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="invoicesTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><?= lang('App.invoiceNumber') ?? 'Invoice Number' ?></th>
                            <th><?= lang('App.customer') ?? 'Customer' ?></th>
                            <th><?= lang('App.date') ?? 'Date' ?></th>
                            <th><?= lang('App.amount') ?? 'Amount' ?></th>
                            <th><?= lang('App.status') ?? 'Status' ?></th>
                            <th><?= lang('App.actions') ?? 'Actions' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($invoices)): ?>
                            <tr>
                                <td colspan="6" class="text-center"><?= lang('App.noInvoices') ?? 'No invoices found' ?></td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($invoices as $invoice): ?>
                                <tr>
                                    <td><?= esc($invoice['invoice_number']) ?></td>
                                    <td><?= esc($invoice['customer_name']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($invoice['created_at'])) ?></td>
                                    <td>TZS <?= number_format($invoice['total_amount'], 2) ?></td>
                                    <td>
                                        <?php if ($invoice['status'] == 'paid'): ?>
                                            <span class="badge bg-success"><?= lang('App.paid') ?? 'Paid' ?></span>
                                        <?php elseif ($invoice['status'] == 'partial'): ?>
                                            <span class="badge bg-warning"><?= lang('App.partial') ?? 'Partial' ?></span>
                                        <?php else: ?>
                                            <span class="badge bg-danger"><?= lang('App.unpaid') ?? 'Unpaid' ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <a href="<?= site_url('invoices/' . $invoice['id']) ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= site_url('invoices/' . $invoice['id'] . '/edit') ?>" class="btn btn-sm btn-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= site_url('invoices/' . $invoice['id'] . '/print') ?>" class="btn btn-sm btn-secondary" target="_blank">
                                            <i class="fas fa-print"></i>
                                        </a>
                                        <a href="<?= site_url('invoices/' . $invoice['id'] . '/delete') ?>" class="btn btn-sm btn-danger" onclick="return confirm('<?= lang('App.deleteConfirm') ?? 'Are you sure you want to delete this invoice?' ?>')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
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
        $('#invoicesTable').DataTable();
    });
</script>
<?= $this->endSection() ?>