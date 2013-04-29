<?php

class Profile {
	
	private $_profileId;
	private $_name;
	private $_websiteUrl;
	
	/*
	 * Sets profileId
	 */
	function setProfileId($profileId) {
		$this->_profileId = $profileId;
	}
	
	/*
	 * Gets profileId
	 */
	function getProfileId() {
		return $this->_profileId;
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
	 * Sets websiteUrl
	 */
	function setWebsiteUrl($websiteUrl) {
		$this->_websiteUrl = $websiteUrl;	
	}
	
	/*
	 * Gets websiteUrl
	 */
	function getWebsiteUrl() {
		return $this->_websiteUrl;	
	}
}
?>