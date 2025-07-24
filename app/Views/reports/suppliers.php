<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.supplierReport') ?? 'Supplier Report' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-truck me-2"></i> <?= lang('App.supplierReport') ?? 'Supplier Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.supplierReport') ?? 'Supplier Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.supplierReportDesc') ?? 'Track supplier performance, purchases, and payment history.' ?></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.supplier') ?? 'Supplier' ?></th>
                            <th><?= lang('App.totalPurchases') ?? 'Total Purchases' ?></th>
                            <th><?= lang('App.expenses') ?? 'Expenses' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>ABC Pharma</td>
                            <td>10</td>
                            <td>500,000 TZS</td>
                        </tr>
                        <tr>
                            <td>XYZ Distributors</td>
                            <td>7</td>
                            <td>350,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <canvas id="suppliersChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulated data
const suppliersLabels = ["ABC Pharma", "XYZ Distributors"];
const suppliersData = [500000, 350000];
const ctxS = document.getElementById('suppliersChart').getContext('2d');
const suppliersChart = new Chart(ctxS, {
    type: 'bar',
    data: {
        labels: suppliersLabels,
        datasets: [{
            label: '<?= lang('App.expenses') ?? 'Expenses' ?>',
            data: suppliersData,
            backgroundColor: 'rgba(255, 206, 86, 0.7)',
            borderColor: 'rgba(255, 206, 86, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.supplierReport') ?? 'Supplier Report' ?>' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?= $this->endSection() ?>
