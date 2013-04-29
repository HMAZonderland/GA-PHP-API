<?php
/*
 * abstract which is used for metrics parser, classes inherit these functions
 *
 */
abstract class GoogleAnalyticsMetrics
{
	// Fields
	private $_metrics = string;
	private $_dimensions = string;
	private $_params = array();
	
	/*
	 * Constructor
	 */
	 function __constructor(string $metrics, string $dimensions, array $params)
	 {
		$this->_metrics = $metrics;
		$this->_dimensions = $dimensions;
		$this->_params = $params; 
	 }
	
	/*
	 * Sets metrics
	 */
	function setMetrics(string $metrics)
	{
		$this->_metrics = $metrics;
	}
	
	/*
	 * Returns metrics
	 */
	function getMetrics()
	{
		return $this->_metrics;
	}	
	
	/*
	 * Sets dimensions
	 */
	function setDimensions(string $dimensions)
	{
		$this->_dimensions = $dimensions;
	}
	
	/*
	 * Returns dimensions
	 */
	function getDimensions() 
	{
		return $this->_dimensions;
	}
	
	/*
	 * Sets params
	 */
	function setParams(array $params)
	{
		$this->_params = $params;	
	}
	
	/*
	 * Returns params
	 */
	function getParams()
	{
		return $this->_params;	
	}
	
	/*
	 *
	 */
}
?>