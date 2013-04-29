<?php
require_once("GoogleAnalyticsMetrics.php");

class ReferringSites extends GoogleAnalyticsMetrics
{
	function __constructor() 
	{
		// Dimension
		$dimensions = "ga:source";
		
		// Metrics
		$metrics = "ga:pageviews,ga:timeOnSite,ga:exits";
		
		// eerst dimensions daarna metrics
		$params[] = "Bron";
	}
}
?>