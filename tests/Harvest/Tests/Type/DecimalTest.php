<?php

namespace Harvest\Tests\Type;

use Harvest;

class DecimalTest extends \PHPUnit_Framework_TestCase
{
    public function testMarshal()
    {
        $type = new \Harvest\Type\Decimal;
        $this->assertEquals(10.00, $type->marshal('10.00'));
        $this->assertEquals(105.99, $type->marshal('105.99'));
    }
    
    public function testUnmarshal()
    {
        $type = new \Harvest\Type\Decimal;
        $this->assertEquals('10.00', $type->unmarshal(10));
        $this->assertEquals('105.99', $type->unmarshal(105.99));
    }
    
    public function testMarshalWithWeirdValues() {
        $this->setExpectedException('Harvest\Exception\HarvestException');
        
        $type = new \Harvest\Type\Decimal;
        $type->marshal('potato');
    }
}