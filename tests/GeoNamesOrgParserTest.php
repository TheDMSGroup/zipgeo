<?php

require __DIR__ . '/../vendor/autoload.php';

use TheDMSGrp\ZipGeo\GeoNamesOrgParser;

/**
 * Class GeoNamesOrgParserTest
 */
class GeoNamesOrgParserTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetInfoByCityAndState()
    {
        $city = "Clearwater";
        $state = "FL";

        $result = GeoNamesOrgParser::getGeoInfoByCityAndStateName($city, $state);

        $this->assertNotEmpty($result);

        $this->assertArrayHasKey('country', $result);
        $this->assertArrayHasKey('zipcode', $result);
        $this->assertArrayHasKey('city', $result);
        $this->assertArrayHasKey('state-name', $result);
        $this->assertArrayHasKey('state-code', $result);
        $this->assertArrayHasKey('county', $result);

        $this->assertEquals($result['country'], 'US');
        $this->assertEquals($result['zipcode'], '33755');
        $this->assertEquals($result['city'], 'CLEARWATER');
        $this->assertEquals($result['state-name'], 'FLORIDA');
        $this->assertEquals($result['state-code'], 'FL');
        $this->assertEquals($result['county'], 'PINELLAS');
    }

    /**
     *
     */
    public function testGetInfoByCity()
    {
        $city = "Clearwater";

        $result = GeoNamesOrgParser::getGeoInfoByCityAndStateName($city, null);

        $this->assertNotEmpty($result);

        $this->assertArrayHasKey('country', $result);
        $this->assertArrayHasKey('zipcode', $result);
        $this->assertArrayHasKey('city', $result);
        $this->assertArrayHasKey('state-name', $result);
        $this->assertArrayHasKey('state-code', $result);
        $this->assertArrayHasKey('county', $result);

        $this->assertEquals($result['country'], 'US');
        $this->assertEquals($result['zipcode'], '33755');
        $this->assertEquals($result['city'], 'CLEARWATER');
        $this->assertEquals($result['state-name'], 'FLORIDA');
        $this->assertEquals($result['state-code'], 'FL');
        $this->assertEquals($result['county'], 'PINELLAS');
    }
}
