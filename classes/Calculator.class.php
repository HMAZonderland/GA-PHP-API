<?php
class Calculator
{	
	private $_costs;
	private $_revenue;
	
	private $_ratio;
	
	/*
	 * Gets the costs
	 */
	public function getCosts()
	{
		return $this->_costs;
	}
	
	/*
	 * Sets the costs
	 */
	function setCosts($costs)
	{
		$this->_costs = $costs;	
	}
	
	
	/*
	 * Gets the revenue
	 */
	function getRevenue()
	{
		return $this->_revenue;	
	}
	
	/*
	 * Sets the revenue
	 */
	function setRevenue($revenue)
	{
		$this->_revenue = $revenue;	
	}
	
	/*
	 * Gets the ratio
	 */
	function getRatio()
	{
		return $this->_ratio;	
	}
	
	/*
	 * Gets the ratio
	 */
	function getRatioReadable()
	{
		return round($this->_ratio * 100, 2);
	}
	
	/*
	 * Sets the ratio
	 */
	function setRatio($ratio)
	{
		$this->_ratio = $ratio;	
	}
	
	/*
	 * Calculate the ratio of the costs
	 */
	function calculateCostsRatio()
	{
		return $this->_costs * $this->_ratio;	
	}
	
	/*
	 * Calculate the ratio of the costs and returns its readable for humans
	 */
	function calculateCostsRatioReadable()
	{
		return round($this->calculateCostsRatio(), 2);
	}
	
	/*
	 * Calculates the ratio of the the revenue
	 */
	function calculateRevenueRatio()
	{
		return $this->_revenue * $this->_ratio;
	}
	
	/*
	 * Calculates the ratio of the the revenue readable for humums
	 */
	function calculateRevenueRatioReadable()
	{
		return round($this->calculateRevenueRatio(), 2);
	}
	
	/*
	 * Calulates profit based upon revenue and costs
	 */
	function calculateProfit()
	{
		return $this->_revenue - $this->_costs;	
	}
	
	/*
	 * Calulates profit based upon ratio, revenue and costs
	 */
	function calculateRatioProfit()
	{
		return $this->calculateProfit() * $this->_ratio;	
	}

	/*
	 * Calulates profit based upon ratio, revenue and costs readable for humans
	 */
	function calculateRatioProfitReadable()
	{
		return round($this->calculateRatioProfit(), 2);
	}
	
	/*
	 * Calulates profit percentage based upon profit and costs
	 */
	function calulateProfitPercentage()
	{
		if ($this->_costs * $this->_ratio > 0)
			return $this->calculateProfit() / ($this->_costs * $this->_ratio);
		else
			return 0;
	}
	
	/*
	 * Calulates profit percentage based upon profit and costs -> human readable version
	 */
	function calulateProfitPercentageReadable()
	{
		$profitpercentage = $this->calulateProfitPercentage();
		if ($profitpercentage == 0)
		{
			return $profitpercentage;
		}
		return round($profitpercentage * 100, 2);
	}
}
?>