<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.inventoryReport') ?? 'Inventory Report' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-boxes me-2"></i> <?= lang('App.inventoryReport') ?? 'Inventory Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.inventoryReport') ?? 'Inventory Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.inventoryReportDesc') ?? 'Monitor stock levels, valuation, and inventory turnover.' ?></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.product') ?? 'Product' ?></th>
                            <th><?= lang('App.currentStock') ?? 'Current Stock' ?></th>
                            <th><?= lang('App.valuation') ?? 'Valuation' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Paracetamol</td>
                            <td>120</td>
                            <td>60,000 TZS</td>
                        </tr>
                        <tr>
                            <td>Amoxycillin</td>
                            <td>80</td>
                            <td>40,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <canvas id="inventoryChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulated data
const inventoryLabels = ["Paracetamol", "Amoxycillin"];
const inventoryData = [120, 80];
const ctxI = document.getElementById('inventoryChart').getContext('2d');
const inventoryChart = new Chart(ctxI, {
    type: 'doughnut',
    data: {
        labels: inventoryLabels,
        datasets: [{
            label: '<?= lang('App.currentStock') ?? 'Current Stock' ?>',
            data: inventoryData,
            backgroundColor: [
                'rgba(54, 162, 235, 0.7)',
                'rgba(255, 206, 86, 0.7)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.inventoryReport') ?? 'Inventory Report' ?>' }
        }
    }
});
</script>
<?= $this->endSection() ?>
