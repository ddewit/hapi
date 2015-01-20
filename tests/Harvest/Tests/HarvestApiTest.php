<?php

namespace Harvest\Tests;

use Harvest;

/**
 * HarvestApi test cases
 */
class HarvestApiTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchApiClass() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $this->assertInstanceOf('Harvest\Api\Project', $harvest->api('Project'));
    }

    public function testFetchInvalidApiClass() {
        $this->setExpectedException('InvalidArgumentException');

        $harvest = new \Harvest\HarvestApi;
        $harvest->api('blahblahblah');
    }

    public function testAuthenticationPasstrough() {
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate('j.doe@example.com', 'ilovejanedoe');
        $harvest->setAccount('example');

        $this->assertEquals('j.doe@example.com', \PHPUnit_Framework_Assert::readAttribute($harvest->getHttpClient(), 'username'));
        $this->assertEquals('ilovejanedoe', \PHPUnit_Framework_Assert::readAttribute($harvest->getHttpClient(), 'password'));
        $this->assertEquals('example', \PHPUnit_Framework_Assert::readAttribute($harvest->getHttpClient(), 'account'));
    }
}
