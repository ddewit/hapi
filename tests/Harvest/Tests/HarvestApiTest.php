<?php

namespace Harvest\Tests;

use Harvest;

/**
 * HarvestApi test cases
 */
class HarvestApiTest extends \PHPUnit_Framework_TestCase
{
    public function testFetchApiClass() {
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
    
    /**
     * @group internet
     */
    public function testInternetCreateClient() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        $client = new \Harvest\Model\Client;
        $client->set('name', '# Hapi / ' . md5(rand()));
        
        $response = $harvest->api('Client')->create($client);
        $this->assertEquals(201, $response->get('code'));
    }
    
    /**
     * @group internet
     */
    public function testInternetGetClients() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        $response = $harvest->api('Client')->all(new \DateTime('monday 2 weeks ago'));
        $this->assertEquals(200, $response->get('code'));
        $this->assertNotEmpty($response->get('data'));
    }
    
    /**
     * @group internet
     */
    public function testInternetUpdateClient() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        // 1. create a dummy client
        $client = new \Harvest\Model\Client;
        $client->set('name', '# Hapi / ' . md5(rand()));
        $response = $harvest->api('Client')->create($client);
        $client->set('id', (int)$response->get('data'));
        
        // 2. rename it and update
        $client->set('name', $client->get('name') . ' - updated');
        $response = $harvest->api('Client')->update($client);
        
        $this->assertEquals(200, $response->get('code'));
        $this->assertNotEmpty($response->get('data'));
    }
    
    /**
     * @group internet
     */
    public function testInternetDeleteClient() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        // 1. create a dummy client
        $client = new \Harvest\Model\Client;
        $client->set('name', '# Hapi / ' . md5(rand()) . ' - delete me');
        $response = $harvest->api('Client')->create($client);
        
        // 2. destroy it
        $response = $harvest->api('Client')->delete((int)$response->get('data'));
        
        $this->assertEquals(200, $response->get('code'));
        $this->assertNotEmpty($response->get('data'));
    }
}
