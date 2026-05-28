<?php

namespace App\Controllers\Api;

use App\Models\AssetModel;
use CodeIgniter\RESTful\ResourceController;

class AssetApi extends ResourceController
{
    protected $modelName = AssetModel::class;

    protected $format = 'json';

    public function index()
    {
        return $this->respond(
            $this->model->findAll()
        );
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);

        if (!$data) {

            return $this->failNotFound(
                'Asset not found'
            );
        }

        return $this->respond($data);
    }

    public function create()
    {
        $data = $this->request->getJSON(true);

        if (!$data) {

            return $this->fail(
                'Invalid JSON data'
            );
        }

        $insertData = [

            'asset_name' => $data['asset_name'] ?? '',

            'category' => $data['category'] ?? '',

            'brand' => $data['brand'] ?? '',

            'serial_number' => $data['serial_number'] ?? '',

            'status' => $data['status'] ?? 'Available',

            'assigned_to' => $data['assigned_to'] ?? '',

            'purchase_date' => $data['purchase_date'] ?? date('Y-m-d'),

            'created_at' => date('Y-m-d H:i:s'),

            'updated_at' => null

        ];

        $this->model->insert($insertData);

        $insertID = $this->model->getInsertID();

        $assetCode =
            'AST-' .
            str_pad(
                $insertID,
                5,
                '0',
                STR_PAD_LEFT
            );

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

    public function update($id = null)
    {
        $asset = $this->model->find($id);

        if (!$asset) {

            return $this->failNotFound(
                'Asset not found'
            );
        }

        $data = $this->request->getJSON(true);

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

            'updated_at' =>
                date('Y-m-d H:i:s')

        ];

        $this->model->update(
            $id,
            $updateData
        );

        return $this->respond([

            'status' => 'success',

            'message' => 'Asset updated successfully'

        ]);
    }

    public function delete($id = null)
    {
        $asset = $this->model->find($id);

        if (!$asset) {

            return $this->failNotFound(
                'Asset not found'
            );
        }

        $this->model->delete($id);

        return $this->respond([

            'status' => 'success',

            'message' => 'Asset deleted successfully'

        ]);
    }
}