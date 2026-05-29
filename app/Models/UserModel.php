<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    // Database table used by this model
    protected $table = 'users';

    // Fields allowed for insert and update operations
    protected $allowedFields = [
        'name',
        'email',
        'password',
        'profile_image',
        'role_id'
    ];

    // Automatically manage timestamp fields
    protected $useTimestamps = true;

    // Field used to store record creation date
    protected $createdField = 'created_at';

    // Field used to store record update date
    protected $updatedField = 'updated_at';
}