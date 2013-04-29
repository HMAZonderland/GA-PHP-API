<?php
session_start();

error_reporting(-1);

require_once dirname(__FILE__).'/GoogleClientLib/Google_Client.php';
require_once dirname(__FILE__).'/GoogleClientLib/contrib/Google_AnalyticsService.php';
require_once dirname(__FILE__).'/classes/GoogleAnalyticsAccount.class.php';
require_once dirname(__FILE__).'/classes/Profile.class.php';
require_once dirname(__FILE__).'/classes/Property.class.php';

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();
$client->setAccessType('online'); // default: offline
$client->setApplicationName('esser-emerik rendements berekening API');
$client->setClientId('211121854101.apps.googleusercontent.com');
$client->setClientSecret('UWMHZxqbyYvbzFrVqSK_45to');
$client->setRedirectUri($scriptUri);
$client->setDeveloperKey('AIzaSyAYWJ-TCPgMkE101Jy2OLZXkmyP1-cCsBE'); // API key

// $service implements the client interface, has to be set before auth cal	  
$service = new Google_AnalyticsService($client);
$GoogleAccount;

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
    header("Location: ".$authUrl);
    die;
}

// Stap 1, account kiezen.


// Stap 2, property kiezen.
echo "Shoarma rol";

// Stap 3, profiel kiezen.


function ListAccounts($service)
{
	$list = listManagementProfiles($service, "~all", "~all");	
	
	if (sizeof($list['items']) > 0) {
		
		$accounts = array();
		
		foreach ($list['items'] as $item) {	
	
			echo "<pre>";
			print_r($item);
			echo "</pre>";
		
			// GoogleAnalyticsAccount
			$accountId = $item['accountId'];
			//$googleanalayticsaccountName = $profile['http://magento.presteren.nu'];
			
			// Property
			$propertyName = $item['websiteUrl'];
			$webPropertyId = $item['webPropertyId'];
			
			// Profile
			$profileId = $item['id'];
			$profileName = $item['name'];
			
			// Profile always gets created
			$profile = new Profile();
			$profile->setProfileId($profileId);
			$profile->setName($profileName);
			
			// If the account doesn't exists, create it and add the property and the profile right away
			if (!array_key_exists($accountId, $accounts)) {
				
				$property = new Property();
				$property->setWebPropertyId($webPropertyId);
				$property->setName($propertyName);
				$property->addProfile($profile);
				
				$GoogleAnalyticsAccount = new GoogleAnalyticsAccount();
				$GoogleAnalyticsAccount->setAccountId($accountId);
				$GoogleAnalyticsAccount->addProperty($property);
				
				$accounts[''.$accountId.''] = $GoogleAnalyticsAccount;
			}
			// Check if the property excists in the specified account array.
			else if (!array_key_exists($webPropertyId, $accounts[$accountId]->getProperties())) {
				
				echo $webPropertyId . "<br />";
				
				// The property doesn't exists, lets create it and add the profile to it.
				$property = new Property();
				$property->setWebPropertyId($webPropertyId);
				$property->setName($propertyName);
				$property->addProfile($profile);
				
				// And add it to the Google Analytics account.
				$accounts[$accountId]->addProperty($property);
				
			} else {
				
				echo $profileId . "<br />";
				
				// Property exists, lets add the profile to it
				$properties = $accounts[$accountId]->getProperties();
				$property = $properties[$webPropertyId];
				$property->addProfile($profile);
				//$properties[$webPropertyId]->addProfile($profile);
			}
		}
		
		echo "<pre>";
		print_r($accounts);
		echo "</pre>";
		
		die();
		
		echo "selecteer een WebProperty<br />";
		foreach ($webproperties as $GoogleAccount)
		{
			echo "- <a href=\"index.php?webPropertyId=".$GoogleAccount->getWebPropertyId()."&accountId=".$GoogleAccount->getAccountId()."\">".$GoogleAccount->getUrl()."</a><br />";
		}
	}
	else
	{
		echo "Geen accounts gevonden. Maak eerst een Google Analytics Account aan.";	
	}
}

function getWebPropertyProfiles($service, $webPropertyId, $accountId)
{
	$profiles = listManagementProfiles($service, $webPropertyId, $accountId);
	
	/*echo "<pre>";
	print_r($profiles);
	echo "</pre>";*/
	
	$GA = new GoogleAccount($webPropertyId);
	
	foreach ($profiles['items'] as $profile)
	{	
		$GA->arrayPush($profile['id']);
	}
	
	return $GA;
}

function listManagementProfiles($service, $webPropertyId, $accountId)
{
	return $service->management_profiles->listManagementProfiles($accountId, $webPropertyId);
}

if ((isset($_GET['webPropertyId']) && !empty($_GET['webPropertyId'])) && (isset($_GET['accountId']) && !empty($_GET['accountId'])))
{
	$webPropertyId = $_GET['webPropertyId'];
	$accountId = $_GET['accountId'];
	$GoogleAccount = getWebPropertyProfiles($service, $webPropertyId, $accountId);	
}
else
{
	ListAccounts($service);
}

if (isset($GoogleAccount) && $GoogleAccount->sizeof() > 0)
{ 

	$results = array();
	$set = array();

	$profiles = $GoogleAccount->getProfiles();
	foreach ($profiles as $projectId)
	{
		echo "==============================[ ".$projectId." ]==============================";
		// Benamingen
		// metrics
		$_params[] = 'Bron';
		$_params[] = 'Medium';
		$_params[] = 'bezoekers';
		$_params[] = 'opbrengst per transactie';
		// dimensions
		$_params[] = 'transacties';
		$_params[] = 'unieke aankopen';
		
		// Tijd filter
		$from = date('Y-m-d', time()-2*24*60*60); // 20 days
		$to = date('Y-m-d'); // today
		
		// metrics + dimensions uit de documentenatie :
		// https://developers.google.com/analytics/devguides/reporting/core/dimsmets
		$dimensions = 'ga:source,ga:medium';
		$metrics = 'ga:visits,ga:transactionRevenue,ga:transactions,ga:uniquePurchases';
		
		// Ophalen
		$data = $service->data_ga->get('ga:'.$projectId, $from, $to, $metrics, array('dimensions' => $dimensions));
		
		if (sizeof($data['rows']) > 0) {
			foreach($data['rows'] as $row) {
				$set[''.$row[0].'']['medium'] = $row[1];
				$set[''.$row[0].'']['visits'] = $row[2];
				$set[''.$row[0].'']['transactionRevenue'] = $row[3];
				$set[''.$row[0].'']['transactions'] = $row[4];
				$set[''.$row[0].'']['uniquePurchases'] = $row[5];	
				array_push($results, $set[''.$row[0].'']);
			}
			$set['totalsForAllResults']['medium'] = "totals";
			$set['totalsForAllResults']['visits'] = $data['totalsForAllResults']['ga:visits'];
			$set['totalsForAllResults']['transactionRevenue'] = $data['totalsForAllResults']['ga:transactionRevenue'];
			$set['totalsForAllResults']['transactions'] = $data['totalsForAllResults']['ga:transactions'];
			$set['totalsForAllResults']['uniquePurchases'] = $data['totalsForAllResults']['ga:uniquePurchases'];
			array_push($results, $set['totalsForAllResults']);
		} 
		
		echo "<pre>";
		print_r($results);
		echo "</pre>";
		
		/*echo "<br />==============================[ DEBUG ]==============================";
		echo "<pre>";
		print_r($data);
		echo "</pre>";*/
	}
}