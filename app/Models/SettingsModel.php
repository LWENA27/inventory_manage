<?php
namespace App\Models;
use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'system_name', 'logo', 'footer', 'currency', 'tax', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = true;
}
