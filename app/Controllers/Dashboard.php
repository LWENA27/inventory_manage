<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    public function index()
    {
        if (!session('isLoggedIn')) {
            return redirect()->to('/login');
        }
        $trialModel = new \App\Models\TrialModel();
        $status = $trialModel->getTrialStatus(session('user_id'));
        return view('dashboard/index', ['status' => $status]);
    }
}
