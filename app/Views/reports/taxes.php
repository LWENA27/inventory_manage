<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.taxReport') ?? 'Tax Report' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-file-invoice-dollar me-2"></i> <?= lang('App.taxReport') ?? 'Tax Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.taxReport') ?? 'Tax Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.taxReportDesc') ?? 'Track tax collected and paid for compliance reporting.' ?></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.date') ?? 'Date' ?></th>
                            <th><?= lang('App.taxCollected') ?? 'Tax Collected' ?></th>
                            <th><?= lang('App.taxPaid') ?? 'Tax Paid' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-07-24</td>
                            <td>45,000 TZS</td>
                            <td>40,000 TZS</td>
                        </tr>
                        <tr>
                            <td>2025-07-23</td>
                            <td>36,000 TZS</td>
                            <td>32,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <canvas id="taxesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulated data
const taxesLabels = ["2025-07-23", "2025-07-24"];
const taxCollected = [36000, 45000];
const taxPaid = [32000, 40000];
const ctxT = document.getElementById('taxesChart').getContext('2d');
const taxesChart = new Chart(ctxT, {
    type: 'bar',
    data: {
        labels: taxesLabels,
        datasets: [
            {
                label: '<?= lang('App.taxCollected') ?? 'Tax Collected' ?>',
                data: taxCollected,
                backgroundColor: 'rgba(255, 206, 86, 0.7)',
                borderColor: 'rgba(255, 206, 86, 1)',
                borderWidth: 1
            },
            {
                label: '<?= lang('App.taxPaid') ?? 'Tax Paid' ?>',
                data: taxPaid,
                backgroundColor: 'rgba(255, 99, 132, 0.5)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.taxReport') ?? 'Tax Report' ?>' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?= $this->endSection() ?>
