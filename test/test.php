<?php

require_once '../vendor/autoload.php';

$client = new Simaland\Client();

$category = $client->get('category', ['page' => '2']);
foreach ( $category as $item ) {
    var_dump($item);
}