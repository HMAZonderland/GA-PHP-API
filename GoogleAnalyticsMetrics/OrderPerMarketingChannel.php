<?php
/**
 * Created by JetBrains PhpStorm.
 * User: hugozonderland
 * Date: 05-05-13
 * Time: 17:01
 * To change this template use File | Settings | File Templates.
 */

class OrderPerMarketingChannel extends GoogleAnalyticsMetricsParser
{

    /**
     * Constructor, passes on the service variable to the parser
     * @param Google_AnalyticsService $service
     * @param $profileId
     * @param Google_AnalyticsService $from
     * @param $to
     */
    public function __construct(Google_AnalyticsService $service, $profileId, $from, $to)
    {
        // dimensions
        $dimensions = 'ga:source,ga:transactionId';
        $this->_params[] = 'source';
        $this->_params[] = 'transactionId';

        // metrics
        $metrics = 'ga:transactionRevenue,ga:transactionShipping,ga:transactionTax';
        $this->_params[] = 'transactionRevenue';
        $this->_params[] = 'transactionShipping';
        $this->_params[] = 'transactionTax';

        parent::__construct($metrics, $dimensions, $service, $profileId, $from, $to);
        $this->parse();
    }

    /**
     * Parses the metrics and dimmensions
     */
    public function parse()
    {
        parent::parse();
    }

    /**
     * Sorts the array by setting the orders per channel
     */
    public function getOrdersPerChannel()
    {

        // kanaal => orderId => ordervars
        $tst = array();
        $rtn = array();

        $source = null;
        $transactionId = null;

        foreach ($this->_results as $row) {

            if (isset($source) && strlen($source) > 0) {
                $rtn[$source][$transactionId] = $tst;
            }

            $source = "";
            $transactionId = "";
            $tst = array();

            foreach ($row as $key => $value) {
                if ($key == 'source') {
                    $source = $value;
                } elseif ($key == 'transactionId') {
                    $transactionId = $value;
                } else {
                    $tst[$key] = $value;
                }
            }
        }

        echo "<pre>";
        print_r($rtn);
        echo "</pre>";
    }
}