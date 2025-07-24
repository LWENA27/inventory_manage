<?php
namespace App\Controllers;
use App\Models\TrialModel;
use CodeIgniter\Controller;

class Trial extends Controller
{
    public function status()
    {
        // ...existing code...
        $trialModel = new TrialModel();
        $status = $trialModel->getTrialStatus(session('user_id'));
        return view('trial/status', ['status' => $status]);
    }
}
