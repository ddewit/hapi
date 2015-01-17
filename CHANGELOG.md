# Hapi release notes

Welcome & thanks for using Hapi!



## 2.0 release - under development

This release marks a new era of Hapi. It is a almost full rewrite of the original library to reduce code complexity and improve maintainability.

### Notable changes and new features

 - A new API to fetch/write objects, instead of using methods like `$harvestApi->getClient(123)`, we're now using `$harvestApi->api('client')->get(123)`. This was done to improve memory usage and reduce complexity.
 - Hapi now handles type (un)marshaling for you. This means it'll return a nice `DateTime` object when your accessing properties like `created_at`.
 - We've improved our test code coverage to about 90% and 70% for our main classes (`HarvestApi` and `AbstractModel`).

### Migrating to 2.0 from 0.1

 - Updating calls to the API in your application is nessecary, as the old methods we're directly removed. Please refer to the example in `README.md` to see an updated example.
 - Any code in your application that does some sort of type casting when reading from and writing to the API can be removed.



## 0.1 release

This release is intented to provide a stable reference point for developers wanting to work on production-level applications that use Hapi.

### Notable changes and new features

 - No new features were introduced.
 - The library as written by Matthew John Denton, was converted to use PSR-0 with proper namespacing.
 - Hapi is now available on Packagist/installable via Composer.
 - Hapi now features a set of basic unit tests.
