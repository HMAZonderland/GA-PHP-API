<?php
// Session start
session_start();

// Turn on all error reporting
error_reporting(-1);

// Include all required files
require_once dirname(__FILE__) . 'includes.php';

if ((isset($GoogleAnalyticsAccount)) && (sizeof($GoogleAnalyticsAccount->getProperties() > 0)) && $GoogleAnalyticsAccount != null) {
    // Tijd filter
    $from = date('Y-m-d', time() - 30 * 24 * 60 * 60); // 30 days
    $to = date('Y-m-d'); // today

    // Fetches all the Revenue metrics
    $TransactionRevenueMetrics = new TransactionRevenueMetrics($service, $_GET['profileId'], $from, $to);

    // Fetches the orders per channel
    $OrderPerMarketingChannel = new OrderPerMarketingChannel($service, $_GET['profileId'], $from, $to);
    $orderData = $OrderPerMarketingChannel->getOrdersPerChannel(); // all the order data

    // Profit made over all orders in marketing channel
    $profit;

    $kosten = 5000; // per maand

    $calc = new Calculator();
    $calc->setCosts($kosten);

    foreach ($TransactionRevenueMetrics->getRevenuePerSource() as $source) {

        // set vals
        $calc->setRevenue($TransactionRevenueMetrics->getTotalRevenue());
        $calc->setRatio($source['transactionRevenue'] / $TransactionRevenueMetrics->getTotalRevenue());

        // reset
        $basecosts = 0;

        if ($source['source'] == "beslist.nl" || $source['source'] == "kieskeurig.nl" || $source['source'] == "beslistslimmershoppen") {
            if ($source['source'] == "beslist.nl") {
                $clickCosts = 125; // specific costs
            }

            if ($source['source'] == "kieskeurig.nl") {
                $clickCosts = 250; // specific cost
            }

            if ($source['source'] != "(direct)") {

                // calculate profit over orders
                foreach ($orderData[$source['source']] as $orderKey => $orderValue) {
                    $basecosts += $mClient->getSalesOrderBaseCost($orderKey);
                }

                $specificCosts = $source['transactionTax'] + $source['transactionShipping'] + $clickCosts + $basecosts;
                $calc->setSpecificCosts($specificCosts);

                echo "<h1>" . $source['source'] . "</h1>";
                echo "Totale omzet = &euro;" . $calc->getRevenue() . "<br />";
                echo "Omzet " . $source['source'] . " = &euro; " . $source['transactionRevenue'] . "<br />";
                echo $source['transactionRevenue'] . " / " . $TransactionRevenueMetrics->getTotalRevenue() . " = " . $source['transactionRevenue'] / $TransactionRevenueMetrics->getTotalRevenue() . "%<br />";

                echo "Percentage = " . $calc->getRatioReadable() . "%<br /><br />";

                echo "Kosten = &euro;" . $calc->getCosts() . "<br />";
                echo "Kosten " . $source['source'] . " = &euro;" . $calc->calculateCostsRatioReadable() . " <br />";

                echo "Winst (omzet - (vaste) kosten): &euro;" . $calc->calculateRatioProfitReadable() . "<br />";
                echo "Rendement zonder specifieke kosten: " . $calc->calculateProfitPercentageReadable() . "%<br /><br />";

                echo "Klikkosten = &euro;" . $clickCosts . "<br />";
                echo "Belasting = &euro;" . $source['transactionTax'] . "<br />";
                echo "Verzendkosten = &euro;" . $source['transactionShipping'] . "<br />";
                echo "Inkoopkosten = &euro;" . $basecosts . "<br />";
                echo "Specifieke kosten (klik, belasting, inkoopkosten + verzend) = &euro;" . $calc->getSpecificCosts() . "<br />";
                echo "Winst (omzet - ((vaste) kosten + specifiekekosten): &euro;" . $calc->calculateRatioSpecificProfitReadable() . "<br />";
                echo "Rendement met specifieke kosten: " . $calc->calculateProfitSpecificPercentageReadable() . "%";
            }
        }
    }
}