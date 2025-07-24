<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\SettingsModel;

class Purchases extends BaseController
{
    protected $productModel;
    protected $settingsModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->settingsModel = new SettingsModel();
    }

    public function index()
    {
        // In a real application, you would have a PurchaseModel
        // For now, we'll just display a placeholder view
        $data = [
            'title' => lang('App.purchases') ?? 'Purchases'
        ];

        return view('purchases/index', $data);
    }

    public function create()
    {
        $data = [
            'products' => $this->productModel->findAll(),
            'title' => lang('App.createPurchase') ?? 'Create Purchase'
        ];

        return view('purchases/create', $data);
    }

    public function store()
    {
        // Validate input
        $rules = [
            'supplier_name' => 'required',
            'items' => 'required',
            'payment_method' => 'required',
            'amount_paid' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $supplierName = $this->request->getPost('supplier_name');
        $items = json_decode($this->request->getPost('items'), true);
        $paymentMethod = $this->request->getPost('payment_method');
        $amountPaid = (float) $this->request->getPost('amount_paid');
        $discountPercent = (float) $this->request->getPost('discount') ?? 0;
        $taxPercent = (float) $this->request->getPost('tax') ?? 0;
        
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Calculate totals
            $subtotal = 0;
            foreach ($items as $item) {
                $subtotal += $item['price'] * $item['quantity'];
            }
            
            $discount = ($subtotal * $discountPercent) / 100;
            $tax = ($subtotal * $taxPercent) / 100;
            $totalAmount = $subtotal - $discount + $tax;
            
            // Generate purchase number
            $purchaseNumber = 'PO-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // In a real application, you would save the purchase to a PurchaseModel
            // For now, we'll just update the product stock
            
            // Process items
            foreach ($items as $item) {
                // Update stock
                $product = $this->productModel->find($item['id']);
                $newStock = $product['stock'] + $item['quantity'];
                
                $this->productModel->update($item['id'], [
                    'stock' => $newStock
                ]);
                
                // Record stock movement
                helper('stock');
                record_stock_movement(
                    $item['id'],
                    $item['quantity'],
                    'purchase',
                    $purchaseNumber,
                    lang('App.purchasedFromSupplier') ?? 'Purchased from supplier'
                );
            }
            
            // Commit transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', lang('App.transactionFailed') ?? 'Transaction failed');
            }
            
            return redirect()->to('purchases')->with('success', lang('App.purchaseCreated') ?? 'Purchase created successfully');
            
        } catch (\Exception $e) {
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        // In a real application, you would fetch the purchase from a PurchaseModel
        // For now, we'll just display a placeholder view
        $data = [
            'title' => lang('App.purchaseDetails') ?? 'Purchase Details'
        ];
        
        return view('purchases/show', $data);
    }

    public function edit($id)
    {
        // In a real application, you would fetch the purchase from a PurchaseModel
        // For now, we'll just display a placeholder view
        $data = [
            'products' => $this->productModel->findAll(),
            'title' => lang('App.editPurchase') ?? 'Edit Purchase'
        ];
        
        return view('purchases/edit', $data);
    }

    public function update($id)
    {
        // Validate input
        $rules = [
            'supplier_name' => 'required',
            'payment_method' => 'required',
            'amount_paid' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // In a real application, you would update the purchase in a PurchaseModel
        // For now, we'll just redirect back to the purchases list
        
        return redirect()->to('purchases')->with('success', lang('App.purchaseUpdated') ?? 'Purchase updated successfully');
    }

    public function delete($id)
    {
        // In a real application, you would delete the purchase from a PurchaseModel
        // For now, we'll just redirect back to the purchases list
        
        return redirect()->to('purchases')->with('success', lang('App.purchaseDeleted') ?? 'Purchase deleted successfully');
    }
}