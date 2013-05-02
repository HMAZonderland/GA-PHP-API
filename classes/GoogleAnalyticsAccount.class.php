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
	public function __constructor($accountId) {
		$this->_accountId = $accountId;
	}
	
	/*
	 * Sets the accountId
	 */
	public function setAccountId($accountId) {
		$this->_accountId = $accountId;
	}
	
	/*
	 * Gets acountId
	 */
	public function getAccountId() {
		return $this->_accountId;
	}
	
	/*
	 * Sets name
	 */
	public function setName($name) {
		$this->_name = $name;	
	}
	
	/*
	 * Sets name
	 */
	public function getName() {
		return $this->_name;	
	}
	
	/*
	 * Sets Properties
	 */
	public function setProperties(array $properties) {
		$this->_properties = $properties;	
	}
	
	
	/*
	 * Gets Properties
	 */
	public function getProperties() {
		return $this->_properties;	
	}
	
	/*
	 * Adds Property object to array
	 */
	public function addProperty(Property $webproperty) {
		$this->_properties[''.$webproperty->getWebPropertyId().''] = $webproperty;	
	}
}
?>