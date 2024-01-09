<?php namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Custom implements FilterInterface
{
    public function before(RequestInterface $request)
    {
        // Do something here
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response)
    {
        $body = preg_replace('#<!--(.*?)-->#s', '', $response->getBody());

        $response->setBody($body);

        return $response;
    }
}