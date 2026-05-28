<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    protected $table = 'assets';

    protected $primaryKey = 'id';

    protected $returnType = 'array';

    protected $useAutoIncrement = true;

    protected $allowedFields = [

        'asset_code',

        'asset_name',

        'category',

        'brand',

        'model',

        'serial_number',

        'purchase_date',

        'assigned_to',

        'location',

        'status',

        'remarks',

        'created_at',

        'updated_at'

    ];

    protected $useTimestamps = true;

    protected $createdField = 'created_at';

    protected $updatedField = 'updated_at';
}