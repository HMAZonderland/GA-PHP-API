<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-05-13
 * Time: 21:05
 * To change this template use File | Settings | File Templates.
 */

require_once('MagentoClientLib/MagentoClient.php');

$apiUser = 'Hugo';
$apiKey = 'Ka0yoiAOJhoifqap0oinhlkqfn0oe8vh0234gtQ965WGEWROIUHJWEROIGNRESD98OHL234TWP98YWERFGNLKAERGO87HKJN234TPHJKZWGRHLI';
$host = 'http://magento.presteren.nu/api/soap/?wsdl';

$client = new MagentoClient($apiUser, $apiKey, $host);
$client->connect();
$data = (array)$client->getProductInfo('n2610');
//$data = (array)$client->getProductList();

print "<pre>";
print_r($data);
print "</pre>";