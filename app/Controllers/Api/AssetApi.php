<?php

namespace App\Controllers\Api;

use App\Models\AssetModel;
use CodeIgniter\RESTful\ResourceController;

class AssetApi extends ResourceController
{
    // Define the model used by this API controller
    protected $modelName = AssetModel::class;

    // Set JSON as the default response format
    protected $format = 'json';

    /* Retrieve all assets */
    public function index()
    {
        return $this->respond(
            $this->model->findAll()
        );
    }

    /* Retrieve a single asset by ID */
    public function show($id = null)
    {
        $data = $this->model->find($id);

        // Return 404 if asset does not exist
        if (!$data) {

            return $this->failNotFound(
                'Asset not found'
            );
        }

        return $this->respond($data);
    }

    /* Create a new asset record */
    public function create()
    {
        // Get JSON request payload
        $data = $this->request->getJSON(true);

        // Validate incoming JSON data
        if (!$data) {

            return $this->fail(
                'Invalid JSON data'
            );
        }

        // Prepare asset data for insertion
        $insertData = [

            'asset_name' => $data['asset_name'] ?? '',

            'category' => $data['category'] ?? '',

            'brand' => $data['brand'] ?? '',

            'serial_number' => $data['serial_number'] ?? '',

            // Default status if not provided
            'status' => $data['status'] ?? 'Available',

            'assigned_to' => $data['assigned_to'] ?? '',

            // Default purchase date is today's date
            'purchase_date' => $data['purchase_date'] ?? date('Y-m-d'),

            // Record creation timestamp
            'created_at' => date('Y-m-d H:i:s'),

            'updated_at' => null

        ];

        // Insert asset into database
        $this->model->insert($insertData);

        // Get newly inserted asset ID
        $insertID = $this->model->getInsertID();

        // Generate unique asset code (e.g. AST-00001)
        $assetCode =
            'AST-' .
            str_pad(
                $insertID,
                5,
                '0',
                STR_PAD_LEFT
            );

        // Save generated asset code
        $this->model->update(
            $insertID,
            [
                'asset_code' => $assetCode
            ]
        );

        return $this->respondCreated([

            'status' => 'success',

            'message' => 'Asset created successfully',

            'asset_code' => $assetCode

        ]);
    }

    /* Update an existing asset */
    public function update($id = null)
    {
        // Check if asset exists
        $asset = $this->model->find($id);

        if (!$asset) {

            return $this->failNotFound(
                'Asset not found'
            );
        }

        // Get updated data from request
        $data = $this->request->getJSON(true);

        // Preserve existing values when no new value is provided
        $updateData = [

            'asset_name' =>
                $data['asset_name']
                ?? $asset['asset_name'],

            'category' =>
                $data['category']
                ?? $asset['category'],

            'brand' =>
                $data['brand']
                ?? $asset['brand'],

            'serial_number' =>
                $data['serial_number']
                ?? $asset['serial_number'],

            'status' =>
                $data['status']
                ?? $asset['status'],

            'assigned_to' =>
                $data['assigned_to']
                ?? $asset['assigned_to'],

            'purchase_date' =>
                $data['purchase_date']
                ?? $asset['purchase_date'],

            // Update modification timestamp
            'updated_at' =>
                date('Y-m-d H:i:s')

        ];

        // Save updated asset information
        $this->model->update(
            $id,
            $updateData
        );

        return $this->respond([

            'status' => 'success',

            'message' => 'Asset updated successfully'

        ]);
    }

    /* Delete an asset by ID */
    public function delete($id = null)
    {
        // Check if asset exists before deletion
        $asset = $this->model->find($id);

        if (!$asset) {

            return $this->failNotFound(
                'Asset not found'
            );
        }

        // Remove asset from database
        $this->model->delete($id);

        return $this->respond([

            'status' => 'success',

            'message' => 'Asset deleted successfully'

        ]);
    }
}