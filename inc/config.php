<?php

/* Config */

$index = "capesbtd";

/* Load libraries for PHP composer */ 
require 'vendor/autoload.php'; 

$hosts=["localhost"];

/* Load Elasticsearch Client */ 
$client = \Elasticsearch\ClientBuilder::create()->setHosts($hosts)->build(); 

?>