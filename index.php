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
<link rel="stylesheet" id="rwcss-css" href="http://www.presteren.nu/wp-content/themes/creolio-child/rw-core.css?ver=1.1"
      type="text/css" media="all">
<link rel="stylesheet" id="rwcsscolor-css"
      href="http://www.presteren.nu/wp-content/themes/creolio-child/rw-colors.css?ver=1.1" type="text/css" media="all">
<link rel="stylesheet" id="views-pagination-style-css"
      href="http://www.presteren.nu/wp-content/plugins/wp-views/embedded/res/css/wpv-pagination.css?ver=1.1.4.1"
      type="text/css" media="all">
<link rel="stylesheet" id="openbook-css"
      href="http://www.presteren.nu/wp-content/plugins/openbook-book-data/libraries/openbook_style.css?ver=3.5.1"
      type="text/css" media="all">
<link rel="stylesheet" id="jetpack-widgets-css"
      href="http://www.presteren.nu/wp-content/plugins/jetpack/modules/widgets/widgets.css?ver=20121003" type="text/css"
      media="all">
<link rel="stylesheet" id="video-js-css-css"
      href="http://www.presteren.nu/wp-content/themes/creolio/assets/core/libs/css/video-js.css?ver=3.5.1"
      type="text/css" media="all">
<link rel="stylesheet" id="fancybox-css-css"
      href="http://www.presteren.nu/wp-content/themes/creolio/assets/core/libs/css/jquery.fancybox-1.3.4.css?ver=3.5.1"
      type="text/css" media="all">
<link rel="stylesheet" id="gforms_css-css"
      href="http://www.presteren.nu/wp-content/plugins/gravityforms/css/forms.css?ver=1.6.12" type="text/css"
      media="all">
<link rel="stylesheet" id="wpv_render_css-css"
      href="http://www.presteren.nu/wp-content/plugins/wp-views/res/css/wpv-views-sorting.css?ver=3.5.1" type="text/css"
      media="all">
<script type="text/javascript" src="http://www.presteren.nu/wp-includes/js/jquery/jquery.js?ver=1.8.3"></script>
<style type="text/css">
    /* Color1 - White */
.theme1 header,
.theme1 header a,
.theme1 .full.color3,
.theme1 .color3 .tagline,
.theme1 .color2,
.theme1 .slides_container .caption,
.theme1 .flex-direction-nav li a:before,
.theme1 .color1 .btn-small,
.theme1 .color1 .btn-big,
.theme1 .item h2,
.theme1 .item .inner:before,
.theme1 .filters a:hover,
.theme1 .filters li.active a,
.theme1 .color2 .filters a,
.theme1 .color2 .isotope-loading,
.theme1 .color2 .isotope-loading a,
.theme1 .color3 .isotope-loading,
.theme1 .color3 .isotope-loading a,
.theme1 .color1 .search,
.theme1 .color1 .search a,
.theme1 .color1 .search input,
.theme1 .color1 form input,
.theme1 .color1 form textarea,
.theme1 .color1 ul.categories a,
.theme1 .color2 .pagination a,
.theme1 footer ul.social a,
.theme1 .color1 .accordion .acc-title {
    color: #FFF !important; /* !important because footer icon color */
}

.theme1 ::selection {
    color: #FFF !important;
}

.theme1 ::-moz-selection {
    /* has to be separated from ::selection */
    color: #FFF;
}

.theme1 .color1,
.theme1 .color1 .arrow,
.theme1 .color1 .iconic > :first-child:before,
.theme1 .color1 .iconic:after,
.theme1 .color2 .btn-small:hover,
.theme1 .color2 .btn-big:hover,
.theme1 .color3 .btn-small:hover,
.theme1 .color3 .btn-big:hover,
.theme1 .color3 ul.categories a,
.theme1 .color2 form input,
.theme1 .color2 form textarea,
.theme1 .color2 .pagination .current,
.theme1 .color2 .pagination a:hover,
.theme1 .color3 .pagination a:hover,
.theme1 .color3 .pagination .current,
.theme1 .color2 .accordion .acc-title,
.theme1 .color3 .accordion .acc-title {
    background: #FFF;
}

