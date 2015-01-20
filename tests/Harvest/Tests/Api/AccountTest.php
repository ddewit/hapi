<?php

namespace Harvest\Tests\Api;

use Harvest;

class AccountTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @group internet
     */
    public function testInternetWhoAmI() {
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();
        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }
        
        $harvest = new \Harvest\HarvestApi;
        $harvest->authenticate($config->user, $config->password);
        $harvest->setAccount($config->account);
        $response = $harvest->api('Account')->whoAmI();
        
        $this->assertEquals(200, $response->get('code'));
    }
}