# PhpUnitExtended
[![Scrutinizer Build Status](https://img.shields.io/scrutinizer/build/g/yoanm/PhpUnitExtended.svg?label=Scrutinizer)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/yoanm/PhpUnitExtended.svg?label=Code%20quality)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master) [![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/yoanm/PhpUnitExtended.svg?label=Coverage)](https://scrutinizer-ci.com/g/yoanm/PhpUnitExtended/?branch=master)

[![Travis Build Status](https://img.shields.io/travis/yoanm/PhpUnitExtended/master.svg?label=travis)](https://travis-ci.org/yoanm/PhpUnitExtended) [![PHP Versions](https://img.shields.io/badge/php-5.5%20%2F%205.6%20%2F%207.0-8892BF.svg)](https://php.net/)

[![Latest Stable Version](https://img.shields.io/packagist/v/yoanm/php-unit-extended.svg)](https://packagist.org/packages/yoanm/php-unit-extended)

Php library to extend PhpUnit
> :information_source: **See [Tests strategy compliance](./TESTS_STRATEGY_COMPLIANCE.md)**

 * [Install](#install)
 * [How to](#how-to)
  * [Convert test into risky test](#how-to-convert-to-risky-test)
    * [Test that output something](#how-to-convert-to-risky-test-test-with-output)
    * [Test that do not test anything](#how-to-convert-to-risky-test-test-tests-nothing)
    * [Test that manipulates globals](#how-to-convert-to-risky-test-test-manipulates-globals)
    * [Test that have coverage overflow](#how-to-convert-to-risky-test-test-with-coverage-overflow)
  * [Convert risky test into failed test](#how-to-risky-to-failed)
  * [Remove coverage generated by a risky test that have an output](#how-to-remove-coverage-risky-output)
 * [Contributing](#contributing)

# Install
```bash
composer require --dev yoanm/php-unit-extended
```

## How to

<a name="how-to-convert-to-risky-test"></a>
### Convert test into risky test
<a name="how-to-convert-to-risky-test-test-with-output"></a>
#### Test that output something
Use `beStrictAboutOutputDuringTests="true"` :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  beStrictAboutOutputDuringTests="true"
  >

  ...

</phpunit>
```

<a name="how-to-convert-to-risky-test-test-tests-nothing"></a>
#### Test that do not test anything
Use `beStrictAboutTestsThatDoNotTestAnything="true"` :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  beStrictAboutTestsThatDoNotTestAnything="true"
  >

  ...

</phpunit>
```

<a name="how-to-convert-to-risky-test-test-manipulates-globals"></a>
#### Test that manipulates globals
Use `beStrictAboutChangesToGlobalState="true"`

<a name="how-to-convert-to-risky-test-test-manipulates-globals-variables"></a>
##### For globals variables
Add `backupGlobals="true"` :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  beStrictAboutChangesToGlobalState="true"
  backupGlobals="true"
  >
  ...

</phpunit>
```

<a name="how-to-convert-to-risky-test-test-manipulates-globals-attributes"></a>
##### For static attributes
Add `backupGlobals="true"` :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  beStrictAboutChangesToGlobalState="true"
  backupStaticAttributes="true"
  >

  ...

</phpunit>
```

<a name="how-to-convert-to-risky-test-test-manipulates-globals-all"></a>
##### For both
Add `backupGlobals="true"` and `backupGlobals="true"` :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  beStrictAboutChangesToGlobalState="true"
  backupGlobals="true"
  backupStaticAttributes="true"
  >

  ...

</phpunit>
```

<a name="how-to-convert-to-risky-test-test-with-coverage-overflow"></a>
#### Test that have coverage overflow
Use `checkForUnintentionallyCoveredCode="true"` and `forceCoversAnnotation="true"` :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  
  checkForUnintentionallyCoveredCode="true"
  forceCoversAnnotation="true"
  >

  ...

</phpunit>
```

<a name="how-to-risky-to-failed"></a>
### Convert risky test into failed test
Use `TestsStrategyListener`  :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  >
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\TestsStrategyListener"/>
  </listeners>

  ...

</phpunit>
```

<a name="how-to-remove-coverage-risky-output"></a>
### Remove coverage generated by a risky test that have an output
Use `TestsStrategyListener`  :
```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  >
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\TestsStrategyListener"/>
  </listeners>

  ...

</phpunit>
```

# Contributing
See [contributing note](./CONTRIBUTING.md)
