<div class="receipt" data-invoice-id="<?= $invoice['id'] ?>">
    <div class="receipt-header text-center mb-4">
        <h4 class="mb-0"><?= $settings['company_name'] ?? 'LineShop Africa' ?></h4>
        <p class="mb-0"><?= $settings['address'] ?? '' ?></p>
        <p class="mb-0"><?= $settings['phone'] ?? '' ?> | <?= $settings['email'] ?? '' ?></p>
        <h5 class="mt-3 border-top border-bottom py-2"><?= lang('App.receipt') ?? 'RECEIPT' ?></h5>
    </div>
    
    <div class="receipt-info mb-3">
        <div class="row">
            <div class="col-6">
                <p class="mb-1"><strong><?= lang('App.invoiceNo') ?? 'Invoice No' ?>:</strong> <?= $invoice['invoice_number'] ?></p>
                <p class="mb-1"><strong><?= lang('App.date') ?? 'Date' ?>:</strong> <?= date('d/m/Y H:i', strtotime($invoice['created_at'])) ?></p>
            </div>
            <div class="col-6 text-end">
                <p class="mb-1"><strong><?= lang('App.cashier') ?? 'Cashier' ?>:</strong> <?= $invoice['created_by_name'] ?></p>
                <?php if (!empty($invoice['customer_name'])): ?>
                <p class="mb-1"><strong><?= lang('App.customer') ?? 'Customer' ?>:</strong> <?= $invoice['customer_name'] ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="receipt-items mb-3">
        <table class="table table-sm">
            <thead>
                <tr>
                    <th><?= lang('App.item') ?? 'Item' ?></th>
                    <th class="text-end"><?= lang('App.price') ?? 'Price' ?></th>
                    <th class="text-center"><?= lang('App.qty') ?? 'Qty' ?></th>
                    <th class="text-end"><?= lang('App.total') ?? 'Total' ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= $item['product_name'] ?></td>
                    <td class="text-end"><?= number_format($item['price'], 2) ?></td>
                    <td class="text-center"><?= $item['quantity'] ?></td>
                    <td class="text-end"><?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
    <div class="receipt-totals mb-3">
        <div class="row">
            <div class="col-7 text-end">
                <p class="mb-1"><?= lang('App.subTotal') ?? 'Sub Total' ?>:</p>
                <?php if ($invoice['discount'] > 0): ?>
                <p class="mb-1"><?= lang('App.discount') ?? 'Discount' ?> (<?= $invoice['discount_percent'] ?>%):</p>
                <?php endif; ?>
                <?php if ($invoice['tax'] > 0): ?>
                <p class="mb-1"><?= lang('App.tax') ?? 'Tax' ?> (<?= $invoice['tax_percent'] ?>%):</p>
                <?php endif; ?>
                <p class="mb-1"><strong><?= lang('App.grandTotal') ?? 'Grand Total' ?>:</strong></p>
                <p class="mb-1"><?= lang('App.amountPaid') ?? 'Amount Paid' ?>:</p>
                <?php if ($invoice['amount_paid'] > $invoice['total_amount']): ?>
                <p class="mb-1"><?= lang('App.change') ?? 'Change' ?>:</p>
                <?php endif; ?>
            </div>
            <div class="col-5 text-end">
                <p class="mb-1">TZS <?= number_format($invoice['subtotal'], 2) ?></p>
                <?php if ($invoice['discount'] > 0): ?>
                <p class="mb-1">TZS <?= number_format($invoice['discount'], 2) ?></p>
                <?php endif; ?>
                <?php if ($invoice['tax'] > 0): ?>
                <p class="mb-1">TZS <?= number_format($invoice['tax'], 2) ?></p>
                <?php endif; ?>
                <p class="mb-1"><strong>TZS <?= number_format($invoice['total_amount'], 2) ?></strong></p>
                <p class="mb-1">TZS <?= number_format($invoice['amount_paid'], 2) ?></p>
                <?php if ($invoice['amount_paid'] > $invoice['total_amount']): ?>
                <p class="mb-1">TZS <?= number_format($invoice['amount_paid'] - $invoice['total_amount'], 2) ?></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    
    <div class="receipt-payment mb-3">
        <p class="mb-1"><strong><?= lang('App.paymentMethod') ?? 'Payment Method' ?>:</strong> 
            <?php 
            $methods = [
                'cash' => lang('App.cash') ?? 'Cash',
                'card' => lang('App.card') ?? 'Card',
                'mobile_money' => lang('App.mobileMoney') ?? 'Mobile Money'
            ];
            echo $methods[$invoice['payment_method']] ?? $invoice['payment_method'];
            ?>
        </p>
    </div>
    
    <div class="receipt-footer text-center mt-4">
        <p class="mb-1"><?= $settings['receipt_footer'] ?? lang('App.thankYou') ?? 'Thank you for your business!' ?></p>
        <?php if (!empty($settings['vat_number'])): ?>
        <p class="mb-1"><?= lang('App.vatNumber') ?? 'VAT Number' ?>: <?= $settings['vat_number'] ?></p>
        <?php endif; ?>
        <p class="mb-0"><?= date('d/m/Y H:i') ?></p>
    </div>
</div>