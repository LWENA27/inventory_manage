<?= $this->extend('layouts/main') ?>
<?= $this->section('title') ?><?= lang('App.profitReport') ?? 'Profit Report' ?><?= $this->endSection() ?>
<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><i class="fas fa-dollar-sign me-2"></i> <?= lang('App.profitReport') ?? 'Profit Report' ?></h1>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <?= lang('App.profitReport') ?? 'Profit Report' ?>
        </div>
        <div class="card-body">
            <p><?= lang('App.profitReportDesc') ?? 'Analyze profit margins, revenue, and cost of goods sold.' ?></p>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th><?= lang('App.date') ?? 'Date' ?></th>
                            <th><?= lang('App.revenue') ?? 'Revenue' ?></th>
                            <th><?= lang('App.cogs') ?? 'COGS' ?></th>
                            <th><?= lang('App.profit') ?? 'Profit' ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>2025-07-24</td>
                            <td>450,000 TZS</td>
                            <td>300,000 TZS</td>
                            <td>150,000 TZS</td>
                        </tr>
                        <tr>
                            <td>2025-07-23</td>
                            <td>360,000 TZS</td>
                            <td>240,000 TZS</td>
                            <td>120,000 TZS</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                <canvas id="profitChart" height="100"></canvas>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// Simulated data
const profitLabels = ["2025-07-23", "2025-07-24"];
const profitData = [120000, 150000];
const revenueData = [360000, 450000];
const ctxPr = document.getElementById('profitChart').getContext('2d');
const profitChart = new Chart(ctxPr, {
    type: 'bar',
    data: {
        labels: profitLabels,
        datasets: [
            {
                label: '<?= lang('App.profit') ?? 'Profit' ?>',
                data: profitData,
                backgroundColor: 'rgba(75, 192, 192, 0.7)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            },
            {
                label: '<?= lang('App.revenue') ?? 'Revenue' ?>',
                data: revenueData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: true },
            title: { display: true, text: '<?= lang('App.profitReport') ?? 'Profit Report' ?>' }
        },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
<?= $this->endSection() ?>
