<?php
namespace App\Models;
use CodeIgniter\Model;

class StockMovementModel extends Model
{
    protected $table = 'stock_movements';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id', 'warehouse_id', 'user_id', 'batch_id', 'quantity', 'operation', 'reason', 'expiry_date', 'created_at'
    ];
    protected $useTimestamps = false;
}
