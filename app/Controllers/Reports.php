<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\InvoiceModel;
use App\Models\StockMovementModel;

class Reports extends BaseController
{
    protected $productModel;
    protected $invoiceModel;
    protected $stockMovementModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->invoiceModel = new InvoiceModel();
        $this->stockMovementModel = new StockMovementModel();
    }

    public function index()
    {
        $data = [
            'title' => lang('App.reports') ?? 'Reports'
        ];

        return view('reports/index', $data);
    }

    public function sales()
    {
        // Get date range from request or use default (current month)
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');
        
        // Get sales data
        $sales = $this->invoiceModel
            ->where('created_at >=', $startDate . ' 00:00:00')
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->findAll();
        
        // Calculate totals
        $totalSales = 0;
        $totalDiscount = 0;
        $totalTax = 0;
        $totalRevenue = 0;
        
        foreach ($sales as $sale) {
            $totalSales += $sale['subtotal'];
            $totalDiscount += $sale['discount'];
            $totalTax += $sale['tax'];
            $totalRevenue += $sale['total_amount'];
        }
        
        $data = [
            'title' => lang('App.salesReport') ?? 'Sales Report',
            'sales' => $sales,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalSales' => $totalSales,
            'totalDiscount' => $totalDiscount,
            'totalTax' => $totalTax,
            'totalRevenue' => $totalRevenue
        ];
        
        return view('reports/sales', $data);
    }

    public function purchases()
    {
        // In a real application, you would have a PurchaseModel
        // For now, we'll just display a placeholder view
        
        // Get date range from request or use default (current month)
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');
        
        $data = [
            'title' => lang('App.purchasesReport') ?? 'Purchases Report',
            'startDate' => $startDate,
            'endDate' => $endDate
        ];
        
        return view('reports/purchases', $data);
    }

    public function inventory()
    {
        // Get inventory data
        $products = $this->productModel->findAll();
        
        // Calculate inventory value
        $totalValue = 0;
        foreach ($products as $product) {
            $totalValue += $product['stock'] * $product['cost'];
        }
        
        $data = [
            'title' => lang('App.inventoryReport') ?? 'Inventory Report',
            'products' => $products,
            'totalValue' => $totalValue
        ];
        
        return view('reports/inventory', $data);
    }

    public function profit()
    {
        // Get date range from request or use default (current month)
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');
        
        // Get sales data
        $sales = $this->invoiceModel
            ->where('created_at >=', $startDate . ' 00:00:00')
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->findAll();
        
        // Calculate profit
        $totalRevenue = 0;
        $totalCost = 0;
        $totalProfit = 0;
        
        foreach ($sales as $sale) {
            $totalRevenue += $sale['total_amount'];
            
            // In a real application, you would calculate the cost of goods sold
            // For now, we'll just estimate it as 60% of the revenue
            $costOfGoodsSold = $sale['subtotal'] * 0.6;
            $totalCost += $costOfGoodsSold;
            
            $profit = $sale['total_amount'] - $costOfGoodsSold;
            $totalProfit += $profit;
        }
        
        $data = [
            'title' => lang('App.profitReport') ?? 'Profit Report',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'totalProfit' => $totalProfit
        ];
        
        return view('reports/profit', $data);
    }

    public function taxes()
    {
        // Get date range from request or use default (current month)
        $startDate = $this->request->getGet('start_date') ?? date('Y-m-01');
        $endDate = $this->request->getGet('end_date') ?? date('Y-m-t');
        
        // Get sales data
        $sales = $this->invoiceModel
            ->where('created_at >=', $startDate . ' 00:00:00')
            ->where('created_at <=', $endDate . ' 23:59:59')
            ->findAll();
        
        // Calculate tax
        $totalTax = 0;
        foreach ($sales as $sale) {
            $totalTax += $sale['tax'];
        }
        
        $data = [
            'title' => lang('App.taxReport') ?? 'Tax Report',
            'startDate' => $startDate,
            'endDate' => $endDate,
            'sales' => $sales,
            'totalTax' => $totalTax
        ];
        
        return view('reports/taxes', $data);
    }

    public function customers()
    {
        // In a real application, you would have a CustomerModel
        // For now, we'll just display a placeholder view
        
        $data = [
            'title' => lang('App.customerReport') ?? 'Customer Report'
        ];
        
        return view('reports/customers', $data);
    }

    public function suppliers()
    {
        // In a real application, you would have a SupplierModel
        // For now, we'll just display a placeholder view
        
        $data = [
            'title' => lang('App.supplierReport') ?? 'Supplier Report'
        ];
        
        return view('reports/suppliers', $data);
    }
}