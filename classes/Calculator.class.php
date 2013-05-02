<?php
class Calculator
{	
	private $_costs;
	private $_specificCosts;
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
	public function setCosts($costs)
	{
		$this->_costs = $costs;	
	}
	
	/*
	 * Gets the specific
	 */
	public function getSpecificCosts()
	{
		return $this->_specificCosts;
	}
	
	/*
	 * Sets the costs
	 */
	public function setSpecificCosts($specificCosts)
	{
		$this->_specificCosts = $specificCosts;	
	}
	
	
	/*
	 * Gets the revenue
	 */
	public function getRevenue()
	{
		return $this->_revenue;	
	}
	
	/*
	 * Sets the revenue
	 */
	public function setRevenue($revenue)
	{
		$this->_revenue = $revenue;	
	}
	
	/*
	 * Gets the ratio
	 */
	public function getRatio()
	{
		return $this->_ratio;	
	}
	
	/*
	 * Gets the ratio
	 */
	public function getRatioReadable()
	{
		return round($this->_ratio * 100, 2);
	}
	
	/*
	 * Sets the ratio
	 */
	public function setRatio($ratio)
	{
		$this->_ratio = $ratio;	
	}
	
	/*
	 * Calculate the ratio of the costs
	 */
	public function calculateCostsRatio()
	{
		echo "</br >" . $this->_costs . " * " . $this->_ratio . " = " . $this->_costs * $this->_ratio . "</br >";
		return $this->_costs * $this->_ratio;	
	}
	
	/*
	 * Calculate the ratio of the costs and returns its readable for humans
	 */
	public function calculateCostsRatioReadable()
	{
		return round($this->calculateCostsRatio(), 2);
	}
	
	/*
	 * Calculates the ratio of the the revenue
	 */
	public function calculateRevenueRatio()
	{
		echo "</br >" . $this->_revenue . " * " . $this->_ratio . " = " . $this->_revenue * $this->_ratio . " </br >";
		return $this->_revenue * $this->_ratio;
	}
	
	/*
	 * Calculates the ratio of the the revenue readable for humums
	 */
	public function calculateRevenueRatioReadable()
	{
		return round($this->calculateRevenueRatio(), 2);
	}
	
	/*
	 * Calulates profit based upon revenue and costs
	 */
	public function calculateProfit()
	{
		echo "</br >" . $this->_revenue . " - " . $this->_costs . " = " . $this->_revenue - $this->_costs . " </br >";
		return $this->_revenue - $this->_costs;
	}
	
	/*
	 * Calulates profit based upon ratio, revenue and costs
	 */
	public function calculateRatioProfit()
	{
		echo "</br >(" . $this->_revenue . " - " . $this->_costs . ") * " . $this->_ratio . " = " . ($this->_revenue - $this->_costs)  * $this->_ratio . " </br >";
		return ($this->_revenue - $this->_costs) * $this->_ratio;	
	}
	
	/*
	 * Calulates profit based upon ratio, revenue and costs
	 */
	public function calculateRatioProfitSpecific()
	{
		echo "</br >(" . $this->_revenue . " - (" . $this->_costs . " + " . $this->_specificCosts . ")) * " . $this->_ratio . " = " . ($this->_revenue - ($this->_costs + $this->_specificCosts))  * $this->_ratio . " </br >";
		return ($this->_revenue - ($this->_costs + $this->_specificCosts)) * $this->_ratio;	
	}


	/*
	 * Calulates profit based upon ratio, revenue and costs readable for humans
	 */
	public function calculateRatioProfitReadable()
	{
		return round($this->calculateRatioProfit(), 2);
	}
	
	/*
	 * Calulates profit based upon ratio, revenue and costs readable for humans
	 */
	public function calculateRatioSpecificProfitReadable()
	{
		return round($this->calculateRatioProfitSpecific(), 2);
	}
	
	/*
	 * Calulates profit percentage based upon profit and costs
	 */
	public function calulateProfitPercentage()
	{
		if ($this->_ratio > 0) 
		{
			echo "</br >(" . (($this->_revenue - $this->_costs) * $this->_ratio) . ") / " . ($this->_revenue * $this->_ratio) . " = " . ((($this->_revenue - $this->_costs) * $this->_ratio)) / ($this->_revenue * $this->_ratio) . "<br />";
			return ((($this->_revenue - $this->_costs) * $this->_ratio)) / ($this->_revenue * $this->_ratio);
		}
		else
		{
			return 0;
		}
	}
	
	/*
	 * Calulates profit percentage based upon profit and costs
	 */
	public function calulateProfitSpecificPercentage()
	{
		if ($this->_ratio > 0) 
		{
			echo "</br >(" . (($this->_revenue - $this->_costs) * $this->_ratio) . " - " . $this->_specificCosts . ") / " . ($this->_revenue * $this->_ratio) . " = " . ((($this->_revenue - $this->_costs) * $this->_ratio) - $this->_specificCosts) / ($this->_revenue * $this->_ratio) . "<br />";
			return ((($this->_revenue - $this->_costs) * $this->_ratio) - $this->_specificCosts) / ($this->_revenue * $this->_ratio);
		}
		else
		{
			return 0;
		}
	}
	
	/*
	 * Calulates profit percentage based upon profit and costs -> human readable version
	 */
	public function calulateProfitPercentageReadable()
	{
		$profitpercentage = $this->calulateProfitPercentage();
		if ($profitpercentage == 0)
		{
			return $profitpercentage;
		}
		return round($profitpercentage * 100, 2);
	}
	/*
	 * Calulates profit percentage based upon profit and costs -> human readable version
	 */
	public function calulateProfitSpecificPercentageReadable()
	{
		$profitpercentage = $this->calulateProfitSpecificPercentage();
		if ($profitpercentage == 0)
		{
			return $profitpercentage;
		}
		return round($profitpercentage * 100, 2);
	}
}
?>