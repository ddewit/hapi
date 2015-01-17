<?php

namespace Harvest\Tests\Type;

use Harvest;

class IntegerTest extends \PHPUnit_Framework_TestCase
{
    public function testMarshal()
    {
        $type = new \Harvest\Type\Integer;
        $this->assertEquals(1, $type->marshal('1'));
        $this->assertEquals(9999, $type->marshal('9999'));
        $this->assertEquals(0, $type->marshal('0'));
    }
    
    public function testUnmarshal()
    {
        $type = new \Harvest\Type\Integer;
        $this->assertEquals('1', $type->unmarshal(1));
        $this->assertEquals('9999', $type->unmarshal(9999));
    }
    
    public function testMarshalWithWeirdValues() {
        $this->setExpectedException('Harvest\Exception\HarvestException');
        
        $type = new \Harvest\Type\Integer;
        $type->marshal('potato');
    }
}