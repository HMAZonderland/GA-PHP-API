<?php
/*
 * Parses an metric class and returns the fetched data from Google in an array
 */
class GoogleAnalyticsMetricsParser
{
	// Metrics and dimensions can be found here:
	// https://developers.google.com/analytics/devguides/reporting/core/dimsmets
	private $_metrics;
	private $_dimensions;
	
	// only used in child classes
	public $_params = array();
			
	// Service
	private $_service;
	
	// Google Analytics profile to use
	private $_profileId;
	
	// Dates used as scope, 
	private $_from;
	private $_to;
	
	// Results
	public $_data = array();
	public $_results = array();
	
	/*
	 * Constructor also returns the parse function.
	 * Type hinting used
	 */
	function __construct($metrics, $dimensions, $service, $profileId, $from, $to) 
	{
		$this->_metrics = $metrics;
		$this->_dimensions = $dimensions;
		$this->_service = $service;
		$this->_profileId = $profileId;
		$this->_from = $from;
		$this->_to = $to;
	}
	
	/*
	 * Sends out the request to Google Analytics and gets the requested results in an arary
	 */
	function parse() {
		
		$this->_data = $this->_service->data_ga->get('ga:'.$this->_profileId, $this->_from, $this->_to, $this->_metrics, array('dimensions' => $this->_dimensions));
		
		if (isset($this->_data['rows']) && sizeof($this->_data['rows']) > 0) 
		{
			foreach($this->_data['rows'] as $row) 
			{
				$set = array();
				foreach ($row as $key => $value)
				{
					$set[$this->_params[$key]] = $value;		
				}
				array_push($this->_results, $set);
			}	
		}	
	}
}
?>