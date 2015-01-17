<?php

namespace Harvest\Tests\HttpClient;

use Harvest;

class HttpClientTest extends \PHPUnit_Framework_TestCase
{
    public function testDefaultHeaders() {
        $http = new \Harvest\HttpClient\HttpClient;
        $http->clearHeaders();
        $this->assertEquals(array(
            'User-Agent: PHP Wrapper Library for Harvest API',
            'Accept: application/xml',
            'Content-Type: application/xml',
            'Authorization: Basic Og==',
       ), \PHPUnit_Framework_Assert::readAttribute($http, 'headers'));
    }

    public function testSetHeaders() {
        $http = new \Harvest\HttpClient\HttpClient;
        $http->setHeaders(array('Foo: Bar'));
        $this->assertEquals(array('Foo: Bar'), \PHPUnit_Framework_Assert::readAttribute($http, 'headers'));
    }

    public function testParseItem() {
        $http = new \Harvest\HttpClient\HttpClient;

        // example response from /clients/id
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <client>
                  <id type="integer">1</id>
                  <name>Lightyear, Inc.</name>
                  <active type="boolean">true</active>
                  <currency>Euro - EUR</currency>
                  <highrise-id type="integer" nil="true"/>
                  <cache-version type="integer">123456</cache-version>
                  <updated-at type="dateTime">2014-06-13T10:15:07Z</updated-at>
                  <created-at type="dateTime">2010-04-20T08:02:52Z</created-at>
                  <currency-symbol>€</currency-symbol>
                  <details></details>
                  <default-invoice-timeframe nil="true"/>
                  <last-invoice-kind>free_form</last-invoice-kind>
                </client>';

        $parsed = $http->parseItem($xml);

        $this->assertInstanceOf('Harvest\Model\Client', $parsed);
    }
}
