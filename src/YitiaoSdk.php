<?php

namespace Wored\YitiaoSdk;


use Hanson\Foundation\Foundation;

/***
 * Class ZiMaoDaSdk
 * @package \Wored\YitiaoSdk
 *
 * @property \Wored\YitiaoSdk\Api $api
 */
class YitiaoSdk extends Foundation
{
    protected $providers = [
        ServiceProvider::class
    ];

    public function __construct($config)
    {
        $config['debug'] = $config['debug'] ?? false;
        parent::__construct($config);
    }
    public function request(string $method,array $params=[]){
        return $this->api->request($method,$params);
    }
}