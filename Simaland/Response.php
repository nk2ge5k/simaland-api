<?php

namespace Simaland;


class Response implements \ArrayAccess, \IteratorAggregate, \Countable
{
    /**
     * @var Client
     */
    protected $client;
    /**
     * @var array
     */
    protected $items = [];
    /**
     * @var integer
     */
    protected $total_count;
    /**
     * @var integer
     */
    protected $page_count;
    /**
     * @var integer
     */
    protected $current_page;
    /**
     * @var integer
     */
    protected $per_page;
    /**
     * @var 
     */
    protected $pages = [];
    
    /**
     * Response constructor.
     * @param $client
     * @param \Http\Response $response
     */
    public function __construct( Client $client, \Http\Response $response )
    {
        $this->client = $client;
        
        $body = json_decode($response->getBody(), TRUE);
        if ( isset($body['items']) ) {
            $this->items = $body['items'];
        }
        
        if ( isset($body['_meta']) ) {
            $this->total_count = $body['_meta']['totalCount'];
            $this->page_count = $body['_meta']['pageCount'];
            $this->current_page = $body['_meta']['currentPage'];
            $this->per_page = $body['_meta']['perPage'];
        }

        if ( isset($body['_links']) ) {
            $this->pages = array_map('current', $body['_links']);
        }
    }

    /**
     * @return bool
     */
    public function hasNextPage() {
        return isset($this->pages['next']);
    }

    /**
     * @return bool
     */
    public function hasPreviousPage() {
        return isset($this->pages['prev']);
    }

    /**
     * @return Response|null
     */
    public function getNextPage() {
        if ( $this->hasNextPage() ) {
            return $this->client->get(str_replace(Request::API_URL, '', $this->pages['next']));
        }
        return NULL;
    }

    /**
     * @return Response|null
     */
    public function getPreviousPage() {
        if ( $this->hasPreviousPage() ) {
            return $this->client->get(str_replace(Request::API_URL, '', $this->pages['prev']));
        }
        return NULL;
    }

    /**
     * @return Response|null
     */
    public function getLastPage() {
        if ( $this->pages['last'] ) {
            return $this->client->get(str_replace(Request::API_URL, '', $this->pages['last']));
        }
        return NULL;
    }

    /**
     * @return int
     */
    public function getPerPage()
    {
        return $this->per_page;
    }

    /**
     * @return int
     */
    public function getCurrentPage()
    {
        return $this->current_page;
    }

    /**
     * @return int
     */
    public function getPageCount()
    {
        return $this->page_count;
    }

    /**
     * @return int
     */
    public function getTotalCount()
    {
        return $this->total_count;
    }

    /**
     * @param mixed $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->items[$offset];
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     */
    public function offsetSet($offset, $value)
    {
        $this->items[$offset] = $value;
    }

    /**
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param mixed $offset
     */
    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    /**
     * @param int $mode
     * @return mixed
     */
    public function count($mode = COUNT_NORMAL)
    {
        return count($this->items, $mode);
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }
}