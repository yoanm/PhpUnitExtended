# PhpUnitExtended
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/PhpUnitExtended.svg?label=Scrutinizer)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/PhpUnitExtended.svg?label=Code%20quality)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/yoanm/PhpUnitExtended.svg?label=Coverage)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master)

[![Travis Build Status](https://img.shields.io/travis/yoanm/PhpUnitExtended/master.svg?label=travis)](https://travis-ci.org/yoanm/PhpUnitExtended) [![PHP Versions](https://img.shields.io/badge/php-5.5%20%2F%205.6%20%2F%207.0-8892BF.svg)](https://php.net/)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)

Php library to extend PhpUnit

# Install
```bash
composer require yoanm/php-unit-extended
```

> :information_source: **[Yoanm Tests strategy](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md) compliant**

 * [Configuration reference](#configuration-reference)
 * [Tests strategy rules validated by configuration reference](#rules-validated)
  * [Mandatory](#rules-validated-mandatory)
    * [Listeners](#rules-validated-mandatory-listeners)
      * [TestStrategyListener](#rules-validated-mandatory-listeners-TestsStrategyListener)
        * [**Strict mode - fails if - risky tests**](#rules-validated-mandatory-listeners-TestsStrategyListener-rule-1)
        * [**Real coverage - risky tests  does not count in coverage**](#rules-validated-mandatory-listeners-TestsStrategyListener-rule-1)

## Configuration reference
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  beStrictAboutOutputDuringTests="true"
  beStrictAboutChangesToGlobalState="true"
  beStrictAboutTestsThatDoNotTestAnything="true"
>
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\TestsStrategyListener"/>
  </listeners>
```

<a name="rules-validated"></a>
## [Tests strategy rules](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules) validated by [configuration reference](#configuration-reference)

<a name="rules-validated-mandatory"></a>
### Mandatory

<a name="rules-validated-mandatory-listeners"></a>
#### Listeners
<a name="rules-validated-mandatory-listeners-TestsStrategyListener"></a>
 * [TestsStrategyListener](./src/Yoanm/PhpUnitExtended/Listener/TestsStrategyListener.php)

 Listener will validate following mandatory rule
<a name="rules-validated-mandatory-listeners-TestsStrategyListener-rule-1"></a>
  * [Strict mode - fails if - risky tests](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-strict-mode-fails-if-risky-tests)
    * Requires
      * `beStrictAboutOutputDuringTests="true"`
      * `beStrictAboutChangesToGlobalState="true"`
      * `beStrictAboutTestsThatDoNotTestAnything="true"`
<a name="rules-validated-mandatory-listeners-TestsStrategyListener-rule-1"></a>
  * [Real coverage - risky tests  does not count in coverage](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-real-coverage-risky-tests) for some specific kinds of risky test   
     * Requires `beStrictAboutOutputDuringTests="true"`

# Contributing
See [contributing note](./CONTRIBUTING.md)
