<?php

namespace Simaland;


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
     * @var string
     */
    protected $user_agent = 'nk2ge5k/simaland-api';

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
        if ( !is_null($login) )
            $this->setBasicAuthentication( $login, !is_null($password) ? $password : '' );
    }

    /**
     * @param $edge
     * @param string $method
     * @param array $params
     * @return Request
     */
    public function request( $edge, $method='get', $params = []) {
        if ( !in_array(strtolower($method), ['get', 'post', 'put', 'delete']) ) {
            throw  new \InvalidArgumentException( sprintf('Unknown method %s', $method) );
        }
        
        $request = new Request($edge, $method, $params);
        $request
            ->setOptions($this->options)
            ->setOption(CURLOPT_USERAGENT, $this->user_agent);
        
        return $request;
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