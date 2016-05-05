<?php
/**
 * Created by PhpStorm.
 * User: nk2ge5k
 * Date: 04.05.16
 * Time: 17:27
 */

namespace Simaland;


class Request extends \Http\Request
{
    const API_URL = 'https://www.sima-land.ru/api/v2';

    protected $headers = [
        'Content-type: application/json',
        'Accept: application/json'
    ];

    protected $options = [
        CURLOPT_RETURNTRANSFER  => TRUE,
        CURLOPT_HEADER          => TRUE
    ];

    public function __construct($edge, $method, $fields)
    {
        
        $url = self::API_URL . ( $edge[0] !== '/' ? '/' :  '' ) . $edge;
        
        $options = [];
        
        if ( !empty($fields) ) {
            if ( $method === 'get' ) {
                $url .= '?' . http_build_query($fields);
            } else {
                $options[CURLOPT_POSTFIELDS] = json_encode($fields, JSON_UNESCAPED_UNICODE);
            }
        }
        
        $options[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
        parent::__construct($url, $options);
    }
}