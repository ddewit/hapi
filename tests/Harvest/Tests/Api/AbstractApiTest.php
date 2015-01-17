<?php

namespace Harvest\Tests\Api;

use Harvest;

class AbstractApiTest extends \PHPUnit_Framework_TestCase
{
    public function testAppendUpdatedSinceParam() {
        $harvest = new \Harvest\HarvestApi;
        $project = new \Harvest\Api\Project($harvest);
        $this->assertEquals('', $project->appendUpdatedSinceParam());
        $this->assertEquals('?updated_since=2014-06-13+10%3A15', $project->appendUpdatedSinceParam(\DateTime::createFromFormat(\DateTime::ISO8601, '2014-06-13T10:15:07+0000')));
        $this->assertEquals('?updated_since=2014-06-13+10%3A15', $project->appendUpdatedSinceParam('2014-06-13 10:15'));
    }
}