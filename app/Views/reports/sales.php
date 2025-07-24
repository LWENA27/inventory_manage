<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= lang('App.salesReport') ?? 'Sales Report' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-chart-line me-2"></i> <?= lang('App.salesReport') ?? 'Sales Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.salesReport') ?? 'Sales Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.salesReportDesc') ?? 'View sales data, revenue, and trends over time.' ?></p>
            <!-- Example Table -->
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.date') ?? 'Date' ?></th>
                            <th><?= lang('App.totalSales') ?? 'Total Sales' ?></th>
                            <th><?= lang('App.revenue') ?? 'Revenue' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-07-24</td>
                            <td>15</td>
                            <td>450,000 TZS</td>
                        </tr>
                        <tr>
                            <td>2025-07-23</td>
                            <td>12</td>
                            <td>360,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Sales Chart -->
            <div class="mt-4">
                <canvas id="salesChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Use PHP data if available, else fallback to static
<?php if (isset($sales) && is_array($sales) && count($sales) > 0): ?>
    const salesLabels = <?= json_encode(array_map(function($s){return date('Y-m-d', strtotime($s['created_at']));}, $sales)) ?>;
    const salesData = <?= json_encode(array_map(function($s){return (float)($s['total_amount'] ?? 0);}, $sales)) ?>;
<?php else: ?>
    const salesLabels = ["2025-07-23", "2025-07-24"];
    const salesData = [360000, 450000];
<?php endif; ?>

const ctx = document.getElementById('salesChart').getContext('2d');
const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: salesLabels,
        datasets: [{
            label: '<?= lang('App.revenue') ?? 'Revenue' ?>',
            data: salesData,
            borderColor: 'rgba(54, 162, 235, 1)',
            backgroundColor: 'rgba(54, 162, 235, 0.2)',
            fill: true,
            tension: 0.3
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.salesReport') ?? 'Sales Report' ?>' }
        },
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<?= $this->endSection() ?>
