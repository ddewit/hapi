<?php

namespace Harvest\Tests\Api;

use Harvest;

class ClientTest extends \PHPUnit_Framework_TestCase
{
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
        
        $harvest->api('Client')->delete((int)$response->get('data'));
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
        
        $harvest->api('Client')->delete((int)$client->get('id'));
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