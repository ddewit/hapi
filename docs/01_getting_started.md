#HaPi – PHP Wrapper for the Harvest API

[![Build Status](https://travis-ci.org/gridonic/hapi.svg?branch=master)](https://travis-ci.org/gridonic/hapi)
[![Code Climate](https://codeclimate.com/github/gridonic/hapi/badges/gpa.svg)](https://codeclimate.com/github/gridonic/hapi)
[![Dependency Status](https://www.versioneye.com/user/projects/54b59bf305064657eb0000c1/badge.svg?style=flat)](https://www.versioneye.com/user/projects/54b59bf305064657eb0000c1)

## Install

The recommended way is to install the library via [Composer](http://getcomposer.org):

    composer require gridonic/hapi:~2.0

## Requirements

 * PHP 5.3+ (unit tests are ran against 5.3, 5.4, 5.5 and 5.6) or HHVM
 * This library does not have any external dependencies.

## Usage

HaPi uses a couple of patterns to perform CRUD operations. Almost all APIs in the library expose at least a `all()`, `get()`, `create()`, `update()` and `delete()` method. Some APIs [expose extra methods](02_apis_and_methods.md).

### Get all entries

```php
<?php

$harvest = new \Harvest\HarvestApi;
$harvest->authenticate('j.doe@example.com', 'mypassword');
$harvest->setAccount('myaccount');

$response = $harvest->api('Client')->all(); # you can pass an optional updated_since (\DateTime instance)
var_dump($response->data);
```

### Get a single entry

```php
<?php

$harvest = new \Harvest\HarvestApi;
$harvest->authenticate('j.doe@example.com', 'mypassword');
$harvest->setAccount('myaccount');

$response = $harvest->api('Client')->get(123456);
var_dump($response->data);
```

### Create a new entry

```php
<?php

$harvest = new \Harvest\HarvestApi;
$harvest->authenticate('j.doe@example.com', 'mypassword');
$harvest->setAccount('myaccount');

$client = new \Harvest\Model\Client;
$client->set('name', 'Lightyear, Inc.'); # check the docs to see which properties are required for each API

$response = $harvest->api('Client')->create($client);
var_dump($response->data);
```

### Update an entry

```php
<?php

$harvest = new \Harvest\HarvestApi;
$harvest->authenticate('j.doe@example.com', 'mypassword');
$harvest->setAccount('myaccount');

$client = $harvest->api('Client')->get(123456);
$client->set('name', 'Buzz Lightyear, Inc.');

$response = $harvest->api('Client')->update($client);
var_dump($response->data);
```

### Delete an entry

```php
<?php

$harvest = new \Harvest\HarvestApi;
$harvest->authenticate('j.doe@example.com', 'mypassword');
$harvest->setAccount('myaccount');

$response = $harvest->api('Client')->delete(123456);
var_dump($response->data);
```

## Run the test suite

The goal is to have the library supported 100% with unit tests. We're heading in the right direction, but we're not there yet. You can run the tests by running:

    phpunit

There are a couple of tests which require a valid Harvest account, because it actually reads/writes data to Harvest. These are in the `internet` group. For this to work, you will have to create a local copy of ```harvest_api_config.json``` by copying the provided ```harvest_api_config.json.dist``` and providing your own Harvest account credentials. In order to exclude the tests that require a valid Harvest account and internet connection, invoke the test runner as follows:

    phpunit --exclude-group=internet

## License

Hapi is licensed under the GPL-3 License - see the `LICENSE` file for details

## Acknowledgements

This version of the library is a rewrite that uses composer and proper PSR-0 standard
for autoloading. The original version of the library was written by Matthew John Denton
and can be downloaded from http://labs.mdbitz.com/harvest-api

## Contributing

Contributions to the project are more than welcome. You can contribute:

 * By writing docs; it's of vital importance that these are as accurate as possible and help users;
 * By writing tests; help us reach our goal of a 100% unit tested library;
 * By reporting bugs; please create an issue in the Issue Tracker here at GitHub. Kudos if you also prepare a PR with test.