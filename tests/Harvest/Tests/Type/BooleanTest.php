<?php

namespace Harvest\Tests\Type;

use Harvest;

class BooleanTest extends \PHPUnit_Framework_TestCase
{
    public function testMarshal()
    {
        $type = new \Harvest\Type\Boolean;
        $this->assertEquals(true, $type->marshal('true'));
        $this->assertEquals(false, $type->marshal('false'));
    }
    
    public function testUnmarshal()
    {
        $type = new \Harvest\Type\Boolean;
        $this->assertEquals('true', $type->unmarshal(true));
        $this->assertEquals('false', $type->unmarshal(false));
    }
    
    public function testMarshalWithWeirdValues() {
        $this->setExpectedException('Harvest\Exception\HarvestException');
        
        $type = new \Harvest\Type\Boolean;
        $type->marshal('potato');
    }
}