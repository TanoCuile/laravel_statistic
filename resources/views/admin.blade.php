<!DOCTYPE html>
<html>
<head>
    <title>Admin page</title>

    <link href="https://fonts.googleapis.com/css?family=Lato:100" rel="stylesheet" type="text/css">
    <link type="text/css" rel="stylesheet" href="{{ asset("lib/bootstrap/css/bootstrap.css") }}">
    <link type="text/css" rel="stylesheet" href="{{ asset("lib/bootstrap/css/bootstrap-theme.css") }}">
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class=""><h3>Браузeры</h3></div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td></td>
                    <?php foreach ($siteStatistic->getBrowsers() as $key => $browserInfo) {?>
                        <td><?php print  $browserInfo->getLabel(); ?></td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pageStatistic as $page => $stat) { ?>
                <tr>
                    <td><?php print $page?></td>
                    <?php foreach ($siteStatistic->getBrowsers() as $key => $browserInfo) {?>
                    <td><?php print  $stat->hasBrowser($key) ? $stat->getBrowser($key)->getTotal() : ''; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <?php foreach ($siteStatistic->getBrowsers() as $key => $browserInfo) {?>
                    <td><?php print  $browserInfo->getTotal(); ?></td>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-4">
            <div class=""><h3>Платформы</h3></div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td></td>
                    <?php foreach ($siteStatistic->getOss() as $key => $osInfo) {?>
                    <td><?php print  $osInfo->getLabel(); ?></td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pageStatistic as $page => $stat) { ?>
                <tr>
                    <td><?php print $page?></td>
                    <?php foreach ($siteStatistic->getOss() as $key => $osInfo) {?>
                    <td><?php print  $stat->hasOs($key) ? $stat->getOs($key)->getTotal() : ''; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <?php foreach ($siteStatistic->getOss() as $key => $osInfo) {?>
                    <td><?php print  $osInfo->getTotal(); ?></td>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-4">
            <div class=""><h3>Refferefs</h3></div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td></td>
                    <?php foreach ($siteStatistic->getRefs() as $key => $refInfo) {?>
                    <td><?php print  $refInfo->getLabel(); ?></td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pageStatistic as $page => $stat) { ?>
                <tr>
                    <td><?php print $page?></td>
                    <?php foreach ($siteStatistic->getRefs() as $key => $refInfo) {?>
                    <td><?php print  $stat->hasRefs($key) ? $stat->getRef($key)->getTotal() : ''; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <?php foreach ($siteStatistic->getRefs() as $key => $refInfo) {?>
                    <td><?php print  $refInfo->getTotal(); ?></td>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class=""><h3>Города</h3></div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td></td>
                    <?php foreach ($siteStatistic->getCities() as $key => $city) {?>
                    <td><?php print  $city->getLabel(); ?></td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pageStatistic as $page => $stat) { ?>
                <tr>
                    <td><?php print $page?></td>
                    <?php foreach ($siteStatistic->getCities() as $key => $city) {?>
                    <td><?php print  $stat->hasCities($key) ? $stat->getCity($key)->getTotal() : ''; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <?php foreach ($siteStatistic->getCities() as $key => $city) {?>
                    <td><?php print  $city->getTotal(); ?></td>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-4">
            <div class=""><h3>Города</h3></div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td></td>
                    <?php foreach ($siteStatistic->getRegions() as $key => $region) {?>
                    <td><?php print  $region->getLabel(); ?></td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pageStatistic as $page => $stat) { ?>
                <tr>
                    <td><?php print $page?></td>
                    <?php foreach ($siteStatistic->getRegions() as $key => $region) {?>
                    <td><?php print  $stat->hasRegion($key) ? $stat->getRegion($key)->getTotal() : ''; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <?php foreach ($siteStatistic->getRegions() as $key => $region) {?>
                    <td><?php print  $region->getTotal(); ?></td>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-4">
            <div class=""><h3>Страны</h3></div>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <td></td>
                    <?php foreach ($siteStatistic->getCountries() as $key => $country) {?>
                    <td><?php print  $country->getLabel(); ?></td>
                    <?php } ?>
                </tr>
                </thead>
                <tbody>
                <?php foreach($pageStatistic as $page => $stat) { ?>
                <tr>
                    <td><?php print $page?></td>
                    <?php foreach ($siteStatistic->getCountries() as $key => $country) {?>
                    <td><?php print  $stat->hasCountries($key) ? $stat->getCountry($key)->getTotal() : ''; ?></td>
                    <?php } ?>
                </tr>
                <?php } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td>Total</td>
                    <?php foreach ($siteStatistic->getCountries() as $key => $country) {?>
                    <td><?php print  $country->getTotal(); ?></td>
                    <?php } ?>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script src="{{ asset('lib/jquery/jquery-2.1.4.min.js')  }}" type="text/javascript"></script>
<script src="{{ asset('lib/bootstrap/js/bootstrap.js')  }}" type="text/javascript"></script>
</body>
</html>