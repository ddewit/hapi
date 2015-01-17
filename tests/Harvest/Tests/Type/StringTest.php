<?php

namespace Harvest\Tests\Type;

use Harvest;

class StringTest extends \PHPUnit_Framework_TestCase
{
    public function testMarshal()
    {
        $type = new \Harvest\Type\String;
        $this->assertEquals('foo', $type->marshal('foo'));
        $this->assertEquals('', $type->marshal(null));
    }
    
    public function testUnmarshal()
    {
        $type = new \Harvest\Type\String;
        $this->assertEquals('foo', $type->unmarshal('foo'));
    }
}