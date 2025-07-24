<?php
namespace App\Models;
use CodeIgniter\Model;

class ProductBatchModel extends Model
{
    protected $table = 'product_batches';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'product_id', 'warehouse_id', 'batch_number', 'expiry_date', 'quantity', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
}
