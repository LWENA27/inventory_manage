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
}
