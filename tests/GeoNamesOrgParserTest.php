<?php

require __DIR__ . '/../vendor/autoload.php';

require_once __DIR__ . '/../src/thedmsgrp/zipgeo/GeoNamesOrgParser.php';

use TheDMSGrp\ZipGeo\GeoNamesOrgParser;

/**
 * Class GeoNamesOrgParserTest
 */
class GeoNamesOrgParserTest extends PHPUnit_Framework_TestCase
{
    /**
     *
     */
    public function testGetInfoByCityAndStateCode()
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
    public function testGetInfoByCityAndStateName()
    {
        $city = "Clearwater";
        $state = "Florida";

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

    /**
     *
     */
    public function testGetInfoByZipcode()
    {
        $zipcode = 33761;

        $result = GeoNamesOrgParser::getGeoInfoByZipcode($zipcode);

        $this->assertNotEmpty($result);

        $this->assertArrayHasKey('country', $result);
        $this->assertArrayHasKey('zipcode', $result);
        $this->assertArrayHasKey('city', $result);
        $this->assertArrayHasKey('state-name', $result);
        $this->assertArrayHasKey('state-code', $result);
        $this->assertArrayHasKey('county', $result);

        $this->assertEquals($result['country'], 'US');
        $this->assertEquals($result['zipcode'], '33761');
        $this->assertEquals($result['city'], 'CLEARWATER');
        $this->assertEquals($result['state-name'], 'FLORIDA');
        $this->assertEquals($result['state-code'], 'FL');
        $this->assertEquals($result['county'], 'PINELLAS');
    }

    /**
     *
     */
    public function testExceptionWhenNoZipcode()
    {
        try {
            GeoNamesOrgParser::getGeoInfoByZipcode(null);
        } catch (Exception $e) {
            $this->assertEquals('You must provide a zipcode', $e->getMessage());
        }
    }

    /**
     *
     */
    public function testExceptionWhenNoDbLocation()
    {
        try {
            GeoNamesOrgParser::$dbLocation = null;
            GeoNamesOrgParser::getGeoInfoByZipcode(32258);
        } catch (Exception $e) {
            $this->assertEquals('You must provide a database location', $e->getMessage());
        }
    }
}
