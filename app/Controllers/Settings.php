<?php
namespace App\Controllers;
use App\Models\SettingsModel;
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
}
