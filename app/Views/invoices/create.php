
<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
<?= lang('App.createInvoice') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 text-gray-800"><?= lang('App.createInvoice') ?></h1>
        <a href="<?= site_url('invoices') ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> <?= lang('App.back') ?>
        </a>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary"><?= lang('App.invoiceDetails') ?? 'Invoice Details' ?></h6>
        </div>
        <div class="card-body">
            <?php if (session()->getFlashdata('errors')): ?>
                <div class="alert alert-danger">
                    <h4 class="alert-heading"><?= lang('App.formErrors') ?? 'Form Errors' ?></h4>
                    <ul>
                        <?php foreach (session()->getFlashdata('errors') as $field => $error): ?>
                            <li><?= $error ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form action="<?= site_url('invoices') ?>" method="post">
                <?= csrf_field() ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label"><?= lang('App.customer') ?> <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name" value="<?= old('customer_name') ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label"><?= lang('App.paymentMethod') ?> <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_method" name="payment_method" required>
                                <option value="">-- <?= lang('App.selectPaymentMethod') ?? 'Select Payment Method' ?> --</option>
                                <option value="cash"><?= lang('App.cash') ?></option>
                                <option value="card"><?= lang('App.card') ?></option>
                                <option value="mobile_money"><?= lang('App.mobileMoney') ?></option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="amount_paid" class="form-label"><?= lang('App.amountPaid') ?> <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="amount_paid" name="amount_paid" value="<?= old('amount_paid') ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="discount" class="form-label"><?= lang('App.discount') ?></label>
                            <input type="number" step="0.01" class="form-control" id="discount" name="discount" value="<?= old('discount') ?? '0' ?>">
                        </div>
                        <div class="mb-3">
                            <label for="tax" class="form-label"><?= lang('App.tax') ?></label>
                            <input type="number" step="0.01" class="form-control" id="tax" name="tax" value="<?= old('tax') ?? '0' ?>">
                        </div>
                    </div>
                </div>
                <hr>
                <h5><?= lang('App.addProducts') ?? 'Add Products' ?></h5>
                <div class="table-responsive mb-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th><?= lang('App.productName') ?></th>
                                <th><?= lang('App.price') ?></th>
                                <th><?= lang('App.quantity') ?></th>
                                <th><?= lang('App.total') ?></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="invoice-items">
                            <!-- JS will add product rows here -->
                        </tbody>
                    </table>
                </div>
                <div class="mb-3">
                    <label for="product_select" class="form-label"><?= lang('App.productName') ?></label>
                    <select class="form-select" id="product_select">
                        <option value="">-- <?= lang('App.selectProduct') ?? 'Select Product' ?> --</option>
                        <?php foreach ($products as $product): ?>
                            <option value="<?= $product['id'] ?>" data-price="<?= $product['price'] ?>"><?= esc($product['name']) ?> (TZS <?= number_format($product['price'], 2) ?>)</option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="button" class="btn btn-success mb-3" id="add-product-btn">
                    <i class="fas fa-plus"></i> <?= lang('App.addToCart') ?? 'Add to Invoice' ?>
                </button>
                <input type="hidden" name="items" id="items-json">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> <?= lang('App.save') ?>
                </button>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const products = <?php echo json_encode($products); ?>;
    const invoiceItems = [];

    document.getElementById('add-product-btn').addEventListener('click', function() {
        const select = document.getElementById('product_select');
        const productId = select.value;
        if (!productId) return;
        const product = products.find(p => p.id == productId);
        if (!product) return;
        // Check if already added
        if (invoiceItems.some(item => item.product_id == productId)) return;
        invoiceItems.push({
            product_id: product.id,
            name: product.name,
            price: parseFloat(product.price),
            quantity: 1
        });
        renderItems();
        updateItemsJson();
    });

    function renderItems() {
        const tbody = document.getElementById('invoice-items');
        tbody.innerHTML = '';
        invoiceItems.forEach((item, idx) => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${item.name}</td>
                <td>TZS <input type="number" step="0.01" class="form-control" value="${item.price}" onchange="updatePrice(${idx}, this.value)"></td>
                <td><input type="number" min="1" class="form-control" value="${item.quantity}" onchange="updateQty(${idx}, this.value)"></td>
                <td>TZS ${(item.price * item.quantity).toFixed(2)}</td>
                <td><button type="button" class="btn btn-danger btn-sm" onclick="removeItem(${idx})"><i class="fas fa-trash"></i></button></td>
            `;
            tbody.appendChild(row);
        });
    }

    function updatePrice(idx, value) {
        invoiceItems[idx].price = parseFloat(value);
        renderItems();
        updateItemsJson();
    }
    function updateQty(idx, value) {
        invoiceItems[idx].quantity = parseInt(value);
        renderItems();
        updateItemsJson();
    }
    function removeItem(idx) {
        invoiceItems.splice(idx, 1);
        renderItems();
        updateItemsJson();
    }
    function updateItemsJson() {
        document.getElementById('items-json').value = JSON.stringify(invoiceItems);
    }
</script>
<?= $this->endSection() ?>
