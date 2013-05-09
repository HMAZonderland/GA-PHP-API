<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 08-05-13
 * Time: 17:46
 * To change this template use File | Settings | File Templates.
 */

// Account selector
$GoogleAnalyticsAccountSelector = new GoogleAnalyticsAccountSelector($service);

if ((isset($_GET['propertyId']) && !empty($_GET['propertyId'])) && (isset($_GET['accountId']) && !empty($_GET['accountId'])) && (isset($_GET['profileId']) && !empty($_GET['profileId']))) {
    // Parse the $_GET vars
    $propertyId = $_GET['propertyId'];
    $accountId = $_GET['accountId'];
    $profileId = $_GET['profileId'];

    // Gets the list of profiles attached to the account
    $GoogleAnalyticsAccountList = $GoogleAnalyticsAccountSelector->listProfiles($propertyId, $accountId);

    // Since we have a propertyId and accountId we know that there is only 1 account, so we can take the first object
    // from the array and use it as object.
    $GoogleAnalyticsAccount = $GoogleAnalyticsAccountList[key($GoogleAnalyticsAccountList)];
} else {
    // Accounts listen
    $GoogleAnalyticsAccountSelector->listAllProfiles();

    if ($GoogleAnalyticsAccountSelector->hasGoogleAnalyticsAccounts()) {
        echo "Selecteer een account, property en profile: <br />";
        foreach ($GoogleAnalyticsAccountSelector->getGoogleAnalyticsAccounts() as $account) {
            $properties = $account->getProperties();
            foreach ($properties as $property) {
                $profiles = $property->getProfiles();
                foreach ($profiles as $profile) {
                    echo "- <a href=\"index.php?accountId=" . $account->getAccountId() . "&profileId=" . $profile->getProfileId() . "&propertyId=" . $property->getWebPropertyId() . "\">" . $profile->getName() . "</a><br />";
                }
            }
        }
    } else {
        echo "Geen accounts gevonden. Maak eerst een Google Analytics Account aan.";
    }
}

