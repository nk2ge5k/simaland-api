<?php

require_once '../vendor/autoload.php';

$client = new Simaland\Client();

$category = $client->get('category', ['slug' => 'stroitelstvo-i-remont/vodosnabzhenie-i-vodootvedenie']);
var_dump($category->getBody());
foreach ( $category as $item ) {
    var_dump($item);
}