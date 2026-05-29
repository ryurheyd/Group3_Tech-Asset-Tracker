<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class StaffFilter implements FilterInterface
{
    /* Restrict access to staff accounts only */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the current user has staff privileges
        if (session()->get('role_id') != 2) {

            return redirect()->to('/unauthorized');
        }
    }

    /* Execute after request processing */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing logic required
    }
}