.theme1 .color2 .iconic > :first-child:before,
.theme1 .color2 .iconic:before,
.theme1 .color3 .iconic > :first-child:before,
.theme1 .color3 .iconic:before,
.theme1 .color2 .iconic h1:after, .theme1 .color2 .iconic h2:after, .theme1 .color2 .iconic h3:after, .theme1 .color2 .iconic h4:after,
.theme1 .color3 .iconic h1:after, .theme1 .color3 .iconic h2:after, .theme1 .color3 .iconic h3:after, .theme1 .color2 .iconic h4:after {
    border-color: #FFF;
}

.theme1 .color2 .iconic:after,
.theme1 header nav ul li a.sub:before,
.theme1 .color3 .iconic:after {
    border-color: #FFF transparent;
}

    /* Color2 - Yellow */
.theme1 .color3.tagline span,
.theme1 .color3 a,
.theme1 .color1 a,
.theme1 .color1 h1 span, .theme1 .color3 h1 span,
.theme1 .color1 h2 span, .theme1 .color3 h2 span,
.theme1 .color1 h3 span, .theme1 .color3 h3 span,
.theme1 .color1 h4 span, .theme1 .color3 h4 span,
.theme1 .color1 h5 span, .theme1 .color3 h5 span,
.theme1 .color1 h6 span, .theme1 .color3 h6 span,
.theme1 .color1 .tags a:hover,
.theme1 .color2 .btn-small,
.theme1 .color2 .btn-big,
.theme1 .color3 .iconic:before,
.theme1 .color1 .tagline span,
.theme1 .color1 ul.tags:before,
.theme1 .color1 .isotope-loading span,
.theme1 .color3 .isotope-loading span,
.theme1 .color1 ul.social a:hover,
.theme1 .color3 .google-map,
.theme1 .color2 .post-content span,
.theme1 .comments span:before,
.theme1 .widget_search form:after,
.theme1 .color2 .accordion .acc-title {
    color: #00B2CC;
}

.theme1 header.color2,
.theme1 .color2,
.theme1 .color2 .arrow,
.theme1 .color2 .iconic > :first-child:before,
.theme1 .color2 .iconic:after,
.theme1 .color2 .iconic:after,
.theme1 .flex-direction-nav li a,
.theme1 .color1 .btn-small,
.theme1 .color1 .btn-big,
.theme1 .color3 .btn-small,
.theme1 .color3 .btn-big,
.theme1 .color3 ul.categories a:hover,
.theme1 .color1 ul.categories a:hover,
.theme1 .item .inner:before,
.theme1 .color1 .filters ul li.active > a,
.theme1 .color1 .filters ul li a:hover,
.theme1 .color3 .filters ul li.active > a,
.theme1 .color3 .filters ul li a:hover,
.theme1 .color1 .search, .theme1 .color1 .search input,
.theme1 .audiojs .progress,
.theme1 .color1 .pagination a:hover,
.theme1 .color1 .pagination .current,
.theme1 .color3 .pagination span,
.theme1 .color3 .pagination a,
.theme1 footer.color3 ul.social a:hover,
.theme1 footer.color3 ul.social li.active a:hover,
.theme1 .header-widgets.color3 ul.social a:hover,
.theme1 .header-widgets.color3 ul.social li.active a:hover,
.theme1 .color1 .accordion .active .acc-title,
.theme1 .color1 .accordion .acc-title:hover,
.theme1 .color3 .accordion .active .acc-title,
.theme1 .color3 .accordion .acc-title:hover {
    background: #00B2CC;
}

.theme1 ::selection {
    background: #00B2CC;
}

.theme1 ::-moz-selection {
    /* has to be separated from ::selection */
    background: #00B2CC;
}

