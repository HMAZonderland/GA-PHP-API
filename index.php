<?php
// Session start
session_start();

// Turn on all error reporting
error_reporting(-1);

// Include all required files
require_once dirname(__FILE__) . '/includes.php';
?>
<!DOCTYPE html>
<html lang="nl-NL" prefix="og:http://ogp.me/ns#" class="csstransforms csstransforms3d csstransitions js">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <link rel="shortcut icon" href="http://www.presteren.nu/wp-content/themes/creolio-child/favicon.ico">
    <link href="http://fonts.googleapis.com/css?family=Quattrocento:400,700" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="http://www.presteren.nu/wp-content/themes/creolio-child/style.css">
    <!--[if IE 8]>
    <link rel="stylesheet" href="http://www.presteren.nu/wp-content/themes/creolio/assets/core/libs/css/ie8.css">
    <![endif]-->
    <link rel="stylesheet" id="rwcss-css"
          href="http://www.presteren.nu/wp-content/themes/creolio-child/rw-core.css?ver=1.1"
          type="text/css" media="all">
    <link rel="stylesheet" id="rwcsscolor-css"
          href="http://www.presteren.nu/wp-content/themes/creolio-child/rw-colors.css?ver=1.1" type="text/css"
          media="all">
    <script type="text/javascript" src="http://www.presteren.nu/wp-includes/js/jquery/jquery.js?ver=1.8.3"></script>
    <link rel="stylesheet" href="css/style_override.css">
    <title>esser-emmerik | Rendements berekening</title>
</head>
<body class="page page-id-49 page-template-default theme1 ie">

<header class="onerow color2">
    <div class="onepcssgrid-1200">
        <div class="col4 iconic icon-ok">
            <div class="title">
                <a href="http://www.presteren.nu">esser-emmerik</a>
            </div>
            <div>online verkoop experts</div>
            <div class="phone icon-phone" onclick="location.href='tel:0357009703';">
                <span><a href="tel:0357009703">035 -
                        7009 703</a></span>
            </div>
        </div>
        <nav class="col8 last">
            <div>
                <ul id="mainnav">
                    <li id="menu-item-48" class="active"><a href="index.php">Selecteer een ander account</a></li>
                    <li id="menu-item-288"><a href="index.php?logout">Uitloggen</a></li>
                </ul>
                <select class="selectnav" id="selectnav1" style="width: 1357px; ">
                    <option value="">Main navigation</option>
                    <option value="index.php" selected="">Selecteer een ander account</option>
                    <option value="index.php?logout">Uitloggen</option>
                </select>
                <i class="selnav icon-align-justify"></i>
            </div>
        </nav>
        <div class="arrow"></div>
    </div>
</header>

<?php
/**
 * @TODO: make this part of code more senseable
 */
// The only file that has to be included in the body for style purposes.
require_once dirname(__FILE__) . '/clients/GoogleAnalyticsAccountSelector.php';
?>


