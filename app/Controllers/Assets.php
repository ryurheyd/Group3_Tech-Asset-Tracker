<?php

namespace App\Controllers;

use App\Models\AssetModel;
use CodeIgniter\I18n\Time;

class Assets extends BaseController
{
    public function __construct()
    {
        // Ensure that only authenticated users can access this controller
        if (!session()->get('isLoggedIn')) {

            redirect()->to('/login')->send();

            exit;
        }
    }

    /* Display all assets */
    public function index()
    {
        $model = new AssetModel();

        // Retrieve all assets ordered by newest first
        $data['assets'] = $model
            ->orderBy('id', 'DESC')
            ->findAll();

        return view('assets/index', $data);
    }

    /* Store a newly created asset */
    public function store()
    {
        // Asset form validation rules
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

        // Return with validation errors if input is invalid
        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        $model = new AssetModel();

        // Insert new asset record
        $save = $model->insert([

            // Temporary asset code before generating final code
            'asset_code' => 'TEMP-' . strtoupper(substr(uniqid(), -6)),

            'asset_name' => $this->request->getPost('asset_name'),

            'category' => $this->request->getPost('category'),

            'brand' => $this->request->getPost('brand'),

            // Auto-generate serial number
            'serial_number' => 'SN-' . strtoupper(substr(uniqid(), -8)),

            // Store current Philippine date and time
            'purchase_date' => Time::now('Asia/Manila')->toDateTimeString(),

            'assigned_to' => $this->request->getPost('assigned_to'),

            'status' => $this->request->getPost('status'),

            // Record creation timestamp
            'created_at' => Time::now('Asia/Manila')->toDateTimeString(),

            'updated_at' => null

        ]);

        // Get inserted asset ID
        $insertID = $model->getInsertID();

        // Generate permanent asset code (e.g. AST-00001)
        $assetCode =
            'AST-' .
            str_pad(
                $insertID,
                5,
                '0',
                STR_PAD_LEFT
            );

        // Update asset with generated asset code
        $model->update($insertID, [
            'asset_code' => $assetCode
        ]);

        // Handle insert failure
        if (!$save) {

            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to add asset');
        }

        return redirect()->to('/assets')
            ->with('success', 'Asset added successfully');
    }

    /* Update an existing asset */
    public function update($id)
    {
        $model = new AssetModel();

        // Check if asset exists
        $asset = $model->find($id);

        if (!$asset) {

            return redirect()->back()
                ->with('error', 'Asset not found');
        }

        // Validation rules for updating asset information
        $rules = [

            'asset_name' => 'required|min_length[2]',

            'category' => 'required',

            'brand' => 'required',

            'status' => 'required'
        ];

        // Return validation errors if input is invalid
        if (!$this->validate($rules)) {

            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Update asset details
        $model->update($id, [

            'asset_name' => $this->request->getPost('asset_name'),

            'category' => $this->request->getPost('category'),

            'brand' => $this->request->getPost('brand'),

            'serial_number' => $this->request->getPost('serial_number'),

            // Update purchase date using current Philippine time
            'purchase_date' => Time::now('Asia/Manila')->toDateTimeString(),

            'assigned_to' => $this->request->getPost('assigned_to'),

            'status' => $this->request->getPost('status'),

            // Record last modification timestamp
            'updated_at' => Time::now('Asia/Manila')->toDateTimeString()

        ]);

        return redirect()->back()
            ->with('success', 'Asset updated successfully');
    }

    /* Delete an asset */
    public function delete($id)
    {
        $model = new AssetModel();

        // Verify asset existence before deletion
        $asset = $model->find($id);

        if (!$asset) {

            return redirect()->back()
                ->with('error', 'Asset not found');
        }

        // Remove asset record from database
        $model->delete($id);

        return redirect()->back()
            ->with('success', 'Asset deleted successfully');
    }

    /* Display asset details */
    public function view($id)
    {
        $model = new AssetModel();

        // Retrieve asset information
        $data['asset'] = $model->find($id);

        // Redirect if asset does not exist
        if (!$data['asset']) {

            return redirect()->to('/assets')
                ->with('error', 'Asset not found');
        }

        return view('assets/view', $data);
    }
}