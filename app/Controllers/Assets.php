<?php

namespace App\Controllers;

use App\Models\AssetModel;
use CodeIgniter\I18n\Time;

class Assets extends BaseController
{
    public function __construct()
    {
        if (!session()->get('isLoggedIn')) {

            redirect()->to('/login')->send();

            exit;
        }
    }

    public function index()
    {
        $model = new AssetModel();

        $data['assets'] = $model
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('assets/index', $data);
    }

    public function store()
    {
        $rules = [

            'asset_name' => [
                'rules' => 'required|min_length[2]',
                'errors' => [
                    'required' => 'Asset name is required.',
                    'min_length' => 'Asset name must be at least 2 characters.'
                ]
            ],

            'category' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Category is required.'
                ]
            ],

            'brand' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Brand is required.'
                ]
            ],

            'status' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Status is required.'
                ]
            ]
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new AssetModel();

        $save = $model->insert([

            'asset_code' => 'TEMP-' . strtoupper(substr(uniqid(), -6)),

            'asset_name' => $this->request->getPost('asset_name'),

            'category' => $this->request->getPost('category'),

            'brand' => $this->request->getPost('brand'),

            'serial_number' => 'SN-' . strtoupper(substr(uniqid(), -8)),

            'purchase_date' => Time::now('Asia/Manila')->toDateTimeString(),

            'assigned_to' => $this->request->getPost('assigned_to'),

            'status' => $this->request->getPost('status'),

            'created_at' => Time::now('Asia/Manila')->toDateTimeString(),

            'updated_at' => null

        ]);

        $insertID = $model->getInsertID();

        $assetCode =
            'AST-' .
            str_pad(
                $insertID,
                5,
                '0',
                STR_PAD_LEFT
            );

        $model->update($insertID, [
            'asset_code' => $assetCode
        ]);

        if (!$save) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add asset');
        }

        return redirect()->to('/assets')
            ->with('success', 'Asset added successfully');
    }

    public function update($id)
    {
        $model = new AssetModel();

        $asset = $model->find($id);

        if (!$asset) {

            return redirect()->back()
                ->with('error', 'Asset not found');
        }

        $rules = [

            'asset_name' => 'required|min_length[2]',

            'category' => 'required',

            'brand' => 'required',

            'status' => 'required'
        ];

        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model->update($id, [

            'asset_name' => $this->request->getPost('asset_name'),

            'category' => $this->request->getPost('category'),

            'brand' => $this->request->getPost('brand'),

            'serial_number' => $this->request->getPost('serial_number'),

            'purchase_date' => Time::now('Asia/Manila')->toDateTimeString(),

            'assigned_to' => $this->request->getPost('assigned_to'),

            'status' => $this->request->getPost('status'),

            'updated_at' => Time::now('Asia/Manila')->toDateTimeString()

        ]);

        return redirect()->back()
            ->with('success', 'Asset updated successfully');
    }

    public function delete($id)
    {
        $model = new AssetModel();

        $asset = $model->find($id);

        if (!$asset) {

            return redirect()->back()
                ->with('error', 'Asset not found');
        }

        $model->delete($id);

        return redirect()->back()
            ->with('success', 'Asset deleted successfully');
    }

    public function view($id)
    {
        $model = new AssetModel();

        $data['asset'] = $model->find($id);

        if (!$data['asset']) {

            return redirect()->to('/assets')
                ->with('error', 'Asset not found');
        }

        return view('assets/view', $data);
    }
}