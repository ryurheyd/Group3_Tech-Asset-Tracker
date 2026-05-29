<?php

namespace App\Controllers;

use App\Models\AssetModel;

class Dashboard extends BaseController
{
    /* Display dashboard statistics and recent assets */
    public function index()
    {
        // Ensure that only authenticated users can access the dashboard
        if (!session()->get('isLoggedIn')) {

            return redirect()->to('/login');
        }

        $model = new AssetModel();

        // Get total number of assets
        $data['totalAssets'] = $model->countAll();

        // Count assets currently available
        $data['availableAssets'] = $model
            ->where('status', 'Available')
            ->countAllResults();

        // Count assets assigned to users
        $data['assignedAssets'] = $model
            ->where('status', 'Assigned')
            ->countAllResults();

        // Count damaged assets
        $data['damagedAssets'] = $model
            ->where('status', 'Damaged')
            ->countAllResults();

        // Count assets under maintenance
        $data['maintenanceAssets'] = $model
            ->where('status', 'Maintenance')
            ->countAllResults();

        // Retrieve the 5 most recently added assets
        $data['recentAssets'] = $model
            ->orderBy('id', 'DESC')
            ->findAll(5);

        return view('dashboard/index', $data);
    }
}