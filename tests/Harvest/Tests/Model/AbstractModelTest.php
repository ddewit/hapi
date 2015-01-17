<?php

namespace Harvest\Tests\Model;

use Harvest;

/**
 * HarvestApi test cases
 */
class AbstractModelTest extends \PHPUnit_Framework_TestCase
{
    // TODO: most of these tests should move to TypeTest instead.

    public function testTypeMarshalingInteger() {
        $model = new \Harvest\Model\Client;
        $this->assertEquals(1, $model->marshalValue('1', 'integer'));
    }

    public function testTypeMarshalingString() {
        $model = new \Harvest\Model\Client;
        $this->assertEquals('Lightyear, Inc.', $model->marshalValue('Lightyear, Inc.', 'string'));
        $this->assertEquals('1', $model->marshalValue('1', 'string'));
    }

    public function testTypeMarshalingDateTime() {
        $model = new \Harvest\Model\Client;
        $this->assertEquals(
            '2014-06-13T10:15:07+0000',
            $model->marshalValue('2014-06-13T10:15:07Z', 'dateTime')->format(\DateTime::ISO8601)
        );
    }

    public function testTypeMarshalingDate() {
        $model = new \Harvest\Model\Client;
        $this->assertEquals('2014-06-13', $model->marshalValue('2014-06-13', 'date')->format('Y-m-d'));
    }

    public function testTypeMarshalingBoolean() {
        $model = new \Harvest\Model\Client;
        $this->assertEquals(true, $model->marshalValue('true', 'boolean'));
        $this->assertEquals(false, $model->marshalValue('false', 'boolean'));
    }

    public function testTypeMarshalingDecimal() {
        $model = new \Harvest\Model\Client;
        $this->assertEquals(100.5, $model->marshalValue('100.50', 'decimal'));
        $this->assertEquals(1.0, $model->marshalValue('1', 'decimal'));
    }

    public function testTypeMarshalingWithInvalidValues() {
        $this->setExpectedException('Harvest\Exception\HarvestException');

        $model = new \Harvest\Model\Client;
        $model->marshalValue('potato', 'integer');
        $model->marshalValue('potato', 'dateTime');
        $model->marshalValue('potato', 'date');
        $model->marshalValue('potato', 'boolean');
        $model->marshalValue('potato', 'decimal');
    }

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
