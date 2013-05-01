<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dylan
 * Date: 1-5-13
 * Time: 13:24
 * To change this template use File | Settings | File Templates.
 */

// TODO change to false before committing
define("DEBUG", false);

if(DEBUG === true) {
    $oauthClientId = '1004798276934-9ftpna6pkk2ugai7kjs02jstvlkorsh8.apps.googleusercontent.com';
    $oauthClientSecret = 'mhiyTXd7x71Q0vFJF37pNWOE';
    $oathRedirectURI = 'http://localhost:8080/analytics/oauth2callback';
    $devKey = 'AIzaSyAh6S1L0znVsFXJxkhBM2OWb8gBMHnSDHs';
    $siteName = 'localhost:8080/analytics/oauth2callback';
} else {
    $oauthClientId = '211121854101.apps.googleusercontent.com';
    $oauthClientSecret = 'UWMHZxqbyYvbzFrVqSK_45to';
    $oathRedirectURI = 'http://esser-emmerik.hugozonderland.nl/oauth2callback';
    $devKey = 'AIzaSyAYWJ-TCPgMkE101Jy2OLZXkmyP1-cCsBE';
    $siteName = 'esser-emmerik.hugozonderland.nl';
}