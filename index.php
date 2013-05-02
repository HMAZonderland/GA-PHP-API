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
require_once dirname(__FILE__).'/classes/GoogleAnalyticsAccountSelector.php';
require_once dirname(__FILE__).'/classes/ExcelReader.php';

$scriptUri = "http://".$_SERVER["HTTP_HOST"].$_SERVER['PHP_SELF'];

$client = new Google_Client();											// GoogleClient init
$client->setAccessType('online');										// default: offline
$client->setApplicationName('esser-emerik rendements berekening API'); 	// Title
$client->setClientId('211121854101.apps.googleusercontent.com');		// ClientId
$client->setClientSecret('UWMHZxqbyYvbzFrVqSK_45to');					// ClientSecret
$client->setRedirectUri($scriptUri);									// Where to redirect to after authentication 
$client->setDeveloperKey('AIzaSyAYWJ-TCPgMkE101Jy2OLZXkmyP1-cCsBE'); 	// Developer key

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
    header("Location: ".$authUrl);
    die;
}

$GoogleAnalyticsAccountSelector = new GoogleAnalyticsAccountSelector($service);

if ((isset($_GET['propertyId']) && !empty($_GET['propertyId'])) && (isset($_GET['accountId']) && !empty($_GET['accountId'])) && (isset($_GET['profileId']) && !empty($_GET['profileId'])))
{
	// Parse the $_GET vars
	$propertyId = $_GET['propertyId'];
	$accountId = $_GET['accountId'];
	$profileId = $_GET['profileId'];
	
	// Gets the list of profiles attached to the account
	$GoogleAnalyticsAccountList = $GoogleAnalyticsAccountSelector->listProfiles($propertyId, $accountId);
	
	// Since we have a propertyId and accountId we know that there is only 1 account, so we can take the first object
	// from the array and use it as object.
	$GoogleAnalyticsAccount = $GoogleAnalyticsAccountList[key($GoogleAnalyticsAccountList)];
		
	/*echo "<pre>";
	print_r($GoogleAnalyticsAccount);
	echo "</pre>";*/
}
else
{
	// Accounts listen
	$GoogleAnalyticsAccountSelector->listAllProfiles();
	
	if ($GoogleAnalyticsAccountSelector->hasGoogleAnalyticsAccounts())
	{
		echo "Selecteer een account, property en profile: <br />";
				
		foreach ($GoogleAnalyticsAccountSelector->getGoogleAnalyticsAccounts() as $account)
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
	
	$kosten = 5000; // per maand
	
	$calc = new Calculator();
	$calc->setCosts($kosten);
	
	$TransactionRevenueMetrics = new TransactionRevenueMetrics($service, $_GET['profileId'], $from, $to);
	foreach ($TransactionRevenueMetrics->getRevenuePerSource() as $source)
	{
		$calc->setRevenue($TransactionRevenueMetrics->getTotalRevenue());
		$calc->setRatio($source['transactionRevenue'] / $TransactionRevenueMetrics->getTotalRevenue());

		if ($source['source'] == "beslist.nl")
		{
			$calc->setSpecificCosts(125); // Clickcosts
		}
		
		if ($source['source'] == "kieskeurig.nl")
		{
			$calc->setSpecificCosts(250); // Clickcosts
		}

		if ($source['source'] != "(direct)")
		{
			echo "<h1>" . $source['source'] . "</h1>";
			echo "Totale omzet = &euro;" . $calc->getRevenue() . "<br />";
			echo "Omzet " . $source['source'] . " = &euro; " . $source['transactionRevenue'] . "<br />";
			echo $source['transactionRevenue'] . " / " .$TransactionRevenueMetrics->getTotalRevenue() . " = " . $source['transactionRevenue'] / $TransactionRevenueMetrics->getTotalRevenue() . "%<br />";
			
			echo "Percentage = " . $calc->getRatioReadable() . "%<br /><br />";
			
			echo "Kosten = &euro;" . $calc->getCosts();
			echo "Kosten " . $source['source'] . " = &euro;" . $calc->calculateCostsRatioReadable() . " <br />";
			
			echo "Winst (omzet - (vaste) kosten): &euro;" .  $calc->calculateRatioProfitReadable() . "<br />";
			echo "Rendement zonder specifieke kosten: " . $calc->calulateProfitPercentageReadable() . "%<br /><br />";
			
			echo "Specifieke kosten = &euro;" . $calc->getSpecificCosts() . "<br />";
			echo "Winst (omzet - ((vaste) kosten + specifiekekosten): &euro;" .  $calc->calculateRatioSpecificProfitReadable(). "<br />";
			echo "Rendement met specifieke kosten: " . $calc->calulateProfitSpecificPercentageReadable() . "&";
		}
	}
}