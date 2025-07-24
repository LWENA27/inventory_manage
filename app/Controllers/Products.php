<?php

namespace App\Controllers;

use App\Models\ProductModel;

class Products extends BaseController
{
    protected $productModel;
    
    public function __construct()
    {
        $this->productModel = new ProductModel();
    }
    
    /**
     * Display a listing of products
     *
     * @return string
     */
    public function index()
    {
        // Get tenant ID from session (assuming it's stored there)
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        
        $data = [
            'products' => $this->productModel->getByTenant($tenantId)
        ];
        
        return view('products/index', $data);
    }
    
    /**
     * Show the form for creating a new product
     *
     * @return string
     */
    public function create()
    {
        return view('products/create');
    }
    
    /**
     * Store a newly created product
     *
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function store()
    {
        // Get tenant ID from session
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        
        // Validate form input
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'price' => 'required|numeric',
            'category' => 'permit_empty|max_length[50]',
            'barcode' => 'permit_empty|max_length[50]',
            'sku' => 'permit_empty|max_length[50]',
            'unit' => 'permit_empty|max_length[20]',
            'variant' => 'permit_empty|max_length[50]',
            'stock' => 'permit_empty|numeric',
            'warehouse_id' => 'permit_empty|numeric',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Handle image upload
        $image = null;
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/products', $newName);
            $image = 'uploads/products/' . $newName;
        }
        
        // Prepare data for insertion
        $data = [
            'tenant_id' => $tenantId,
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
            'barcode' => $this->request->getPost('barcode'),
            'sku' => $this->request->getPost('sku'),
            'unit' => $this->request->getPost('unit'),
            'variant' => $this->request->getPost('variant'),
            'stock' => $this->request->getPost('stock') ?? 0,
            'warehouse_id' => $this->request->getPost('warehouse_id'),
        ];
        
        if ($image) {
            $data['image'] = $image;
        }
        
        // Save the product
        $this->productModel->insert($data);
        
        return redirect()->to('/products')
            ->with('success', lang('App.productAdded'));
    }
    
    /**
     * Display the specified product
     *
     * @param int $id
     * @return string
     */
    public function show($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found');
        }
        
        $data = [
            'product' => $product
        ];
        
        return view('products/show', $data);
    }
    
    /**
     * Show the form for editing the specified product
     *
     * @param int $id
     * @return string
     */
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found');
        }
        
        $data = [
            'product' => $product
        ];
        
        return view('products/edit', $data);
    }
    
    /**
     * Update the specified product
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function update($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found');
        }
        
        // Validate form input
        $rules = [
            'name' => 'required|min_length[3]|max_length[100]',
            'price' => 'required|numeric',
            'category' => 'permit_empty|max_length[50]',
            'barcode' => 'permit_empty|max_length[50]',
            'sku' => 'permit_empty|max_length[50]',
            'unit' => 'permit_empty|max_length[20]',
            'variant' => 'permit_empty|max_length[50]',
            'stock' => 'permit_empty|numeric',
            'warehouse_id' => 'permit_empty|numeric',
        ];
        
        if (!$this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }
        
        // Handle image upload
        $image = $product['image']; // Keep existing image by default
        $file = $this->request->getFile('image');
        
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/products', $newName);
            $image = 'uploads/products/' . $newName;
            
            // Delete old image if it exists
            if ($product['image'] && file_exists(ROOTPATH . 'public/' . $product['image'])) {
                unlink(ROOTPATH . 'public/' . $product['image']);
            }
        }
        
        // Prepare data for update
        $data = [
            'name' => $this->request->getPost('name'),
            'price' => $this->request->getPost('price'),
            'category' => $this->request->getPost('category'),
            'barcode' => $this->request->getPost('barcode'),
            'sku' => $this->request->getPost('sku'),
            'unit' => $this->request->getPost('unit'),
            'variant' => $this->request->getPost('variant'),
            'stock' => $this->request->getPost('stock'),
            'warehouse_id' => $this->request->getPost('warehouse_id'),
        ];
        
        if ($image) {
            $data['image'] = $image;
        }
        
        // Update the product
        $this->productModel->update($id, $data);
        
        return redirect()->to('/products')
            ->with('success', lang('App.productUpdated'));
    }
    
    /**
     * Delete the specified product
     *
     * @param int $id
     * @return \CodeIgniter\HTTP\RedirectResponse
     */
    public function delete($id)
    {
        $product = $this->productModel->find($id);
        
        if (!$product) {
            return redirect()->to('/products')
                ->with('error', 'Product not found');
        }
        
        // Delete product image if it exists
        if ($product['image'] && file_exists(ROOTPATH . 'public/' . $product['image'])) {
            unlink(ROOTPATH . 'public/' . $product['image']);
        }
        
        // Delete the product
        $this->productModel->delete($id);
        
        return redirect()->to('/products')
            ->with('success', lang('App.productDeleted'));
    }
    
    /**
     * Search for products
     *
     * @return string
     */
    public function search()
    {
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        $keyword = $this->request->getGet('keyword');
        
        $data = [
            'products' => $this->productModel->search($tenantId, $keyword),
            'keyword' => $keyword
        ];
        
        return view('products/index', $data);
    }
    
    /**
     * Filter products by category
     *
     * @return string
     */
    public function filterByCategory()
    {
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        $category = $this->request->getGet('category');
        
        $data = [
            'products' => $this->productModel->where('tenant_id', $tenantId)
                                            ->where('category', $category)
                                            ->findAll(),
            'category' => $category
        ];
        
        return view('products/index', $data);
    }
    
    /**
     * Get low stock products
     *
     * @return string
     */
    public function lowStock()
    {
        $tenantId = session()->get('tenant_id') ?? 1; // Default to 1 for testing
        $threshold = $this->request->getGet('threshold') ?? 10;
        
        $data = [
            'products' => $this->productModel->getLowStock($tenantId, $threshold),
            'threshold' => $threshold
        ];
        
        return view('products/low_stock', $data);
    }
}