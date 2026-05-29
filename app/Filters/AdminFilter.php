<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    /* Restrict access to administrator accounts only */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the current user has administrator privileges
        if (session()->get('role_id') != 1) {

            return redirect()->to('/unauthorized');
        }
    }

    /* Execute after request processing */
    public function after(RequestInterface $request, ResponseInterface $response, $rguments = null)
    {
        // No post-processing logic required
    }
}