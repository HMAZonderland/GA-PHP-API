<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dylan
 * Date: 1-5-13
 * Time: 13:24
 * To change this template use File | Settings | File Templates.
 */

// Google Console Credentials
define('ACCESS_TYPE', 'online');
define('APPLICATION_NAME', 'esser-emerik rendements berekening API');
define('CLIENT_ID', '211121854101.apps.googleusercontent.com');
define('CLIENT_SECRET', 'UWMHZxqbyYvbzFrVqSK_45to');
define('REDIRECT_URI', 'http://' . $_SERVER["HTTP_HOST"] . $_SERVER['PHP_SELF']);
define('DEVELOPER_KEY', 'AIzaSyAYWJ-TCPgMkE101Jy2OLZXkmyP1-cCsBE');

// Magento API settings
define('API_USER', 'Hugo');
define('API_KEY', 'Ka0yoiAOJhoifqap0oinhlkqfn0oe8vh0234gtQ965WGEWROIUHJWEROIGNRESD98OHL234TWP98YWERFGNLKAERGO87HKJN234TPHJKZWGRHLI');
define('API_HOST', 'http://magento.presteren.nu/api/soap/?wsdl');
?>