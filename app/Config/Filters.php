<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Filters\CSRF;
use CodeIgniter\Filters\DebugToolbar;
use CodeIgniter\Filters\Honeypot;
use CodeIgniter\Filters\InvalidChars;
use CodeIgniter\Filters\SecureHeaders;

class Filters extends BaseConfig
{
    /**
     * Aliases
     */
    public array $aliases = [

        'csrf' => CSRF::class,

        'toolbar' => DebugToolbar::class,

        'honeypot' => Honeypot::class,

        'invalidchars' => InvalidChars::class,

        'secureheaders' => SecureHeaders::class,

        /* Custom Filters */

        'auth' => \App\Filters\AuthFilter::class,

        'admin' => \App\Filters\AdminFilter::class,

        'staff' => \App\Filters\StaffFilter::class,

        'technician' => \App\Filters\TechnicianFilter::class,

    ];

    /* Global Filters */
    public array $globals = [

        'before' => [

            // 'honeypot',

            // 'csrf',

            // 'invalidchars',

        ],

        'after' => [

            // 'toolbar',

            // 'secureheaders',

        ],

    ];

    /*  Filters */
    public array $methods = [];

    /* Route Filters */
    public array $filters = [];
}