<?php
/*
 * Gets all the GoogleAnalytics accounts, properties en profiles linked to the Google account
 */
class GoogleAnalyticsAccountSelector
{
	private $_service;
	private $_GoogleAnalyticsAccoounts = array();
		
	/*
	 * Constructor
	 */
	public function __construct($service)
	{
		$this->_service = $service;
	}
	
	/*
	 * Gets the GoogleAnalyticsAccounts array
	 */
	public function getGoogleAnalyticsAccounts()
	{
		return $this->_GoogleAnalyticsAccoounts;	
	}
	
	/*
	 * Detirmens if there are GoogleAnalyticsAccounts
	 */
	public function hasGoogleAnalyticsAccounts()
	{
		return (sizeof($this->getGoogleAnalyticsAccounts()) > 0);
	}
	
	/*
	 * Returns a list of profiles attached to an account/property
	 * When used ~all, ~all this will return a list with all profiles/accounts/proprties available to the Google account
	 */
	private function listManagementProfiles($propertyId, $accountId)
	{
		//echo "VARS: " . $propertyId . " " . $accountId;
		return $this->_service->management_profiles->listManagementProfiles($accountId, $propertyId);
	}

	/*
	 * Lists the profiles linked to an account/property
	 */
	public function listProfiles($propertyId, $accountId)
	{
		$list = $this->listManagementProfiles($propertyId, $accountId);	
		
		/*echo "<pre>";
		print_r($list);
		echo "</pre>";*/
		
		$this->_GoogleAnalyticsAccoounts = array();
		
		if (sizeof($list['items']) > 0) {
			
			foreach ($list['items'] as $item) {	
		
				/*echo "<pre>";
				print_r($item);
				echo "</pre>";*/
			
				// GoogleAnalyticsAccount
				$accountId = $item['accountId'];
				
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
				if (!array_key_exists($accountId, $this->_GoogleAnalyticsAccoounts)) {
					
					$property = new Property();
					$property->setWebPropertyId($webPropertyId);
					$property->setName($propertyName);
					$property->addProfile($profile);
					
					$GoogleAnalyticsAccount = new GoogleAnalyticsAccount();
					$GoogleAnalyticsAccount->setAccountId($accountId);
					$GoogleAnalyticsAccount->addProperty($property);
					
					$this->_GoogleAnalyticsAccoounts[''.$accountId.''] = $GoogleAnalyticsAccount;
				}
				// Check if the property excists in the specified account array.
				else if (!array_key_exists($webPropertyId, $this->_GoogleAnalyticsAccoounts[$accountId]->getProperties())) {
					
					// The property doesn't exists, lets create it and add the profile to it.
					$property = new Property();
					$property->setWebPropertyId($webPropertyId);
					$property->setName($propertyName);
					$property->addProfile($profile);
					
					// And add it to the Google Analytics account.
					$this->_GoogleAnalyticsAccoounts[$accountId]->addProperty($property);
					
				} else {
					
					// Property exists, lets add the profile to it
					$properties = $this->_GoogleAnalyticsAccoounts[$accountId]->getProperties();
					$property = $properties[$webPropertyId];
					$property->addProfile($profile);
				}
			}
			
			/*echo "<pre>";
			print_r($accounts);
			echo "</pre>";*/
		}
		return $this->_GoogleAnalyticsAccoounts;	
	}
	
	/*
	 *	Lists all the accounts/properties and profiles
	 */
	public function listAllProfiles()
	{
		return $this->listProfiles("~all", "~all");	
	}
}

?>