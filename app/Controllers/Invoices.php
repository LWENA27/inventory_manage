<?php

namespace App\Controllers;

use App\Models\InvoiceModel;
use App\Models\InvoiceItemModel;
use App\Models\ProductModel;
use App\Models\CustomerModel;

class Invoices extends BaseController
{
    protected $invoiceModel;
    protected $invoiceItemModel;
    protected $productModel;
    protected $customerModel;

    public function __construct()
    {
        $this->invoiceModel = new InvoiceModel();
        $this->invoiceItemModel = new InvoiceItemModel();
        $this->productModel = new ProductModel();
        // Uncomment when CustomerModel is implemented
        // $this->customerModel = new CustomerModel();
    }

    public function index()
    {
        $data = [
            'invoices' => $this->invoiceModel->findAll(),
            'title' => lang('App.invoices') ?? 'Invoices'
        ];

        return view('invoices/index', $data);
    }

    public function create()
    {
        $data = [
            'products' => $this->productModel->findAll(),
            // Uncomment when CustomerModel is implemented
            // 'customers' => $this->customerModel->findAll(),
            'title' => lang('App.createInvoice') ?? 'Create Invoice'
        ];

        return view('invoices/create', $data);
    }

    public function store()
    {
        // Validate input
        $rules = [
            'customer_name' => 'required',
            'items' => 'required',
            'payment_method' => 'required',
            'amount_paid' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $customerName = $this->request->getPost('customer_name');
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
            
            // Generate invoice number
            $invoiceNumber = 'INV-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // Create invoice
            $invoiceId = $this->invoiceModel->insert([
                'invoice_number' => $invoiceNumber,
                'customer_name' => $customerName,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'discount_percent' => $discountPercent,
                'tax' => $tax,
                'tax_percent' => $taxPercent,
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod,
                'amount_paid' => $amountPaid,
                'status' => $amountPaid >= $totalAmount ? 'paid' : 'partial',
                'created_by' => session()->get('user_id'),
                'created_by_name' => session()->get('name'),
                'tenant_id' => session()->get('tenant_id')
            ]);
            
            // Process items
            foreach ($items as $item) {
                // Add invoice item
                $this->invoiceItemModel->insert([
                    'invoice_id' => $invoiceId,
                    'product_id' => $item['id'],
                    'product_name' => $item['name'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'tenant_id' => session()->get('tenant_id')
                ]);
                
                // Update stock
                $product = $this->productModel->find($item['id']);
                $newStock = $product['stock'] - $item['quantity'];
                
                $this->productModel->update($item['id'], [
                    'stock' => $newStock
                ]);
                
                // Record stock movement
                helper('stock');
                record_stock_movement(
                    $item['id'],
                    -$item['quantity'],
                    'sale',
                    $invoiceNumber,
                    lang('App.soldViaInvoice') ?? 'Sold via invoice'
                );
            }
            
            // Commit transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', lang('App.transactionFailed') ?? 'Transaction failed');
            }
            
            return redirect()->to('invoices')->with('success', lang('App.invoiceCreated') ?? 'Invoice created successfully');
            
        } catch (\Exception $e) {
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        $invoice = $this->invoiceModel->find($id);
        
        if (!$invoice) {
            return redirect()->to('invoices')->with('error', lang('App.invoiceNotFound') ?? 'Invoice not found');
        }
        
        $items = $this->invoiceItemModel->where('invoice_id', $id)->findAll();
        
        $data = [
            'invoice' => $invoice,
            'items' => $items,
            'title' => lang('App.invoiceDetails') ?? 'Invoice Details'
        ];
        
        return view('invoices/show', $data);
    }

    public function edit($id)
    {
        $invoice = $this->invoiceModel->find($id);
        
        if (!$invoice) {
            return redirect()->to('invoices')->with('error', lang('App.invoiceNotFound') ?? 'Invoice not found');
        }
        
        $items = $this->invoiceItemModel->where('invoice_id', $id)->findAll();
        
        $data = [
            'invoice' => $invoice,
            'items' => $items,
            'products' => $this->productModel->findAll(),
            // Uncomment when CustomerModel is implemented
            // 'customers' => $this->customerModel->findAll(),
            'title' => lang('App.editInvoice') ?? 'Edit Invoice'
        ];
        
        return view('invoices/edit', $data);
    }

    public function update($id)
    {
        // Validate input
        $rules = [
            'customer_name' => 'required',
            'payment_method' => 'required',
            'amount_paid' => 'required|numeric'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $invoice = $this->invoiceModel->find($id);
        
        if (!$invoice) {
            return redirect()->to('invoices')->with('error', lang('App.invoiceNotFound') ?? 'Invoice not found');
        }
        
        // Get form data
        $customerName = $this->request->getPost('customer_name');
        $paymentMethod = $this->request->getPost('payment_method');
        $amountPaid = (float) $this->request->getPost('amount_paid');
        
        // Update invoice
        $this->invoiceModel->update($id, [
            'customer_name' => $customerName,
            'payment_method' => $paymentMethod,
            'amount_paid' => $amountPaid,
            'status' => $amountPaid >= $invoice['total_amount'] ? 'paid' : 'partial',
            'updated_by' => session()->get('user_id')
        ]);
        
        return redirect()->to('invoices')->with('success', lang('App.invoiceUpdated') ?? 'Invoice updated successfully');
    }

    public function delete($id)
    {
        $invoice = $this->invoiceModel->find($id);
        
        if (!$invoice) {
            return redirect()->to('invoices')->with('error', lang('App.invoiceNotFound') ?? 'Invoice not found');
        }
        
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Get invoice items
            $items = $this->invoiceItemModel->where('invoice_id', $id)->findAll();
            
            // Restore stock
            foreach ($items as $item) {
                $product = $this->productModel->find($item['product_id']);
                $newStock = $product['stock'] + $item['quantity'];
                
                $this->productModel->update($item['product_id'], [
                    'stock' => $newStock
                ]);
                
                // Record stock movement
                helper('stock');
                record_stock_movement(
                    $item['product_id'],
                    $item['quantity'],
                    'invoice_reversal',
                    $invoice['invoice_number'],
                    lang('App.invoiceDeleted') ?? 'Invoice deleted'
                );
            }
            
            // Delete invoice items
            $this->invoiceItemModel->where('invoice_id', $id)->delete();
            
            // Delete invoice
            $this->invoiceModel->delete($id);
            
            // Commit transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return redirect()->back()->with('error', lang('App.transactionFailed') ?? 'Transaction failed');
            }
            
            return redirect()->to('invoices')->with('success', lang('App.invoiceDeleted') ?? 'Invoice deleted successfully');
            
        } catch (\Exception $e) {
            $db->transRollback();
            
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function print($id)
    {
        $invoice = $this->invoiceModel->find($id);
        
        if (!$invoice) {
            return redirect()->to('invoices')->with('error', lang('App.invoiceNotFound') ?? 'Invoice not found');
        }
        
        $items = $this->invoiceItemModel->where('invoice_id', $id)->findAll();
        
        $data = [
            'invoice' => $invoice,
            'items' => $items
        ];
        
        return view('invoices/print', $data);
    }
}