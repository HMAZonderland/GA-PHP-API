<?php
/*
 * describes an Google Analytics Account
 */
class GoogleAnalyticsAccount {
	
	private $_accountId;
	private $_name;
	private $_properties = array();

	/*
	 * Default constructor
	 */
	function __constructor($accountId) {
		$this->_accountId = $accountId;
	}
	
	/*
	 * Sets the accountId
	 */
	function setAccountId($accountId) {
		$this->_accountId = $accountId;
	}
	
	/*
	 * Gets acountId
	 */
	function getAccountId() {
		return $this->_accountId;
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
	 * Sets Properties
	 */
	function setProperties(array $properties) {
		$this->_properties = $properties;	
	}
	
	
	/*
	 * Gets Properties
	 */
	function getProperties() {
		return $this->_properties;	
	}
	
	/*
	 * Adds Property object to array
	 */
	function addProperty(Property $webproperty) {
		$this->_properties[''.$webproperty->getWebPropertyId().''] = $webproperty;	
	}
}
?>