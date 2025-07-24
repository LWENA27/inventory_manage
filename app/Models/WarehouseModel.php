<?php
namespace App\Models;
use CodeIgniter\Model;

class WarehouseModel extends Model
{
    protected $table = 'warehouses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 'name', 'location', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
}
