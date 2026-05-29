<?php

namespace App\Models;

use CodeIgniter\Model;

class AssetModel extends Model
{
    // Database table used by this model
    protected $table = 'assets';

    // Primary key of the table
    protected $primaryKey = 'id';

    // Return query results as associative arrays
    protected $returnType = 'array';

    // Enable auto-increment for primary key
    protected $useAutoIncrement = true;

    // Fields allowed for insert and update operations
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

    // Automatically manage timestamp fields
    protected $useTimestamps = true;

    // Field used to store record creation date
    protected $createdField = 'created_at';

    // Field used to store record update date
    protected $updatedField = 'updated_at';
}