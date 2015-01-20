<?php

namespace Harvest\Tests\Api;

use Harvest;

class ProjectTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group internet
     */
    public function testInternetCreateProject() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        $client = new \Harvest\Model\Client;
        $client->set('name', '# Hapi / Client with a project / ' . md5(rand()));
        $response = $harvest->api('Client')->create($client);
        $client_id = (int)$response->get('data');
        
        $project = new \Harvest\Model\Project;
        $project->set('name', '# Hapi / ' . md5(rand()));
        $project->set('active', true);
        $project->set('client-id', $client_id);
        
        $response = $harvest->api('Project')->create($project);
        $this->assertEquals(201, $response->get('code'));
        
        // 4. cleanup
        $harvest->api('Project')->delete((int)$response->get('data'));
        $harvest->api('Client')->delete((int)$client_id);
    }
    
    /**
     * @group internet
     */
    public function testInternetGetProjects() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        $response = $harvest->api('Project')->all(new \DateTime('monday 2 weeks ago'));
        $this->assertEquals(200, $response->get('code'));
        $this->assertNotEmpty($response->get('data'));
    }
    
    /**
     * @group internet
     */
    public function testInternetUpdateProject() {
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        // 1. create a client to which we can connect a project
        $client = new \Harvest\Model\Client;
        $client->set('name', '# Hapi / Client with a project / ' . md5(rand()));
        $response = $harvest->api('Client')->create($client);
        $client_id = (int)$response->get('data');
        
        // 2. create a project
        $project = new \Harvest\Model\Project;
        $project->set('name', '# Hapi / ' . md5(rand()));
        $project->set('active', true);
        $project->set('client-id', $client_id);
        
        $response = $harvest->api('Project')->create($project);
        $project->set('id', (int)$response->get('data'));
        
        // 3. rename it and update
        $project->set('name', $project->get('name') . ' - updated');
        $response = $harvest->api('Project')->update($project);
        
        $this->assertEquals(200, $response->get('code'));
        $this->assertNotEmpty($response->get('data'));
        
        // 4. cleanup
        $harvest->api('Project')->delete((int)$response->get('id'));
        $harvest->api('Client')->delete((int)$client_id);
    }
    
    /**
     * @group internet
     */
    public function testInternetDeleteProject() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        
        // 1. create a client to which we can connect a project
        $client = new \Harvest\Model\Client;
        $client->set('name', '# Hapi / Client with a project / ' . md5(rand()));
        $response = $harvest->api('Client')->create($client);
        $client_id = (int)$response->get('data');
        
        // 2. create a project
        $project = new \Harvest\Model\Project;
        $project->set('name', '# Hapi / ' . md5(rand()));
        $project->set('active', true);
        $project->set('client-id', $client_id);
        
        $response = $harvest->api('Project')->create($project);
        
        // 3. destroy it
        $response = $harvest->api('Project')->delete((int)$response->get('data'));
        
        $this->assertEquals(200, $response->get('code'));
        $this->assertNotEmpty($response->get('data'));
        
        // 4. cleanup
        $harvest->api('Client')->delete((int)$client_id);
    }
}