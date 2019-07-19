<?php 

require_once 'vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$es = ClientBuilder::create()->build();
