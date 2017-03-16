<?php namespace TheDMSGrp\ZipGeo;

use Exception;

/**
 * Class GeoNamesOrgParser
 */
class GeoNamesOrgParser
{
    /**
     * @var string
     */
    public static $dbLocation = __DIR__ . '/db/US.txt';

    /**
     * @param $line
     * @return array
     * @throws Exception
     */
    private static function parseLine($line)
    {
        if (empty($line)) {
            throw new Exception('Provided line is empty');
        }

        $result = [
            'country' => null,
            'zipcode' => null,
            'city' => null,
            'state-name' => null,
            'state-code' => null,
            'county' => null
        ];

        // By one tab
        //$parts = preg_split("/[\t]/", $line);

        // By one or more tabs
        $parts = preg_split('/\t+/', $line);

        if (!empty($parts)) {
            $result['country'] = !empty($parts[0]) ? strtoupper(trim($parts[0])) : '';
            $result['zipcode'] = !empty($parts[1]) ? strtoupper(trim($parts[1])) : '';
            $result['city'] = !empty($parts[2]) ? strtoupper(trim($parts[2])) : '';
            $result['state-name'] = !empty($parts[3]) ? strtoupper(trim($parts[3])) : '';
            $result['state-code'] = !empty($parts[4]) ? strtoupper(trim($parts[4])) : '';
            $result['county'] = !empty($parts[5]) ? strtoupper(trim($parts[5])) : '';
        }

        return $result;
    }

    /**
     * @param $city
     * @param $state
     * @return array
     */
    public static function getGeoInfoByCityAndStateName($city, $state)
    {
        $city = !empty($city) ? strtoupper(trim($city)) : '';
        $state = !empty($state) ? strtoupper(trim($state)) : '';

        if (!empty($state)) {
            if (strlen($state) === 2) {
                return self::getResultFromDB(['city' => $city, 'state-code' => $state]);
            } else {
                return self::getResultFromDB(['city' => $city, 'state-name' => $state]);
            }
        } else {
            return self::getResultFromDB(['city' => $city]);
        }
    }

    /**
     * @param $searchParams
     * @return array
     * @throws Exception
     */
    public static function getResultFromDB($searchParams)
    {
        if (empty(self::$dbLocation)) {
            throw new Exception('You must provide a database location');
        }

        $dbPath = __DIR__ . self::$dbLocation;

        if (!file_exists($dbPath)) {
            throw new Exception('The provided database path is wrong');
        }

        $requiredKeys = array();

        foreach ($searchParams as $key => $val) {
            $requiredKeys[$key] = $key;
        }

        $handle = fopen($dbPath, "r");

        $found = 0;

        if ($handle) {
            while (($currentLine = fgets($handle)) !== false) {
                if (!empty($currentLine)) {
                    $currentLocation = self::parseLine($currentLine);

                    $found = 0;

                    if(count(array_intersect_key($requiredKeys, $currentLocation)) === count($requiredKeys)) {
                        $found = count(array_intersect($searchParams, $currentLocation)) === count($searchParams);
                    }

                    if ($found) {
                        break;
                    }
                }
            }

            fclose($handle);
        } else {
            // error opening the file.
        }

        // So we don't return the last record of the database
        if (!$found) {
            $currentLocation = null;
        }

        return $currentLocation;
    }
}
