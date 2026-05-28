<?php

namespace App\Controllers;

use App\Models\AssetModel;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {

            return redirect()->to('/login');
        }

        $model = new AssetModel();

        $data['totalAssets'] = $model->countAll();

        $data['availableAssets'] = $model
            ->where('status', 'Available')
            ->countAllResults();

        $data['assignedAssets'] = $model
            ->where('status', 'Assigned')
            ->countAllResults();

        $data['damagedAssets'] = $model
            ->where('status', 'Damaged')
            ->countAllResults();

        $data['maintenanceAssets'] = $model
            ->where('status', 'Maintenance')
            ->countAllResults();

        $data['recentAssets'] = $model
            ->orderBy('id', 'DESC')
            ->findAll(5);

        return view('dashboard/index', $data);
    }
}