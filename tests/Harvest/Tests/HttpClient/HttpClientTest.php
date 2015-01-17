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

    public function testParseItemWithClient() {
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
        // TODO: do some assertions on the types as well
    }

    public function testParseItemWithProject() {
        $http = new \Harvest\HttpClient\HttpClient;

        // example response from /clients/id
        $xml = '<?xml version="1.0" encoding="UTF-8"?>
                <project>
                  <name>SuprGlu</name>
                  <id type="integer">1</id>
                  <client-id type="integer">2</client-id>
                  <code>HA-0001</code>
                  <active type="boolean">true</active>
                  <notes nil="true"/>
                  <billable type="boolean">false</billable>
                  <bill-by>none</bill-by>
                  <cost-budget type="decimal">1000.50</cost-budget>
                  <cost-budget-include-expenses type="boolean">false</cost-budget-include-expenses>
                  <hourly-rate nil="true"/>
                  <budget-by>project</budget-by>
                  <budget type="decimal">40.0</budget>
                  <notify-when-over-budget type="boolean">true</notify-when-over-budget>
                  <over-budget-notification-percentage type="decimal">80.0</over-budget-notification-percentage>
                  <over-budget-notified-at nil="true"/>
                  <show-budget-to-all type="boolean">true</show-budget-to-all>
                  <created-at type="datetime">2008-04-09T12:07:56Z</created-at>
                  <updated-at type="datetime">2008-04-09T12:07:56Z</updated-at>
                  <hint-earliest-record-at type="date">2006-01-04</hint-earliest-record-at>
                  <hint-latest-record-at type="date">2007-06-06</hint-latest-record-at>
                </project>';

        $parsed = $http->parseItem($xml);

        $this->assertInstanceOf('Harvest\Model\Project', $parsed);
        // TODO: do some assertions on the types as well
    }
}
