<?php
include 'vendor/autoload.php';
include 'src/Exceptions/ApiLowLevelException.php';
include 'src/ApiLowLevel.php';
include 'src/ApiHighLevel.php';
/**
 * Created by PhpStorm.
 * User: Kirill
 * Date: 21.11.2018
 * Time: 23:58
 */
$client = new \AtolAPI\ApiHighLevel();
print_r($client->auth('neletest', 'v2AfscRjr'));