<?php

class Property {
	
	private $_webPropertyId;
	private $_name;
	private $_profiles = array();
	
	/*
	 * Sets webPropertyId
	 */
	function setWebPropertyId($webPropertyId) {
		$this->_webPropertyId = $webPropertyId;
	}
	
	/*
	 * Gets WebpropertyId
	 */
	function getWebPropertyId() {
		return $this->_webPropertyId;
	}
	
	/*
	 * Sets name
	 */
	function setName($name) {
		$this->_name = $name;	
	}
	
	/*
	 * Sets name
	 */
	function getName() {
		return $this->_name;	
	}
	
	/*
	 * Sets profiles
	 */
	function setProfiles(array $profiles) {
		$this->_profiles = $profiles;	
	}
	
	/*
	 * Gets profiles
	 */
	function getProfiles() {
		return $this->_profiles;	
	}
	
	/*
	 * Adds a profile
	 */
	function addProfile(Profile $profile) {
		$this->_profiles[''.$profile->getProfileId().''] = $profile;
	}
}

?>