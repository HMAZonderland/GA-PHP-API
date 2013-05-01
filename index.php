<?php
session_start();

error_reporting(-1);

require_once dirname(__FILE__).'/GoogleClientLib/Google_Client.php';
require_once dirname(__FILE__).'/GoogleClientLib/contrib/Google_AnalyticsService.php';
require_once dirname(__FILE__).'/classes/GoogleAnalyticsAccount.class.php';
require_once dirname(__FILE__).'/classes/GoogleAnalyticsMetricsParser.php';
require_once dirname(__FILE__).'/GoogleAnalyticsMetrics/TransactionRevenueMetrics.php';
require_once dirname(__FILE__).'/classes/Profile.class.php';
require_once dirname(__FILE__).'/classes/Property.class.php';
require_once dirname(__FILE__).'/classes/Calculator.class.php';

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
$GoogleAnalyticsAccount = null;

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

// Stap 3, profiel kiezen.

function listManagementProfiles($service, $propertyId, $accountId)
{
	//echo "VARS: " . $propertyId . " " . $accountId;
	return $service->management_profiles->listManagementProfiles($accountId, $propertyId);
}

function ListAccounts($service, $propertyId, $accountId)
{
	$list = listManagementProfiles($service, $propertyId, $accountId);	
	
	/*echo "<pre>";
	print_r($list);
	echo "</pre>";*/
	
	$accounts = array();
	
	if (sizeof($list['items']) > 0) {
		
		foreach ($list['items'] as $item) {	
	
			/*echo "<pre>";
			print_r($item);
			echo "</pre>";*/
		
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
				
				//echo $webPropertyId . "<br />";
				
				// The property doesn't exists, lets create it and add the profile to it.
				$property = new Property();
				$property->setWebPropertyId($webPropertyId);
				$property->setName($propertyName);
				$property->addProfile($profile);
				
				// And add it to the Google Analytics account.
				$accounts[$accountId]->addProperty($property);
				
			} else {
				
				//echo $profileId . "<br />";
				
				// Property exists, lets add the profile to it
				$properties = $accounts[$accountId]->getProperties();
				$property = $properties[$webPropertyId];
				$property->addProfile($profile);
				//$properties[$webPropertyId]->addProfile($profile);
			}
		}
		
		/*echo "<pre>";
		print_r($accounts);
		echo "</pre>";*/
	}
	return $accounts;
}

if ((isset($_GET['propertyId']) && !empty($_GET['propertyId'])) && (isset($_GET['accountId']) && !empty($_GET['accountId'])) && (isset($_GET['profileId']) && !empty($_GET['profileId'])))
{
	$propertyId = $_GET['propertyId'];
	$accountId = $_GET['accountId'];
	$profileId = $_GET['profileId'];
	
	$GoogleAnalyticsAccountList = ListAccounts($service, $propertyId, $accountId);
	reset($GoogleAnalyticsAccountList);
	
	$GoogleAnalyticsAccount = $GoogleAnalyticsAccountList[key($GoogleAnalyticsAccountList)];
		
	/*echo "<pre>";
	print_r($GoogleAnalyticsAccount);
	echo "</pre>";*/
}
else
{
	$accounts = ListAccounts($service, "~all", "~all");
	
	if (sizeof($accounts) > 0)
	{
		echo "Selecteer een account, property en profile: <br />";
				
		foreach ($accounts as $account)
		{
			$properties = $account->getProperties();
			
			/*echo "<pre>";
			print_r($properties);
			echo "</pre>";*/
			
			foreach ($properties as $property)
			{
				$profiles = $property->getProfiles();
			
				/*echo "<pre>";
				print_r($profiles);
				echo "</pre>";*/
				
				foreach ($profiles as $profile)
				{
					echo "- <a href=\"index.php?accountId=".$account->getAccountId()."&profileId=".$profile->getProfileId()."&propertyId=".$property->getWebPropertyId()."\">".$profile->getName()."</a><br />";
				}
			}
		}
	}
	else
	{
		echo "Geen accounts gevonden. Maak eerst een Google Analytics Account aan.";	
	}
}

if ((isset($GoogleAnalyticsAccount)) && (sizeof($GoogleAnalyticsAccount->getProperties() > 0)) && $GoogleAnalyticsAccount != null)
{ 
	// Tijd filter
	$from = date('Y-m-d', time()-30*24*60*60); // 30 days
	$to = date('Y-m-d'); // today
	
	$kosten = 14000; // per maand
	
	$calc = new Calculator();
	$calc->setCosts($kosten);
	
	$TransactionRevenueMetrics = new TransactionRevenueMetrics($service, $_GET['profileId'], $from, $to);
	foreach ($TransactionRevenueMetrics->getRevenuePerSource() as $source)
	{
		$calc->setRevenue($TransactionRevenueMetrics->getTotalRevenue());
		$calc->setRatio($source['transactionRevenue'] / $TransactionRevenueMetrics->getTotalRevenue());
		
		echo "<h1>" . $source['source'] . "</h1>";
		echo "Percentage = " . $calc->getRatioReadable() . "%<br />";
		echo "Omzet verdeling = &euro;" . $calc->calculateRevenueRatioReadable() . " | &euro;" . $calc->getRevenue() . "<br />";
		echo "Kosten verdeling = &euro;" . $calc->calculateCostsRatioReadable() . " | 	&euro;" . $calc->getCosts() . "<br />";
		echo "Winst: &euro;" .  $calc->calculateRatioProfitReadable() . "<br />";
		echo "Rendement: " . $calc->calulateProfitPercentageReadable() . "%<br />";
		echo "<br />";
	}
}