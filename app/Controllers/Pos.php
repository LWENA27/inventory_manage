<?php
namespace App\Controllers;
use App\Models\ProductModel;
use App\Models\StockMovementModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\CustomerModel;
use App\Models\SettingsModel;

class Pos extends BaseController
{
    protected $productModel;
    protected $stockMovementModel;
    protected $invoiceModel;
    protected $invoiceItemModel;
    protected $customerModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->stockMovementModel = new StockMovementModel();
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceItemModel = new InvoiceItemModel();
        $this->customerModel = new CustomerModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        $products = $this->productModel->findAll();
        $settings = $this->settingsModel->first();
        return view('pos/index', [
            'products' => $products,
            'settings' => $settings,
        ]);
    }

    // Add to cart, checkout, etc. would be implemented here

    public function checkout()
    {
        // Handle JSON request
        $input = $this->request->getJSON(true);
        if ($input) {
            $cart = $input['cart'] ?? [];
            $customerName = $input['customer_name'] ?? '';
            $paymentMethod = $input['payment_method'] ?? '';
        } else {
            $cart = $this->request->getPost('cart');
            $customerName = $this->request->getPost('customer_name');
            $paymentMethod = $this->request->getPost('payment_method');
        }
        $tenantId = session('tenant_id');
        $userId = session('user_id');

        if (empty($cart) || !is_array($cart)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Cart is empty!']);
        }

        // Calculate totals
        $total = 0;
        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if (!$product) continue;
            $total += $product['price'] * $item['quantity'];
        }

        // Create invoice
        $invoiceData = [
            'tenant_id' => $tenantId,
            'user_id' => $userId,
            'customer_name' => $customerName,
            'total' => $total,
            'status' => 'paid',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        $invoiceId = $this->invoiceModel->insert($invoiceData, true);

        // Create invoice items and update stock
        foreach ($cart as $item) {
            $product = $this->productModel->find($item['product_id']);
            if (!$product) continue;
            $qty = (int)$item['quantity'];
            $price = $product['price'];
            $this->invoiceItemModel->insert([
                'invoice_id' => $invoiceId,
                'product_id' => $item['product_id'],
                'quantity' => $qty,
                'price' => $price,
                'total' => $qty * $price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
            // Update product stock
            $this->productModel->updateStock($item['product_id'], $qty, 'subtract');
        }

        return $this->response->setJSON(['status' => 'success', 'message' => 'Sale completed!']);
    }
}
