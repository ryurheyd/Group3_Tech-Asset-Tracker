<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    /* Restrict access to authenticated users only */
    public function before(RequestInterface $request, $arguments = null)
    {
        // Check if the user has an active login session
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login');
        }
    }

    /* Execute after request processing */
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing logic required
    }
}