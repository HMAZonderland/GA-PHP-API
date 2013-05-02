<?php
class TransactionRevenueMetrics extends GoogleAnalyticsMetricsParser
{
	private $_totalRevenue;
	private $_revenuePerSource = array();
	
	function __construct($service, $profileId, $from, $to)
	{
		// dimensions
		$dimensions = 'ga:source,ga:medium';
		$this->_params[] = 'source';
		$this->_params[] = 'medium';
		
		// metrics
		$metrics = 'ga:visits,ga:transactionRevenue,ga:transactions,ga:uniquePurchases';
		$this->_params[] = 'visits';
		$this->_params[] = 'transactionRevenue';
		$this->_params[] = 'transactions';
		$this->_params[] = 'uniquePurchases';
		
		parent::__construct($metrics, $dimensions, $service, $profileId, $from, $to);	
		$this->parse();
	}	
	
	function parse()
	{
		parent::parse();
		
		$this->_totalRevenue = $this->_data['totalsForAllResults']['ga:transactionRevenue'];
		$this->_revenuePerSource = $this->_results;
		
		/*echo "<pre>";
		print_r($this->_data);
		echo "</pre>";*/
	}
	
	function getTotalRevenue()
	{
		return $this->_totalRevenue;	
	}
	
	function getRevenuePerSource()
	{
		return $this->_revenuePerSource;	
	}
}
?>