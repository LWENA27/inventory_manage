<?php

namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\WarehouseModel;

class Transfers extends BaseController
{
    protected $productModel;
    protected $warehouseModel;

    public function __construct()
    {
        $this->productModel = new ProductModel();
        $this->warehouseModel = new WarehouseModel();
    }

    public function index()
    {
        // In a real application, you would have a TransferModel
        // For now, we'll just display a placeholder view
        $data = [
            'title' => lang('App.transfers') ?? 'Transfers'
        ];

        return view('transfers/index', $data);
    }

    public function create()
    {
        $data = [
            'products' => $this->productModel->findAll(),
            'warehouses' => $this->warehouseModel->findAll(),
            'title' => lang('App.createTransfer') ?? 'Create Transfer'
        ];

        return view('transfers/create', $data);
    }

    public function store()
    {
        // Validate input
        $rules = [
            'from_warehouse_id' => 'required|numeric',
            'to_warehouse_id' => 'required|numeric|differs[from_warehouse_id]',
            'items' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Get form data
        $fromWarehouseId = $this->request->getPost('from_warehouse_id');
        $toWarehouseId = $this->request->getPost('to_warehouse_id');
        $items = json_decode($this->request->getPost('items'), true);
        $notes = $this->request->getPost('notes');
        
        // Start transaction
        $db = \Config\Database::connect();
        $db->transStart();
        
        try {
            // Generate transfer number
            $transferNumber = 'TRF-' . date('Ymd') . '-' . rand(1000, 9999);
            
            // In a real application, you would save the transfer to a TransferModel
            // For now, we'll just record stock movements
            
            // Process items
            foreach ($items as $item) {
                // Record stock movement for source warehouse (negative)
                helper('stock');
                record_stock_movement(
                    $item['id'],
                    -$item['quantity'],
                    'transfer_out',
                    $transferNumber,
                    lang('App.transferredToWarehouse') ?? 'Transferred to warehouse ' . $toWarehouseId,
                    $fromWarehouseId
                );
                
                // Record stock movement for destination warehouse (positive)
                record_stock_movement(
                    $item['id'],
                    $item['quantity'],
                    'transfer_in',
                    $transferNumber,
                    lang('App.transferredFromWarehouse') ?? 'Transferred from warehouse ' . $fromWarehouseId,
                    $toWarehouseId
                );
            }
            
            // Commit transaction
            $db->transComplete();
            
            if ($db->transStatus() === false) {
                return redirect()->back()->withInput()->with('error', lang('App.transactionFailed') ?? 'Transaction failed');
            }
            
            return redirect()->to('transfers')->with('success', lang('App.transferCreated') ?? 'Transfer created successfully');
            
        } catch (\Exception $e) {
            $db->transRollback();
            
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
    }

    public function show($id)
    {
        // In a real application, you would fetch the transfer from a TransferModel
        // For now, we'll just display a placeholder view
        $data = [
            'title' => lang('App.transferDetails') ?? 'Transfer Details'
        ];
        
        return view('transfers/show', $data);
    }

    public function edit($id)
    {
        // In a real application, you would fetch the transfer from a TransferModel
        // For now, we'll just display a placeholder view
        $data = [
            'products' => $this->productModel->findAll(),
            'warehouses' => $this->warehouseModel->findAll(),
            'title' => lang('App.editTransfer') ?? 'Edit Transfer'
        ];
        
        return view('transfers/edit', $data);
    }

    public function update($id)
    {
        // In a real application, you would update the transfer in a TransferModel
        // For now, we'll just redirect back to the transfers list
        
        return redirect()->to('transfers')->with('success', lang('App.transferUpdated') ?? 'Transfer updated successfully');
    }

    public function delete($id)
    {
        // In a real application, you would delete the transfer from a TransferModel
        // For now, we'll just redirect back to the transfers list
        
        return redirect()->to('transfers')->with('success', lang('App.transferDeleted') ?? 'Transfer deleted successfully');
    }
}