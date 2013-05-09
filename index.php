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
            <div class="phone icon-phone" onclick="location.href='tel:0357009703';"><span><a href="tel:0357009703">035 -
                        7009 703</a></span></div>
        </div>
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
                        echo "<div class=\"col6\">";
                    }

                    if ($source['source'] == "kieskeurig.nl") {
                        $clickCosts = 250; // specific cost
                        echo "<div class=\"col6 last\">";
                    }

                    if ($source['source'] != "(direct)") {

                        // calculate profit over orders
                        foreach ($orderData[$source['source']] as $orderKey => $orderValue) {
                            $basecosts += $mClient->getSalesOrderBaseCost($orderKey);
                        }

                        $specificCosts = $source['transactionTax'] + $source['transactionShipping'] + $clickCosts + $basecosts;
                        $calc->setSpecificCosts($specificCosts);

                        echo "<h2 class=\"ic\">" . $source['source'] . "</h2>";
                        echo "<p>";
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