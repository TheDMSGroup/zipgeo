<?php

require_once('GeoNamesOrgParser.php');

$start_time = microtime(TRUE);

$result = GeoNamesOrgParser::getGeoInfoByCityAndStateName('Clearwater', 'FL');

$end_time = microtime(TRUE);

print_r($result);

echo $end_time - $start_time . PHP_EOL;
