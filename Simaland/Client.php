<?php

namespace Simaland;


use Http\Request;

class Client extends \Http\Client
{
    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $password;
    /**
     * @var \Http\Client
     */
    protected $curl;

    /**
     * Client constructor.
     * @param string $login
     * @param string $password
     */
    public function __construct( $login = null, $password = null )
    {
        $this->curl = new \Http\Client();
        $this->login    = $login;
        $this->password = $password;
    }

    /**
     * @param $edge
     * @param string $method
     * @param array $params
     * @return \Simaland\Request
     */
    public function request( $edge, $method='get', $params = []) {
        if ( !in_array(strtolower($method), ['get', 'post', 'put', 'delete']) ) {
            throw  new \InvalidArgumentException( sprintf('Unknown method %s', $method) );
        }
        
        return new \Simaland\Request($edge, $method, $params);
    }

    /**
     * @param $edge
     * @param array $params
     * @param array $additional
     * @return Response
     */
    public function get( $edge, $params = [] ) {
        $response = $this->sendRequest($this->request($edge, 'get', $params));
        return new Response($this, $response);
    }

    public function post( $edge, $params = [] ) {
        
    }

    public function put( $edge, $params = [] ) {

    }

    public function delete( $edge ) {

    }
}