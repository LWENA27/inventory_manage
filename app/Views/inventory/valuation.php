<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.inventoryValuation') ?? 'Inventory Valuation' ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.inventoryValuation') ?? 'Inventory Valuation' ?></h1>
        <div>
            <button type="button" class="btn btn-success me-2" onclick="exportToExcel()">
                <i class="fas fa-file-excel me-2"></i> <?= lang('App.exportExcel') ?? 'Export to Excel' ?>
            </button>
            <a href="<?= site_url('inventory') ?>" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
            </a>
        </div>
    </div>

    <!-- Valuation Summary Card -->
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.valuationSummary') ?? 'Valuation Summary' ?></h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        <i class="fas fa-chart-pie fa-4x text-primary mb-3"></i>
                        <h4><?= lang('App.totalValue') ?? 'Total Value' ?></h4>
                        <h2 class="text-primary">TZS <?= number_format($totalValue, 2) ?></h2>
                    </div>
                    
                    <hr>
                    
                    <div class="row text-center">
                        <div class="col-6">
                            <h5><?= lang('App.totalProducts') ?? 'Total Products' ?></h5>
                            <p class="h4"><?= count($products) ?></p>
                        </div>
                        <div class="col-6">
                            <h5><?= lang('App.totalItems') ?? 'Total Items' ?></h5>
                            <?php
                            $totalItems = 0;
                            foreach ($products as $product) {
                                $totalItems += $product['stock'];
                            }
                            ?>
                            <p class="h4"><?= $totalItems ?></p>
                        </div>
                    </div>
                    
                    <hr>
                    
                    <div class="text-center">
                        <h5><?= lang('App.valuationDate') ?? 'Valuation Date' ?></h5>
                        <p><?= date('d M Y H:i') ?></p>
                    </div>
                </div>
            </div>
            
            <!-- Category Distribution Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.categoryDistribution') ?? 'Category Distribution' ?></h6>
                </div>
                <div class="card-body">
                    <?php
                    $categories = [];
                    $categoryValues = [];
                    
                    foreach ($products as $product) {
                        $category = $product['category'] ?? 'Uncategorized';
                        $value = $product['price'] * $product['stock'];
                        
                        if (!isset($categories[$category])) {
                            $categories[$category] = 0;
                        }
                        
                        $categories[$category] += $value;
                    }
                    
                    arsort($categories); // Sort by value (highest first)
                    ?>
                    
                    <div class="chart-container" style="position: relative; height:250px;">
                        <canvas id="categoryChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Valuation Table Card -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.inventoryValuationDetails') ?? 'Inventory Valuation Details' ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover" id="valuationTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><?= lang('App.productName') ?></th>
                                    <th><?= lang('App.category') ?></th>
                                    <th><?= lang('App.unitPrice') ?? 'Unit Price' ?></th>
                                    <th><?= lang('App.quantity') ?></th>
                                    <th><?= lang('App.totalValue') ?? 'Total Value' ?></th>
                                    <th><?= lang('App.percentage') ?? 'Percentage' ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                <tr>
                                    <td>
                                        <a href="<?= site_url('products/' . $product['id']) ?>">
                                            <?= esc($product['name']) ?>
                                        </a>
                                    </td>
                                    <td><?= esc($product['category'] ?? 'Uncategorized') ?></td>
                                    <td class="text-end">TZS <?= number_format($product['price'], 2) ?></td>
                                    <td class="text-end"><?= $product['stock'] ?></td>
                                    <td class="text-end">TZS <?= number_format($product['price'] * $product['stock'], 2) ?></td>
                                    <td class="text-end">
                                        <?php 
                                        $percentage = ($totalValue > 0) ? (($product['price'] * $product['stock']) / $totalValue) * 100 : 0;
                                        echo number_format($percentage, 2) . '%';
                                        ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <th colspan="3"><?= lang('App.total') ?></th>
                                    <th class="text-end"><?= $totalItems ?></th>
                                    <th class="text-end">TZS <?= number_format($totalValue, 2) ?></th>
                                    <th class="text-end">100.00%</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#valuationTable').DataTable({
            "order": [[ 4, "desc" ]], // Sort by total value (descending)
            "language": {
                "lengthMenu": "<?= lang('App.show') ?? 'Show' ?> _MENU_ <?= lang('App.entries') ?? 'entries' ?>",
                "search": "<?= lang('App.search') ?>:",
                "info": "<?= lang('App.showing') ?? 'Showing' ?> _START_ <?= lang('App.to') ?? 'to' ?> _END_ <?= lang('App.of') ?? 'of' ?> _TOTAL_ <?= lang('App.entries') ?? 'entries' ?>",
                "paginate": {
                    "first": "<?= lang('App.first') ?? 'First' ?>",
                    "last": "<?= lang('App.last') ?? 'Last' ?>",
                    "next": "<?= lang('App.next') ?? 'Next' ?>",
                    "previous": "<?= lang('App.previous') ?? 'Previous' ?>"
                }
            }
        });
        
        // Initialize Category Chart
        const categoryData = <?= json_encode(array_keys($categories)) ?>;
        const categoryValues = <?= json_encode(array_values($categories)) ?>;
        
        const ctx = document.getElementById('categoryChart').getContext('2d');
        const categoryChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: categoryData,
                datasets: [{
                    data: categoryValues,
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
                        '#5a5c69', '#858796', '#6f42c1', '#20c9a6', '#f8f9fc'
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.raw;
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = Math.round((value / total) * 100);
                                return `TZS ${value.toLocaleString()} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
    
    // Export to Excel function
    function exportToExcel() {
        const table = document.getElementById('valuationTable');
        const wb = XLSX.utils.table_to_book(table, {sheet: "Inventory Valuation"});
        XLSX.writeFile(wb, 'inventory_valuation_<?= date('Y-m-d') ?>.xlsx');
    }
</script>
<?= $this->endSection() ?>