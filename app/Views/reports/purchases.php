<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.purchasesReport') ?? 'Purchases Report' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-shopping-cart me-2"></i> <?= lang('App.purchasesReport') ?? 'Purchases Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.purchasesReport') ?? 'Purchases Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.purchasesReportDesc') ?? 'Track purchase orders, expenses, and supplier performance.' ?></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.date') ?? 'Date' ?></th>
                            <th><?= lang('App.totalPurchases') ?? 'Total Purchases' ?></th>
                            <th><?= lang('App.expenses') ?? 'Expenses' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-07-24</td>
                            <td>8</td>
                            <td>200,000 TZS</td>
                        </tr>
                        <tr>
                            <td>2025-07-23</td>
                            <td>6</td>
                            <td>150,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <canvas id="purchasesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulated data
const purchasesLabels = ["2025-07-23", "2025-07-24"];
const purchasesData = [150000, 200000];
const ctxP = document.getElementById('purchasesChart').getContext('2d');
const purchasesChart = new Chart(ctxP, {
    type: 'bar',
    data: {
        labels: purchasesLabels,
        datasets: [{
            label: '<?= lang('App.expenses') ?? 'Expenses' ?>',
            data: purchasesData,
            backgroundColor: 'rgba(255, 99, 132, 0.5)',
            borderColor: 'rgba(255, 99, 132, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.purchasesReport') ?? 'Purchases Report' ?>' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?= $this->endSection() ?>
