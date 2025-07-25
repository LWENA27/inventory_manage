<?php
namespace App\Controllers;
use App\Models\SettingsModel;
use App\Models\CategoryModel;
use CodeIgniter\HTTP\RedirectResponse;

class Settings extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $tenantId = session()->get('tenant_id');
        $settingsKeys = ['system_name', 'logo', 'footer', 'currency', 'tax'];
        $settings = [];
        foreach ($settingsKeys as $key) {
            $settings[$key] = $model->getSetting($key, $tenantId);
        }
        return view('settings/index', ['settings' => $settings]);
    }

    public function update()
    {
        $model = new SettingsModel();
        $tenantId = session()->get('tenant_id');
        $settingsKeys = ['system_name', 'logo', 'footer', 'currency', 'tax'];
        foreach ($settingsKeys as $key) {
            $value = $this->request->getPost($key);
            $model->setSetting($key, $value, $tenantId);
        }
        return redirect()->to('/settings')->with('success', 'Settings updated successfully.');
    }

    public function manageCategory()
    {
        $model = new CategoryModel();
        $tenantId = session()->get('tenant_id');
        $categories = $model->where('tenant_id', $tenantId)->findAll();
        return view('settings/manage_category', ['categories' => $categories]);
    }

    public function addCategory()
    {
        $model = new CategoryModel();
        $tenantId = session()->get('tenant_id');
        $name = $this->request->getPost('name');
        if ($name) {
            $model->insert(['name' => $name, 'tenant_id' => $tenantId]);
            return redirect()->to('settings/manage_category')->with('success', 'Category added successfully.');
        }
        return redirect()->to('settings/manage_category')->with('error', 'Category name required.');
    }

    public function editCategory($id)
    {
        $model = new CategoryModel();
        $tenantId = session()->get('tenant_id');
        $category = $model->where('id', $id)->where('tenant_id', $tenantId)->first();
        if (!$category) {
            return redirect()->to('settings/manage_category')->with('error', 'Category not found.');
        }
        if ($this->request->getMethod() === 'post') {
            $name = $this->request->getPost('name');
            if ($name) {
                $model->update($id, ['name' => $name]);
                return redirect()->to('settings/manage_category')->with('success', 'Category updated successfully.');
            }
            return redirect()->to('settings/category/edit/' . $id)->with('error', 'Category name required.');
        }
        return view('settings/edit_category', ['category' => $category]);
    }

    public function deleteCategory($id)
    {
        $model = new CategoryModel();
        $tenantId = session()->get('tenant_id');
        $category = $model->where('id', $id)->where('tenant_id', $tenantId)->first();
        if ($category) {
            $model->delete($id);
            return redirect()->to('settings/manage_category')->with('success', 'Category deleted successfully.');
        }
        return redirect()->to('settings/manage_category')->with('error', 'Category not found.');
    }
}