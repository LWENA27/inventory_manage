<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductModel extends Model
{
    protected $table      = 'products';
    protected $primaryKey = 'id';
    
    protected $useAutoIncrement = true;
    protected $returnType     = 'array';
    protected $useSoftDeletes = false;
    
    protected $allowedFields = [
        'tenant_id', 'name', 'image', 'price', 'barcode', 'sku', 
        'category', 'unit', 'variant', 'stock', 'warehouse_id'
    ];
    
    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    
    // Validation
    protected $validationRules = [
        'name'     => 'required|min_length[3]|max_length[100]',
        'price'    => 'required|numeric',
        'tenant_id' => 'required|numeric',
    ];
    
    protected $validationMessages = [
        'name' => [
            'required' => 'Product name is required',
            'min_length' => 'Product name must be at least 3 characters long',
            'max_length' => 'Product name cannot exceed 100 characters'
        ],
        'price' => [
            'required' => 'Product price is required',
            'numeric' => 'Product price must be a number'
        ],
        'tenant_id' => [
            'required' => 'Tenant ID is required',
            'numeric' => 'Tenant ID must be a number'
        ]
    ];
    
    protected $skipValidation = false;
    
    /**
     * Get products by tenant ID
     *
     * @param int $tenantId
     * @return array
     */
    public function getByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)->findAll();
    }
    
    /**
     * Get products by warehouse ID
     *
     * @param int $warehouseId
     * @return array
     */
    public function getByWarehouse($warehouseId)
    {
        return $this->where('warehouse_id', $warehouseId)->findAll();
    }
    
    /**
     * Get products with low stock
     *
     * @param int $tenantId
     * @param int $threshold
     * @return array
     */
    public function getLowStock($tenantId, $threshold = 10)
    {
        return $this->where('tenant_id', $tenantId)
                    ->where('stock <=', $threshold)
                    ->findAll();
    }
    
    /**
     * Search products by name, barcode, or SKU
     *
     * @param int $tenantId
     * @param string $keyword
     * @return array
     */
    public function search($tenantId, $keyword)
    {
        return $this->where('tenant_id', $tenantId)
                    ->groupStart()
                        ->like('name', $keyword)
                        ->orLike('barcode', $keyword)
                        ->orLike('sku', $keyword)
                    ->groupEnd()
                    ->findAll();
    }
    
    /**
     * Get product categories
     *
     * @param int $tenantId
     * @return array
     */
    public function getCategories($tenantId)
    {
        return $this->where('tenant_id', $tenantId)
                    ->select('category')
                    ->distinct()
                    ->where('category IS NOT NULL')
                    ->findAll();
    }
    
    /**
     * Update product stock
     *
     * @param int $productId
     * @param int $quantity
     * @param string $operation 'add' or 'subtract'
     * @return bool
     */
    public function updateStock($productId, $quantity, $operation = 'add')
    {
        $product = $this->find($productId);
        
        if (!$product) {
            return false;
        }
        
        $currentStock = $product['stock'];
        $newStock = ($operation === 'add') 
                    ? $currentStock + $quantity 
                    : $currentStock - $quantity;
        
        // Ensure stock doesn't go below zero
        $newStock = max(0, $newStock);
        
        return $this->update($productId, ['stock' => $newStock]);
    }
}