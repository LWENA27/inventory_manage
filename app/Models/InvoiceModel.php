<?php
namespace App\Models;
use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tenant_id', 'customer_id', 'total', 'status', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
}
