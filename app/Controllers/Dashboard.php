<?php
namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\ProductModel;
use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }

        $tenantId = session('tenant_id');
        $trialModel = new \App\Models\TrialModel();
        $status = $trialModel->getTrialStatus(session('user_id'));

        $productModel = new ProductModel();
        $invoiceModel = new InvoiceModel();
        $invoiceItemModel = new InvoiceItemModel();

        // Product stats
        $products = $productModel->getByTenant($tenantId);
        $productCount = count($products);
        $lowStockCount = count($productModel->getLowStock($tenantId));

        // Sales stats
        $today = date('Y-m-d');
        $monthStart = date('Y-m-01');
        $todaySales = $invoiceModel->where('tenant_id', $tenantId)
            ->where('DATE(created_at)', $today)
            ->selectSum('total')
            ->first()['total'] ?? 0;
        $monthSales = $invoiceModel->where('tenant_id', $tenantId)
            ->where('created_at >=', $monthStart . ' 00:00:00')
            ->where('created_at <=', date('Y-m-t') . ' 23:59:59')
            ->selectSum('total')
            ->first()['total'] ?? 0;

        // Recent sales (last 5 invoices)
        $recentSales = $invoiceModel->where('tenant_id', $tenantId)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Top products (by quantity sold, last 30 days)
        $topProducts = $invoiceItemModel->select('product_id, SUM(quantity) as qty')
            ->join('invoices', 'invoices.id = invoice_items.invoice_id')
            ->where('invoices.tenant_id', $tenantId)
            ->where('invoices.created_at >=', date('Y-m-d', strtotime('-30 days')) . ' 00:00:00')
            ->groupBy('product_id')
            ->orderBy('qty', 'DESC')
            ->findAll(5);

        // Attach product names to top products
        foreach ($topProducts as &$tp) {
            $prod = $productModel->find($tp['product_id']);
            $tp['name'] = $prod['name'] ?? 'N/A';
        }

        return view('dashboard/index', [
            'status' => $status,
            'productCount' => $productCount,
            'lowStockCount' => $lowStockCount,
            'todaySales' => $todaySales,
            'monthSales' => $monthSales,
            'recentSales' => $recentSales,
            'topProducts' => $topProducts,
        ]);
    }
}
