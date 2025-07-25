<?php
namespace App\Models;
use CodeIgniter\Model;

class SettingsModel extends Model
{
    protected $table = 'settings';
    protected $primaryKey = 'id';
protected $allowedFields = [
    'tenant_id', 'key', 'value', 'created_at', 'updated_at'
];

/**
 * Get a setting value by key for a tenant
 */
public function getSetting($key, $tenantId = null)
{
    $where = ['key' => $key];
    if ($tenantId) {
        $where['tenant_id'] = $tenantId;
    }
    $setting = $this->where($where)->first();
    return $setting['value'] ?? null;
}

/**
 * Set a setting value by key for a tenant
 */
public function setSetting($key, $value, $tenantId = null)
{
    $where = ['key' => $key];
    if ($tenantId) {
        $where['tenant_id'] = $tenantId;
    }
    $existing = $this->where($where)->first();
    if ($existing) {
        return $this->update($existing['id'], ['value' => $value]);
    } else {
        $data = ['key' => $key, 'value' => $value];
        if ($tenantId) {
            $data['tenant_id'] = $tenantId;
        }
        return $this->insert($data);
    }
}
    protected $useTimestamps = true;
}
