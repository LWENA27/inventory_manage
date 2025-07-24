<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\WarehouseModel;
use App\Models\StockMovementModel;
use App\Models\ProductBatchModel;

class Inventory extends BaseController
{
    protected $productModel;
    protected $warehouseModel;
    protected $stockMovementModel;
    protected $productBatchModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->warehouseModel = new WarehouseModel();
        $this->stockMovementModel = new StockMovementModel();
        $this->productBatchModel = new ProductBatchModel();
    }
    
    /**
     * Display inventory management dashboard
     *
     * @return string
     */
    public function index()
    {
        // Get tenant ID from session
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        
        $data = [
            'products' => $this->productModel->getByTenant($tenantId),
            'lowStockCount' => count($this->productModel->getLowStock($tenantId)),
        ];
        
        return view('inventory/index', $data);
    }
    
    /**
     * Show the form for adjusting product stock
     *
     * @param int $id
     * @return string
     */
    public function adjust($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/inventory')
                ->with('error', 'Product not found');
        }
        
        $data = [
            'product' => $product
        ];
        
        return view('inventory/adjust', $data);
    }
    
    /**
     * Process stock adjustment
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function processAdjustment($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/inventory')
                ->with('error', 'Product not found');
        }
        
        // Validate form input
        $rules = [
            'quantity' => 'required|numeric',
            'operation' => 'required|in_list[add,subtract]',
            'reason' => 'required|max_length[255]',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        $quantity = (int)$this->request->getPost('quantity');
        $operation = $this->request->getPost('operation');
        $reason = $this->request->getPost('reason');
        
        // Update product stock
        $success = $this->productModel->updateStock($id, $quantity, $operation);
        
        if (!$success) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update stock');
        }
        
        // Record stock movement in stock_movements table
        $userId = session()->get('user_id') ?? 1;
        $warehouseId = $product['warehouse_id'] ?? null;
        $batchId = $this->request->getPost('batch_id') ?? null;
        $expiryDate = $this->request->getPost('expiry_date') ?? null;
        $this->stockMovementModel->insert([
            'product_id' => $id,
            'warehouse_id' => $warehouseId,
            'user_id' => $userId,
            'batch_id' => $batchId,
            'quantity' => $quantity,
            'operation' => $operation === 'add' ? 'in' : 'out',
            'reason' => $reason,
            'expiry_date' => $expiryDate,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        
        return redirect()->to('/products/' . $id)
            ->with('success', lang('App.stockUpdated') ?? 'Stock updated successfully');
    }
    
    /**
     * Display stock movement history
     *
     * @param int|null $productId
     * @return string
     */
    public function history($productId = null)
    {
        // Get tenant ID from session
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        
        $movements = $productId
            ? $this->stockMovementModel->where('product_id', $productId)->orderBy('created_at', 'DESC')->findAll()
            : $this->stockMovementModel->orderBy('created_at', 'DESC')->findAll();
        $data = [
            'movements' => $movements,
        ];
        if ($productId) {
            $data['product'] = $this->productModel->find($productId);
            if (!$data['product']) {
                return redirect()->to('/inventory')->with('error', 'Product not found');
            }
        }
        return view('inventory/history', $data);
    }
    
    /**
     * Display stock valuation report
     *
     * @return string
     */
    public function valuation()
    {
        // Get tenant ID from session
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        
        $products = $this->productModel->getByTenant($tenantId);
        
        $totalValue = 0;
        foreach ($products as $product) {
            $totalValue += $product['price'] * $product['stock'];
        }
        
        $data = [
            'products' => $products,
            'totalValue' => $totalValue,
        ];
        
        return view('inventory/valuation', $data);
    }
    
    /**
     * Display stock by warehouse
     *
     * @param int|null $warehouseId
     * @return string
     */
    public function byWarehouse($warehouseId = null)
    {
        // Get tenant ID from session
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        
        $warehouses = $this->warehouseModel->where('tenant_id', $tenantId)->findAll();
        if ($warehouseId) {
            $products = $this->productModel->getByWarehouse($warehouseId);
            $currentWarehouse = null;
            foreach ($warehouses as $warehouse) {
                if ($warehouse['id'] == $warehouseId) {
                    $currentWarehouse = $warehouse;
                    break;
                }
            }
        } else {
            $products = $this->productModel->getByTenant($tenantId);
            $currentWarehouse = null;
        }
        $data = [
            'products' => $products,
            'warehouses' => $warehouses,
            'currentWarehouse' => $currentWarehouse,
        ];
        return view('inventory/by_warehouse', $data);
    }
    
    /**
     * Display batch and expiry tracking
     *
     * @return string
     */
    public function batches()
    {
        $tenantId = session()->get('tenant_id') ?? 1;
        $batches = $this->productBatchModel
            ->select('product_batches.*, products.name as product_name, warehouses.name as warehouse_name')
            ->join('products', 'products.id = product_batches.product_id')
            ->join('warehouses', 'warehouses.id = product_batches.warehouse_id')
            ->where('products.tenant_id', $tenantId)
            ->findAll();
        $data = [
            'batches' => $batches,
        ];
        return view('inventory/batches', $data);
    }
    
    /**
     * Record stock movement (to be implemented with a StockMovementModel)
     *
     * @param int $productId
     * @param int $quantity
     * @param string $operation
     * @param string $reason
     * @return bool
     */
    private function recordStockMovement($productId, $quantity, $operation, $reason, $warehouseId = null, $batchId = null, $expiryDate = null)
    {
        $userId = session()->get('user_id') ?? 1;
        $this->stockMovementModel->insert([
            'product_id' => $productId,
            'warehouse_id' => $warehouseId,
            'user_id' => $userId,
            'batch_id' => $batchId,
            'quantity' => $quantity,
            'operation' => $operation,
            'reason' => $reason,
            'expiry_date' => $expiryDate,
            'created_at' => date('Y-m-d H:i:s'),
        ]);
        return true;
    }
}