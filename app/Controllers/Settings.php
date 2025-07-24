<?php
namespace App\Controllers;
use App\Models\SettingsModel;
use CodeIgniter\HTTP\RedirectResponse;

class Settings extends BaseController
{
    public function index()
    {
        $model = new SettingsModel();
        $settings = $model->first();
        return view('settings/index', ['settings' => $settings]);
    }

    public function update()
    {
        $model = new SettingsModel();
        $data = [
            'system_name' => $this->request->getPost('system_name'),
            'logo' => $this->request->getPost('logo'),
            'footer' => $this->request->getPost('footer'),
            'currency' => $this->request->getPost('currency'),
            'tax' => $this->request->getPost('tax'),
        ];
        $model->update(1, $data);
        return redirect()->to('/settings')->with('success', 'Settings updated successfully.');
    }
}
