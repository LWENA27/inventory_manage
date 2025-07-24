<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.customerReport') ?? 'Customer Report' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-users me-2"></i> <?= lang('App.customerReport') ?? 'Customer Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.customerReport') ?? 'Customer Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.customerReportDesc') ?? 'Analyze customer purchasing patterns and sales by customer.' ?></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.customer') ?? 'Customer' ?></th>
                            <th><?= lang('App.totalSales') ?? 'Total Sales' ?></th>
                            <th><?= lang('App.revenue') ?? 'Revenue' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>John Doe</td>
                            <td>5</td>
                            <td>150,000 TZS</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>3</td>
                            <td>90,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <canvas id="customersChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulated data
const customersLabels = ["John Doe", "Jane Smith"];
const customersData = [150000, 90000];
const ctxC = document.getElementById('customersChart').getContext('2d');
const customersChart = new Chart(ctxC, {
    type: 'bar',
    data: {
        labels: customersLabels,
        datasets: [{
            label: '<?= lang('App.revenue') ?? 'Revenue' ?>',
            data: customersData,
            backgroundColor: 'rgba(54, 162, 235, 0.7)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.customerReport') ?? 'Customer Report' ?>' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?= $this->endSection() ?>
