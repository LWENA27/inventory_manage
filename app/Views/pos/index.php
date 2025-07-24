<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?><?= lang('App.pos') ?? 'Point of Sale' ?><?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <h1 class="h3 mb-4 text-gray-800"><?= lang('App.pos') ?? 'Point of Sale' ?></h1>
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <?= lang('App.addProduct') ?? 'Add Product' ?>
                </div>
                <div class="card-body">
                    <form id="addToCartForm">
                        <div class="row g-2 align-items-end">
                            <div class="col-md-6">
                                <label for="product_id" class="form-label">Product</label>
                                <select class="form-select" id="product_id" name="product_id">
                                    <option value="">Select Product</option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?= $product['id'] ?>"><?= esc($product['name']) ?> (<?= $product['stock'] ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label for="quantity" class="form-label">Qty</label>
                                <input type="number" class="form-control" id="quantity" name="quantity" value="1" min="1">
                            </div>
                            <div class="col-md-3">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-cart-plus me-1"></i> <?= lang('App.addToCart') ?? 'Add to Cart' ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <?= lang('App.cart') ?? 'Cart' ?>
                </div>
                <div class="card-body">
                    <div id="cartTableContainer">
                        <table class="table table-bordered" id="cartTable">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Qty</th>
                                    <th>Price</th>
                                    <th>Total</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                        <div class="text-end">
                            <strong><?= lang('App.total') ?? 'Total' ?>: </strong>
                            <span id="cartTotal">0</span> <?= esc($settings['currency'] ?? 'TZS') ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card mb-4">
                <div class="card-header bg-info text-white">
                    <?= lang('App.checkout') ?? 'Checkout' ?>
                </div>
                <div class="card-body">
                    <form id="checkoutForm">
                        <div class="mb-3">
                            <label for="customer_name" class="form-label">Customer Name</label>
                            <input type="text" class="form-control" id="customer_name" name="customer_name">
                        </div>
                        <div class="mb-3">
                            <label for="payment_method" class="form-label">Payment Method</label>
                            <select class="form-select" id="payment_method" name="payment_method">
                                <option value="cash">Cash</option>
                                <option value="mpesa">M-Pesa</option>
                                <option value="card">Card</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-cash-register me-1"></i> <?= lang('App.completeSale') ?? 'Complete Sale' ?>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
let cart = [];
const products = <?= json_encode($products) ?>;

function updateCartTable() {
    const tbody = document.querySelector('#cartTable tbody');
    tbody.innerHTML = '';
    let total = 0;
    cart.forEach((item, idx) => {
        const product = products.find(p => p.id == item.product_id);
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${product ? product.name : ''}</td>
            <td>${item.quantity}</td>
            <td>${product ? product.price : ''}</td>
            <td>${(product ? product.price * item.quantity : 0).toFixed(2)}</td>
            <td><button class='btn btn-danger btn-sm' onclick='removeFromCart(${idx})'>Remove</button></td>
        `;
        tbody.appendChild(row);
        total += product ? product.price * item.quantity : 0;
    });
    document.getElementById('cartTotal').textContent = total.toFixed(2);
}

function removeFromCart(idx) {
    cart.splice(idx, 1);
    updateCartTable();
}

document.getElementById('addToCartForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const product_id = document.getElementById('product_id').value;
    const quantity = parseInt(document.getElementById('quantity').value);
    if (!product_id || quantity < 1) return;
    const existing = cart.find(item => item.product_id == product_id);
    if (existing) {
        existing.quantity += quantity;
    } else {
        cart.push({ product_id, quantity });
    }
    updateCartTable();
});

document.getElementById('checkoutForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (cart.length === 0) return alert('Cart is empty!');
    const customer_name = document.getElementById('customer_name').value;
    const payment_method = document.getElementById('payment_method').value;
    fetch('<?= site_url('pos/checkout') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
        },
        body: JSON.stringify({
            cart: cart,
            customer_name: customer_name,
            payment_method: payment_method
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'success') {
            alert('Sale completed!');
            cart = [];
            updateCartTable();
        } else {
            alert(data.message || 'Sale failed!');
        }
    })
    .catch(() => alert('Sale failed!'));
});
</script>
<?= $this->endSection() ?>
