<?php
/**
 * GeonamesTest.php file.
 *
 * @author Dirk Adler <adler@spacedealer.de>
 * @link http://www.spacedealer.de
 * @copyright Copyright &copy; 2014 spacedealer GmbH
 */

namespace richweber\tests\geonames\api;

use richweber\geonames\api\Geonames;

/**
 * Class GeonamesTest
 */
class GeonamesTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var string Official demo user name
     */
    public $username = 'demo';

    /**
     * @dataProvider dataProvider
     * \richweber\geonames\api\Response $response
     *
     * @param $command
     * @param $params
     */
    public function testCommands($command, $params)
    {
        // init api client class
        $client = new Geonames($this->username);

        /** @var \richweber\geonames\api\Response $response */
        $response = $client->$command($params);

        $this->assertTrue($response->isOk());
        $this->assertEquals(
            'Kreisfreie Stadt Berlin',
            $response->getIterator()->getArrayCopy()['postalCodes'][0]['adminName3']
        );
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [
                'postalCodeSearch',
                [
                    'postalcode' => '10997',
                    'country' => 'de',
                ]
            ]
        ];
    }

    public function testBaseUrl()
    {
        // init api client class
        $client = new Geonames($this->username, 'en', null);
        $this->assertEquals('http://api.geonames.org/', (string)$client->getDescription()->getBaseUri());

        // init api client class
        $client = new Geonames($this->username, 'en', '');
        $this->assertEquals('', (string)$client->getDescription()->getBaseUri());

        // init api client class
        $client = new Geonames($this->username, 'en', 'https://example.com');
        $this->assertEquals('https://example.com', (string)$client->getDescription()->getBaseUri());
    }
}
