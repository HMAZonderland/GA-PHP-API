<?php
/**
 * Class Calculator
 */
class Calculator
{

    /**
     * containing general costs (rent, ensurance etc)
     * @var float
     */
    private $_costs;

    /**
     * containing spefic costs (clicks)
     * @var float
     */
    private $_specificCosts;

    /**
     * containing revenue
     * @var float
     */
    private $_revenue;

    /**
     * containing channel ratio
     * @var float
     */
    private $_ratio;

    /**
     * Gets the costs
     * @return mixed
     */
    public function getCosts()
    {
        return $this->_costs;
    }

    /**
     * Sets the costs
     * @param $costs
     */
    public function setCosts($costs)
    {
        $this->_costs = $costs;
    }

    /**
     * Gets the specific
     * @return mixed
     */
    public function getSpecificCosts()
    {
        return $this->_specificCosts;
    }

    /**
     * Sets the costs
     * @param $specificCosts
     */
    public function setSpecificCosts($specificCosts)
    {
        $this->_specificCosts = $specificCosts;
    }

    /**
     * Gets the revenue
     * @return mixed
     */
    public function getRevenue()
    {
        return $this->_revenue;
    }

    /**
     * Sets the revenue
     * @param $revenue
     */
    public function setRevenue($revenue)
    {
        $this->_revenue = $revenue;
    }

    /**
     * Gets the ratio
     * @return mixed
     */
    public function getRatio()
    {
        return $this->_ratio;
    }

    /**
     * Sets the ratio
     * @param $ratio
     */
    public function setRatio($ratio)
    {
        $this->_ratio = $ratio;
    }


    /**
     * Returns ratio in a human readable format
     * @return float
     */
    public function getRatioReadable()
    {
        return round($this->_ratio * 100, 2);
    }

    /**
     * Returns calculateCostsRatio() function in readable format
     * @return float
     */
    public function calculateCostsRatioReadable()
    {
        return round($this->calculateCostsRatio(), 2);
    }

    /**
     * Calculate costs based upon ratio
     * @return mixed
     */
    public function calculateCostsRatio()
    {
        echo "</br >" . $this->_costs . " * " . $this->_ratio . " = " . $this->_costs * $this->_ratio . "</br >";
        return $this->_costs * $this->_ratio;
    }

    /**
     * Returns calculateRevenueRatio function in readable format
     * @return float
     */
    public function calculateRevenueRatioReadable()
    {
        return round($this->calculateRevenueRatio(), 2);
    }

    /**
     * Calculates the ratio of the the revenue
     * @return mixed
     */
    public function calculateRevenueRatio()
    {
        echo "</br >" . $this->_revenue . " * " . $this->_ratio . " = " . $this->_revenue * $this->_ratio . " </br >";
        return $this->_revenue * $this->_ratio;
    }

    /**
     * Calulates profit based upon revenue and costs
     * @return mixed
     */
    public function calculateProfit()
    {
        echo "</br >" . $this->_revenue . " - " . $this->_costs . " = " . $this->_revenue - $this->_costs . " </br >";
        return $this->_revenue - $this->_costs;
    }

    /**
     * Return calculateProfit() function in readable format
     * @return float
     */
    public function calculateRatioProfitReadable()
    {
        return round($this->calculateRatioProfit(), 2);
    }

    /**
     * Calculates profit based upon ratio, revenue and costs
     * @return mixed
     */
    public function calculateRatioProfit()
    {
        echo "</br >(" . $this->_revenue . " - " . $this->_costs . ") * " . $this->_ratio . " = " . ($this->_revenue - $this->_costs) * $this->_ratio . " </br >";
        return ($this->_revenue - $this->_costs) * $this->_ratio;
    }

    /**
     * Returns calculateRatioProfit() function in readable format
     * @return float
     */
    public function calculateRatioSpecificProfitReadable()
    {
        return round($this->calculateRatioProfitSpecific(), 2);
    }

    /**
     * Calulates profit based upon ratio, revenue, costs and specific costs
     * @return mixed
     */
    public function calculateRatioProfitSpecific()
    {
        echo "</br >(" . $this->_revenue . " - (" . $this->_costs . " + " . $this->_specificCosts . ")) * " . $this->_ratio . " = " . ($this->_revenue - ($this->_costs + $this->_specificCosts)) * $this->_ratio . " </br >";
        return ($this->_revenue - ($this->_costs + $this->_specificCosts)) * $this->_ratio;
    }

    /**
     * Returns calculateRatioProfitSpecific() function in readable format
     * @return float|int
     */
    public function calculateProfitPercentageReadable()
    {
        $profitpercentage = $this->calculateProfitPercentage();
        if ($profitpercentage == 0) {
            return $profitpercentage;
        }
        return round($profitpercentage * 100, 2);
    }

    /**
     * Calculates profit percentage based upon profit and costs
     * @return float|int
     */
    public function calculateProfitPercentage()
    {
        if ($this->_ratio > 0) {
            echo "</br >(" . (($this->_revenue - $this->_costs) * $this->_ratio) . ") / " . ($this->_revenue * $this->_ratio) . " = " . ((($this->_revenue - $this->_costs) * $this->_ratio)) / ($this->_revenue * $this->_ratio) . "<br />";
            return ((($this->_revenue - $this->_costs) * $this->_ratio)) / ($this->_revenue * $this->_ratio);
        } else {
            return 0;
        }
    }

    /**
     * Retuns calculateProfitPercentage() function in readable format
     * @return float|int
     */
    public function calculateProfitSpecificPercentageReadable()
    {
        $profitpercentage = $this->calculateProfitSpecificPercentage();
        if ($profitpercentage == 0) {
            return $profitpercentage;
        }
        return round($profitpercentage * 100, 2);
    }

    /**
     * Calculates profit percentage based upon profit, costs and specific costs
     * @return float|int
     */
    public function calculateProfitSpecificPercentage()
    {
        if ($this->_ratio > 0) {
            echo "</br >(" . (($this->_revenue - $this->_costs) * $this->_ratio) . " - " . $this->_specificCosts . ") / " . ($this->_revenue * $this->_ratio) . " = " . ((($this->_revenue - $this->_costs) * $this->_ratio) - $this->_specificCosts) / ($this->_revenue * $this->_ratio) . "<br />";
            return ((($this->_revenue - $this->_costs) * $this->_ratio) - $this->_specificCosts) / ($this->_revenue * $this->_ratio);
        } else {
            return 0;
        }
    }
}

?>