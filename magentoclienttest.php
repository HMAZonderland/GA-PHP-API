<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Hugo Zonderland
 * Date: 07-05-13
 * Time: 11:48
 * To change this template use File | Settings | File Templates.
 */

// Start session
session_start();

// Report all errors
error_reporting(-1);

// Include the MagentoClient library
require_once('MagentoClientLib/MagentoClientProofofConcept.php');

// Variabels used
$apiUser = 'Hugo';
$apiKey = 'Ka0yoiAOJhoifqap0oinhlkqfn0oe8vh0234gtQ965WGEWROIUHJWEROIGNRESD98OHL234TWP98YWERFGNLKAERGO87HKJN234TPHJKZWGRHLI';
$host = 'http://magento.presteren.nu/api/soap/?wsdl'; // SOAP V1 API URL

// Create MagentoClient object and connect to the host
$client = new MagentoClient($apiUser, $apiKey, $host);

echo "<pre>";
print_r($client->getProductInfoById(16)); // Gets the product by its Id
echo "</pre>";
