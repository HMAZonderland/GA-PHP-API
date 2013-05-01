<?php
/*
 * Parses an metric class and returns the fetched data from Google in an array
 */
class GoogleAnalyticsMetricsParser
{
	// Metrics and dimensions can be found here:
	// https://developers.google.com/analytics/devguides/reporting/core/dimsmets
	private $_metrics = array();
	private $_dimensions = array();
			
	// Service
	private $_service = Google_AnalyticsService;
	
	// Google Analytics profile to use
	private $_profileId;
	
	// Dates used as scope, 
	private $_from = date;
	private $_to = date;
	
	/*
	 * Constructor also returns the parse function.
	 * Type hinting used
	 */
	function __construct(array $metrics, array $dimensions, Google_AnalyticsService $service, int $profileId, date $from, date $to) {
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
		return $service->data_ga->get('ga:'.$projectId, $from, $to, $metrics, array('dimensions' => $dimensions));	
	}
}
?>