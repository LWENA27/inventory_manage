<?php

namespace App\Models;

use CodeIgniter\Model;

class RoleModel extends Model
{
    protected $table = 'roles';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description', 'tenant_id'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]',
        'tenant_id' => 'required|numeric'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Role name is required',
            'min_length' => 'Role name must be at least 3 characters long',
            'max_length' => 'Role name cannot exceed 50 characters'
        ],
        'tenant_id' => [
            'required' => 'Tenant ID is required',
            'numeric' => 'Tenant ID must be a number'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Get all permissions for a role
     *
     * @param int $roleId
     * @return array
     */
    public function getPermissions($roleId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('role_permissions');
        $builder->select('permissions.*');
        $builder->join('permissions', 'permissions.id = role_permissions.permission_id');
        $builder->where('role_permissions.role_id', $roleId);
        $query = $builder->get();
        
        return $query->getResultArray();
    }

    /**
     * Assign permissions to a role
     *
     * @param int $roleId
     * @param array $permissionIds
     * @return bool
     */
    public function assignPermissions($roleId, $permissionIds)
    {
        $db = \Config\Database::connect();
        
        // First, remove all existing permissions for this role
        $builder = $db->table('role_permissions');
        $builder->where('role_id', $roleId);
        $builder->delete();
        
        // Then, add the new permissions
        $data = [];
        foreach ($permissionIds as $permissionId) {
            $data[] = [
                'role_id' => $roleId,
                'permission_id' => $permissionId
            ];
        }
        
        if (!empty($data)) {
            $builder->insertBatch($data);
        }
        
        return true;
    }

    /**
     * Check if a role has a specific permission
     *
     * @param int $roleId
     * @param int $permissionId
     * @return bool
     */
    public function hasPermission($roleId, $permissionId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('role_permissions');
        $builder->where('role_id', $roleId);
        $builder->where('permission_id', $permissionId);
        $count = $builder->countAllResults();
        
        return $count > 0;
    }

    /**
     * Get all roles for a tenant
     *
     * @param int $tenantId
     * @return array
     */
    public function getRolesByTenant($tenantId)
    {
        return $this->where('tenant_id', $tenantId)->findAll();
    }
}