<section class="onerow full color1">
    <div class="onepcssgrid-1200">
        <?php
        if ((isset($GoogleAnalyticsAccount)) && (sizeof($GoogleAnalyticsAccount->getProperties() > 0)) && $GoogleAnalyticsAccount != null) {
            // 30 day time filter
            $from = date('Y-m-d', time() - 30 * 24 * 60 * 60);
            $to = date('Y-m-d');

            // Fetches all the Revenue metrics
            $TransactionRevenueMetrics = new TransactionRevenueMetrics($service, $_GET['profileId'], $from, $to);

            // Fetches the orders per channel
            $OrderPerMarketingChannel = new OrderPerMarketingChannel($service, $_GET['profileId'], $from, $to);
            $orderData = $OrderPerMarketingChannel->getOrdersPerChannel(); // all the order data

            // Costs this orgnisation has, per month now
            $costs = 5000;

            // Calulator
            $calc = new Calculator();
            $calc->setCosts($costs);

            foreach ($TransactionRevenueMetrics->getRevenuePerSource() as $source) {

                // set vars
                $calc->setRevenue($TransactionRevenueMetrics->getTotalRevenue());
                $calc->setRatio($source['transactionRevenue'] / $TransactionRevenueMetrics->getTotalRevenue());

                // set and reset basecosts
                $basecosts = 0;

                if ($source['source'] == "beslist.nl" || $source['source'] == "kieskeurig.nl" || $source['source'] == "beslistslimmershoppen") {
                    if ($source['source'] == "beslist.nl") {
                        $clickCosts = 125; // specific costs
                        echo "<div class=\"col6\">";
                    }

                    if ($source['source'] == "kieskeurig.nl") {
                        $clickCosts = 250; // specific cost
                        echo "<div class=\"col6 last\">";
                    }

                    if ($source['source'] != "(direct)") {
                        // calculate profit over orders in Magento
                        foreach ($orderData[$source['source']] as $orderKey => $orderValue) {
                            $basecosts += $mClient->getSalesOrderBaseCost($orderKey);
                        }

                        // Set specific costs
                        $specificCosts = $source['transactionTax'] + $source['transactionShipping'] + $clickCosts + $basecosts;
                        $calc->setSpecificCosts($specificCosts);

                        // Efficiency
                        $efficiency = $calc->calculateProfitSpecificPercentageReadable();

                        // Color effect
                        if ($efficiency > 0) {
                            $color = "#00FF00";
                        } else {
                            $color = "#FF0000";
                        }

                        echo "<h2 class=\"ic\">" . $source['source'] . "</h2><br />";
                        echo "<h3>Omzet uit Google Analytics</h3>";
                        echo "<p>";
                        echo "Totale omzet = &euro;" . $calc->getRevenue() . "<br />";
                        echo "Omzet " . $source['source'] . " = &euro;" . $source['transactionRevenue'] . "<br />";
                        echo "Verhoudingspercentage = " . $calc->getRatioReadable() . "% (&euro;" . $source['transactionRevenue'] . " / &euro;" . $TransactionRevenueMetrics->getTotalRevenue() . ")<br /><br />";
                        echo "</p>";

                        echo "<h3>Google Analytics en vaste kosten en kosten marketingkanaal</h3>";
                        echo "<p>";
                        echo "Totale Kosten per maand = &euro;" . $calc->getCosts() . "<br />";
                        echo "Kosten " . $source['source'] . " naar verhouding  = &euro;" . $calc->calculateCostsRatioReadable() . " (&euro;" . $costs . " / " . $calc->getRatioReadable() . "%)<br />";
                        echo "Klikkosten " . $source['source'] . " = &euro;" . $clickCosts . "<br />";
                        echo "Winst: &euro;" . $calc->calculateRatioProfitReadable() . " (&euro;" . $source['transactionRevenue'] . " - &euro;" . $calc->calculateCostsRatioReadable() . " - &euro;" . $clickCosts . ") <br />";
                        echo "Rendement nauwkeurigheids niveau 1: " . $calc->calculateProfitPercentageReadable() . "%<br /><br />";
                        echo "</p>";

                        echo "<h3>Google Analytics en vastekosten en specifieke kosten en inkoopkosten Magento</h3>";
                        echo "<p>";
                        echo "Totale Kosten per maand = &euro;" . $calc->getCosts() . "<br />";
                        echo "Kosten " . $source['source'] . " naar verhouding  = &euro;" . $calc->calculateCostsRatioReadable() . " (&euro;" . $costs . " / " . $calc->getRatioReadable() . "%)<br />";
                        echo "Klikkosten " . $source['source'] . "= &euro;" . $clickCosts . "<br />";
                        echo "Belasting = &euro;" . $source['transactionTax'] . "<br />";
                        echo "Verzendkosten = &euro;" . $source['transactionShipping'] . "<br />";
                        echo "Inkoopkosten = &euro;" . $basecosts . "<br />";
                        echo "Specifieke kosten = klikkosten + belasting + inkoopkosten + verzend: &euro;" . $calc->getSpecificCosts() . " (&euro;" . $calc->calculateCostsRatioReadable() . " + &euro;" . $clickCosts . " + &euro;" . $source['transactionTax'] . " + &euro;" . $source['transactionShipping'] . " + &euro;" . $basecosts . ")<br />";
                        echo "Winst: &euro;" . $efficiency . " (&euro;" . $source['transactionRevenue'] . " - &euro;" . $calc->getSpecificCosts() . ")<br />";
                        echo "Rendement nauwkeurigheidsniveau 4: <span style=\"color: $color;\"><strong>" . $efficiency . "%</strong></span>";
                        echo "</p>";
                        echo "</div>";
                    }
                }
            }
        }
        ?>
    </div>
</section>
</body>
</html>