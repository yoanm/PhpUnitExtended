# Yoanm Tests Strategy compliance
>*See [there](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md)*

 * [How to be compliant ?](#how-to-be-compliant)
 * [Tests strategy rules validated](#rules-validated)
  * [**Strict mode - fails if - risky tests**](#rules-validated-rule-1)
  * [**Real coverage - risky tests  does not count in coverage**](#rules-validated-rule-2)

<a name="how-to-be-compliant"></a>
## How to be compliant ?

<a name="how-to-be-compliant-config-file"></a>
### Configuration file 
*Advisable way*

```xml
<?xml version="1.0" encoding="UTF-8"?>

<!-- https://phpunit.de/manual/current/en/appendixes.configuration.html -->
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
  xsi:noNamespaceSchemaLocation="http://schema.phpunit.de/4.8/phpunit.xsd"
  beStrictAboutOutputDuringTests="true"
  backupGlobals="true"
  beStrictAboutChangesToGlobalState="true"
  beStrictAboutTestsThatDoNotTestAnything="true"
>
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\TestsStrategyListener"/>
  </listeners>
```

<a name="how-to-be-compliant-command-line"></a>
### Alternative

You can also use this command line : `phpunit -c phpunit.xml --disallow-test-output --strict-global-state --report-useless-tests`

In this case : 
 * `phpunit.xml` file must contains the `listeners` node described in [Configuration file section](#how-to-be-compliant-config-file).
 * Either 

  * `phpunit.xml` file must contains the `backupGlobals` options described in [Configuration file section](#how-to-be-compliant-config-file)

  * All tests must have the `@backupGlobals` annotation (prefer to use first option, easier to maintain)

<a name="rules-validated"></a>
## [Tests strategy rules](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules) validated

<a name="rules-validated-rule-1"></a>
  * [Strict mode - fails if - risky tests](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-strict-mode-fails-if-risky-tests)
    * Requires
      * `beStrictAboutOutputDuringTests="true"` (or `--disallow-test-output`)
      * `beStrictAboutChangesToGlobalState="true"` (or `--strict-global-state`) with `backupGlobals="true"` (or use `@backupGlobals enabled` in the test)
      * `beStrictAboutTestsThatDoNotTestAnything="true"` (or `--report-useless-tests`)
<a name="rules-validated-rule-2"></a>
  * [Real coverage - risky tests  does not count in coverage](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-real-coverage-risky-tests) for some specific kinds of risky test   
     * Requires `beStrictAboutOutputDuringTests="true"` (or `--disallow-test-output`)

