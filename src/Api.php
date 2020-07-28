<?php

namespace Wored\YitiaoSdk;


use Hanson\Foundation\AbstractAPI;
use Hanson\Foundation\Http;

class Api extends AbstractAPI
{
    public $config;

    /**
     * Api constructor.
     * @param $appkey
     * @param $appsecret
     * @param $sid
     * @param $baseUrl
     */
    public function __construct(YitiaoSdk $yitiaoSdk)
    {
        $this->config = $yitiaoSdk->getConfig();
    }

    /**
     * @param string $urlPath
     * @param array $params
     * @return mixed
     */
    public function request(string $method, array $params)
    {
        $paramsAll = [
            "_ft"   => 'json',
            "_vc"   => '1',
            "_mt"   => $method,
            "_sm"   => 'rsa',
            "_tpid" => $this->config['thirdPartyId'],
        ];
        foreach ($params as &$vo){
            if(is_array($vo)){//二维数组的参数转json字符串
                $vo=json_encode($vo);
            }
        }
        $paramsAll = array_merge($paramsAll, $params);
        $paramsAll['_sig'] = $this->sign($paramsAll);
        $requestUrl = $this->config['rootUrl'] . '?' . http_build_query($paramsAll);
        $http = new Http();
        $response = $http->post($requestUrl);
        return json_decode(strval($response->getBody()), true);
    }

    /**
     * 秘钥转RSA源
     * @param $key 秘钥
     * @param string $type 秘钥类别
     * @return string
     */
    public function keyToResource($key, $type = 'PUBLIC')
    {
        return "-----BEGIN RSA $type KEY-----\n$key\n-----END RSA $type KEY-----";
    }

    /**
     * 生成签名
     * @param array $request_params
     * @return string
     */
    public function sign(array $params)
    {
        ksort($params);
        $str = '';
        foreach ($params as $key => $value) {
            $str .= $key . "=" . $value;
        }
        $key = $this->keyToResource($this->config['rsaPrivateKey'], 'PRIVATE');
        $signature = '';
        openssl_sign($str, $signature, $key, "sha1WithRSAEncryption");
        $result = base64_encode($signature);
        return $result;
    }
}