.theme1 .color1 .iconic > :first-child:before,
.theme1 .color1 .iconic:before,
.theme1 .color1 .iconic h1:after, .theme1 .color1 .iconic h2:after, .theme1 .color1 .iconic h3:after, .theme1 .color1 .iconic h4:after {
    border-color: #00B2CC;
}

.theme1 .color1 .iconic:after {
    border-color: #00B2CC transparent;
}

    /* Color3 - Brown */
body.theme1,
.theme1 .color2 a,
.theme1 .color2.tagline span,
.theme1 header .title span,
.theme1 .color2 h1 span,
.theme1 .color2 h2 span,
.theme1 .color2 h3 span,
.theme1 .color2 h4 span,
.theme1 .color2 h5 span,
.theme1 .color2 h6 span,
.theme1 .color1 .iconic > :first-child:before,
.theme1 .color1 .tags a,
.theme1 .color3 .btn-small,
.theme1 .color3 .btn-big,
.theme1 .color3 ul.categories a,
.theme1 .color2 .iconic:before,
.theme1 .color1 .tagline,
.theme1 .color2 .tagline span,
.theme1 .color1 .filters a,
.theme1 .color1 .isotope-loading,
.theme1 .color1 .isotope-loading a,
.theme1 .color2 .isotope-loading span,
.theme1 .color1 ul.social a,
.theme1 .color1 .pagination a:hover,
.theme1 .color1 .pagination .current,
.theme1 .color2 .pagination a:hover,
.theme1 .color2 .pagination .current,
.theme1 .color2 .pagination span,
.theme1 .color3 .pagination a,
.theme1 .color3 .pagination a:hover,
.theme1 .color3 .pagination .current,
.theme1 footer.color3 ul.social a:hover,
.theme1 footer.color3 ul.social li.active a:hover,
.theme1 .header-widgets.color3 ul.social a:hover,
.theme1 .header-widgets.color3 ul.social li.active a:hover,
.theme1 .color3 .accordion .acc-title {
    color: #312a1e;
}

.theme1 .color2 .pagination a:hover {
    color: #312a1e !important;
}

.theme1 header nav ul li.active > a,
.theme1 header nav ul li a:hover,
.theme1 .full.color3,
.theme1 .color3 .arrow,
.theme1 .taglineimg .caption-bg,
.theme1 .color3 .arrow,
.theme1 .color3 .iconic > :first-child:before,
.theme1 .color3 .iconic:after,
.theme1 .flex-direction-nav li a:hover,
.theme1 footer.color2 ul.social a:hover,
.theme1 footer.color2 ul.social li.active a:hover,
.theme1 .header-widgets.color2 ul.social a:hover,
.theme1 .header-widgets.color2 ul.social li.active a:hover,
.theme1 .color1 .btn-small:hover,
.theme1 .color1 .btn-big:hover,
.theme1 .color2 .btn-small,
.theme1 .color2 .btn-big,
.theme1 .item .post-content,
.theme1 .color2 .filters ul li.active > a,
.theme1 .color2 .filters ul li a:hover,
.theme1 .color3 .google-map,
.theme1 .color1 form input,
.theme1 .color1 form textarea,
.theme1 .color1 ul.categories a,
.theme1 .color1 .pagination span,
.theme1 .color1 .pagination a,
.theme1 .color2 .pagination span,
.theme1 .color2 .pagination a,
.theme1 .color1 .accordion .acc-title,
.theme1 .color2 .accordion .active .acc-title,
.theme1 .color2 .accordion .acc-title:hover {
    background: #312a1e;
}

.theme1 header,
.theme1 footer {
    border-color: #312a1e;
}

.theme1 header nav ul li a.sub:hover:before,
.theme1 header nav ul li.active > a:before {
    border-color: #312a1e transparent;
}

.theme1 .slides_container .caption {
    background: #312a1e;
    background: rgba(49, 42, 30, 0.5);
}
</style>
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