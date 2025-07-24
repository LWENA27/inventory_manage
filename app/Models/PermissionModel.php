<?php

namespace App\Models;

use CodeIgniter\Model;

class PermissionModel extends Model
{
    protected $table = 'permissions';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $allowedFields = ['name', 'description'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $validationRules = [
        'name' => 'required|min_length[3]|max_length[50]|is_unique[permissions.name,id,{id}]'
    ];
    protected $validationMessages = [
        'name' => [
            'required' => 'Permission name is required',
            'min_length' => 'Permission name must be at least 3 characters long',
            'max_length' => 'Permission name cannot exceed 50 characters',
            'is_unique' => 'Permission with this name already exists'
        ]
    ];
    protected $skipValidation = false;

    /**
     * Get all roles that have this permission
     *
     * @param int $permissionId
     * @return array
     */
    public function getRoles($permissionId)
    {
        $db = \Config\Database::connect();
        $builder = $db->table('role_permissions');
        $builder->select('roles.*');
        $builder->join('roles', 'roles.id = role_permissions.role_id');
        $builder->where('role_permissions.permission_id', $permissionId);
        $query = $builder->get();
        
        return $query->getResultArray();
    }

    /**
     * Get permissions by module
     * 
     * @param string $module
     * @return array
     */
    public function getByModule($module)
    {
        return $this->like('name', $module . '.')->findAll();
    }

    /**
     * Seed default permissions
     * 
     * @return void
     */
    public function seedDefaultPermissions()
    {
        $defaultPermissions = [
            // Dashboard permissions
            ['name' => 'dashboard.view', 'description' => 'View dashboard'],
            
            // User permissions
            ['name' => 'users.view', 'description' => 'View users'],
            ['name' => 'users.create', 'description' => 'Create users'],
            ['name' => 'users.edit', 'description' => 'Edit users'],
            ['name' => 'users.delete', 'description' => 'Delete users'],
            
            // Role permissions
            ['name' => 'roles.view', 'description' => 'View roles'],
            ['name' => 'roles.create', 'description' => 'Create roles'],
            ['name' => 'roles.edit', 'description' => 'Edit roles'],
            ['name' => 'roles.delete', 'description' => 'Delete roles'],
            
            // Product permissions
            ['name' => 'products.view', 'description' => 'View products'],
            ['name' => 'products.create', 'description' => 'Create products'],
            ['name' => 'products.edit', 'description' => 'Edit products'],
            ['name' => 'products.delete', 'description' => 'Delete products'],
            
            // Inventory permissions
            ['name' => 'inventory.view', 'description' => 'View inventory'],
            ['name' => 'inventory.adjust', 'description' => 'Adjust inventory'],
            
            // POS permissions
            ['name' => 'pos.access', 'description' => 'Access POS system'],
            ['name' => 'pos.checkout', 'description' => 'Process checkout in POS'],
            ['name' => 'pos.discount', 'description' => 'Apply discounts in POS'],
            
            // Invoice permissions
            ['name' => 'invoices.view', 'description' => 'View invoices'],
            ['name' => 'invoices.create', 'description' => 'Create invoices'],
            ['name' => 'invoices.edit', 'description' => 'Edit invoices'],
            ['name' => 'invoices.delete', 'description' => 'Delete invoices'],
            
            // Purchase permissions
            ['name' => 'purchases.view', 'description' => 'View purchases'],
            ['name' => 'purchases.create', 'description' => 'Create purchases'],
            ['name' => 'purchases.edit', 'description' => 'Edit purchases'],
            ['name' => 'purchases.delete', 'description' => 'Delete purchases'],
            
            // Transfer permissions
            ['name' => 'transfers.view', 'description' => 'View transfers'],
            ['name' => 'transfers.create', 'description' => 'Create transfers'],
            ['name' => 'transfers.edit', 'description' => 'Edit transfers'],
            ['name' => 'transfers.delete', 'description' => 'Delete transfers'],
            
            // Report permissions
            ['name' => 'reports.view', 'description' => 'View reports'],
            ['name' => 'reports.sales', 'description' => 'View sales reports'],
            ['name' => 'reports.purchases', 'description' => 'View purchase reports'],
            ['name' => 'reports.inventory', 'description' => 'View inventory reports'],
            ['name' => 'reports.profit', 'description' => 'View profit reports'],
            
            // Settings permissions
            ['name' => 'settings.view', 'description' => 'View settings'],
            ['name' => 'settings.edit', 'description' => 'Edit settings']
        ];
        
        foreach ($defaultPermissions as $permission) {
            // Check if permission already exists
            $exists = $this->where('name', $permission['name'])->first();
            if (!$exists) {
                $this->insert($permission);
            }
        }
    }
}