<?php
namespace App\Models;
use CodeIgniter\Model;

class InvoiceModel extends Model
{
    protected $table = 'invoices';
    protected $primaryKey = 'id';
protected $allowedFields = [
    'tenant_id',
    'customer_id',
    'invoice_number',
    'customer_name',
    'subtotal',
    'discount',
    'discount_percent',
    'tax',
    'tax_percent',
    'total_amount',
    'payment_method',
    'amount_paid',
    'status',
    'created_by',
    'created_by_name',
    'created_at',
    'updated_at'
];
    protected $useTimestamps = true;
}
