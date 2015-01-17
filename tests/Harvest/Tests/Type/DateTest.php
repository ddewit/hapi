<?php

namespace Harvest\Tests\Type;

use Harvest;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testMarshal()
    {
        $type = new \Harvest\Type\Date;
        $this->assertEquals(\DateTime::createFromFormat('Y-m-d', '2014-06-13'), $type->marshal('2014-06-13'));
    }
    
    public function testUnmarshal()
    {
        $type = new \Harvest\Type\Date;
        $this->assertEquals('2014-06-13', $type->unmarshal(\DateTime::createFromFormat('Y-m-d', '2014-06-13')));
    }
    
    public function testMarshalWithWeirdValues() {
        $this->setExpectedException('Harvest\Exception\HarvestException');
        
        $type = new \Harvest\Type\Date;
        $type->marshal('potato');
    }
}