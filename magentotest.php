<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 03-05-13
 * Time: 21:05
 * To change this template use File | Settings | File Templates.
 */
session_start();
error_reporting(-1);

require_once('MagentoClientLib/MagentoClient.php');
require_once dirname(__FILE__) . '/GoogleClientLib/Google_Client.php';
require_once dirname(__FILE__) . '/GoogleClientLib/contrib/Google_AnalyticsService.php';
require_once dirname(__FILE__) . '/classes/GoogleAnalyticsMetricsParser.php';
require_once dirname(__FILE__) . '/GoogleAnalyticsMetrics/OrderPerMarketingChannel.php';

$scriptUri = "http://" . $_SERVER["HTTP_HOST"] . $_SERVER['PHP_SELF'];

$client = new Google_Client(); // GoogleClient init
$client->setAccessType('online'); // default: offline
$client->setApplicationName('esser-emerik rendements berekening API'); // Title
$client->setClientId('211121854101.apps.googleusercontent.com'); // ClientId
$client->setClientSecret('UWMHZxqbyYvbzFrVqSK_45to'); // ClientSecret
$client->setRedirectUri($scriptUri); // Where to redirect to after authentication
$client->setDeveloperKey('AIzaSyAYWJ-TCPgMkE101Jy2OLZXkmyP1-cCsBE'); // Developer key

// $service implements the client interface, has to be set before auth cal
$service = new Google_AnalyticsService($client);

if (isset($_GET['logout'])) { // logout: destroy token
    unset($_SESSION['token']);
    die('Logged out.');
}

if (isset($_GET['code'])) { // we received the positive auth callback, get the token and store it in session
    $client->authenticate();
    $_SESSION['token'] = $client->getAccessToken();
}

if (isset($_SESSION['token'])) { // extract token from session and configure client
    $token = $_SESSION['token'];
    $client->setAccessToken($token);
}

if (!$client->getAccessToken()) { // auth call to google
    $authUrl = $client->createAuthUrl();
    header("Location: " . $authUrl);
    die;
}

$apiUser = 'Hugo';
$apiKey = 'Ka0yoiAOJhoifqap0oinhlkqfn0oe8vh0234gtQ965WGEWROIUHJWEROIGNRESD98OHL234TWP98YWERFGNLKAERGO87HKJN234TPHJKZWGRHLI';
$host = 'http://magento.presteren.nu/api/soap/?wsdl';

$mClient = new MagentoClient($apiUser, $apiKey, $host);

$from = date('Y-m-d', time() - 30 * 24 * 60 * 60); // 30 days
$to = date('Y-m-d'); // today

$profileId = '71750844';

$OrderPerMarketingChannel = new OrderPerMarketingChannel($service, $profileId, $from, $to);
$data = $OrderPerMarketingChannel->getOrdersPerChannel();

$profit = 0;

foreach ($data as $mcKey => $mcValue) {
    echo "<h1>" . $mcKey . "</h1>";
    $profit = 0;
    foreach ($mcValue as $oKey => $oValue) {
        // echo "<h3>" . $oKey . "</h3>";
        //echo "<pre>";
        //print_r($mClient->getSalesOrderProfit($oKey));
        //echo "</pre>";
        //die();
        //echo "Winst over de order: " . $mClient->getSalesOrderProfit($oKey);
        $profit += $mClient->getSalesOrderProfit($oKey);
    }
    echo "Dit is die doekoe toch: " . $profit;
}


?>