<?php

namespace Harvest\Tests\Type;

use Harvest;

class DateTimeTest extends \PHPUnit_Framework_TestCase
{
    public function testMarshal()
    {
        $type = new \Harvest\Type\DateTime;
        $this->assertEquals(\DateTime::createFromFormat(\DateTime::ISO8601, '2014-06-13T10:15:07Z'), $type->marshal('2014-06-13T10:15:07Z'));
    }
    
    public function testUnmarshal()
    {
        $type = new \Harvest\Type\DateTime;
        $this->assertEquals('2014-06-13T10:15:07+0000', $type->unmarshal(\DateTime::createFromFormat(\DateTime::ISO8601, '2014-06-13T10:15:07Z')));
    }
    
    public function testMarshalWithWeirdValues() {
        $this->setExpectedException('Harvest\Exception\HarvestException');
        
        $type = new \Harvest\Type\DateTime;
        $type->marshal('potato');
    }
}