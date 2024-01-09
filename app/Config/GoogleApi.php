<?php namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Class GoogleApi
 * @package Config
 */
class GoogleApi extends BaseConfig
{
    /**
     * @var string
     */
    public $clientId        = '1049057798715-g7l155abp2vr631mr2tpiicdqot9t5ni.apps.googleusercontent.com';

    /**
     * @var string
     */
    public $clientSecret    = 'MBm6jkydnjsEPLFxt8OHsIFw';

    /**
     * @var string
     */
    public $redirectUrl     = 'https://ytuber.ru/auth/googleLogin';

    /**
     * @var string
     */
    public $developerKey    = 'AIzaSyBOED4gtX_l14emzOonoAaWcXHVcADTnHw';
}