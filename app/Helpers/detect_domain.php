<?php
use Config\Services;

//--------------------------------------------------------------------

if (! function_exists('get_domain_code'))
{
    function get_domain_code() : int
    {
        $request = \Config\Services::request();

        switch ($request->uri->getHost())
        {
            case 'ytubey.com':
                return DOMAIN_YTUBEY;

            default:
                return DOMAIN_YTUBER;
        }
    }
}