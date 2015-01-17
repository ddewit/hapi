<?php

namespace Harvest\Tests\Model;

use Harvest;

/**
 * HarvestApi test cases
 */
class AbstractModelTest extends \PHPUnit_Framework_TestCase
{
    public function testSet() {
        $model = new \Harvest\Model\Client;
        $model->set('id', 1234);
        $this->assertEquals(array('id' => 1234), \PHPUnit_Framework_Assert::readAttribute($model, '_values'));
    }

    public function testGet() {
        $model = new \Harvest\Model\Client;
        $model->set('id', 1234);
        $this->assertEquals(1234, $model->get('id'));
    }

    public function testToXml() {
        $model = new \Harvest\Model\Client;
        $model->set('id', 1234);
        $model->set('name', 'LightYear, Inc.');
        $model->set('created_at', \DateTime::createFromFormat(\DateTime::ISO8601, '2014-06-13T10:15:07+0000'));

        $xml = '<client><id>1234</id><name>LightYear, Inc.</name><created-at>2014-06-13T10:15:07+0000</created-at></client>';
        $this->assertXmlStringEqualsXmlString($xml, $model->toXml());
    }
}
