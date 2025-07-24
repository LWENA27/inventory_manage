<?php
namespace App\Models;
use CodeIgniter\Model;

class TrialModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    public function getTrialStatus($userId)
    {
        $user = $this->find($userId);
        if (!$user) return 'not_found';
        $now = date('Y-m-d');
        if ($user['trial_ends_at'] >= $now) {
            $daysLeft = (strtotime($user['trial_ends_at']) - strtotime($now)) / 86400;
            return ['active' => true, 'days_left' => $daysLeft];
        }
        return ['active' => false, 'days_left' => 0];
    }
}
