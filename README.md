# PhpUnitExtended
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/PhpUnitExtended.svg?label=Scrutinizer)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/PhpUnitExtended.svg?label=Code%20quality)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/yoanm/PhpUnitExtended.svg?label=Coverage)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master)

[![Travis Build Status](https://img.shields.io/travis/yoanm/PhpUnitExtended/master.svg?label=travis)](https://travis-ci.org/yoanm/PhpUnitExtended) [![PHP Versions](https://img.shields.io/badge/php-5.5%20%2F%205.6%20%2F%207.0-8892BF.svg)](https://php.net/)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)

Php library to extend PhpUnit
> :information_source: **See [Tests strategy compliance](./TESTS_STRATEGY_COMPLIANCE.md)**

# Install
```bash
composer require --dev yoanm/php-unit-extended
```

## Configuration reference
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  <!-- Required if you want to convert test that output something into risky test -->
  beStrictAboutOutputDuringTests="true"
  
  <!-- 
  Required if you want to convert test that manipulates globals into risky test 
  Requires at least "backupGlobals" or "backupStaticAttributes" (depending of what you want to detect)
  -->
  beStrictAboutChangesToGlobalState="true"
    <!-- Required if you want to detect globals variables manipulation -->
  backupGlobals="true"
    <!-- Required if you want to detect static attributes manipulation  -->
  backupStaticAttributes="true"
    
  <!-- Required if you want to convert test that do not test anything into risky test -->
  beStrictAboutTestsThatDoNotTestAnything="true"

  <!-- 
  The two following options are required if you want to convert test that have coverage overflow 
  into risky test. Requires "forceCoversAnnotation"
  -->
  checkForUnintentionallyCoveredCode="true"
    <!-- Required to detect coverage overflow -->
  forceCoversAnnotation="true"
>
  <!-- 
  Required if you want to :
    - Convert risky tests into failed tests
    - Remove coverage from a risky test that output something
  -->
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\TestsStrategyListener"/>
  </listeners>
```

# Contributing
See [contributing note](./CONTRIBUTING.md)
