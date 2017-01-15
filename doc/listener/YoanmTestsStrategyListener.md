# YoanmTestsStrategyListener

Used with the [configuration reference](#configuration-reference), it will allow to have PhpUnit tests compliant with [Yoanm Tests strategy](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md)

 * [Tests strategy rules validated](#rules-validated)
   * [Strict mode - fails if - risky tests](#rules-validated-risky-to-failed)
     * [**Test that have an output**](#rules-validated-risky-to-failed-risky-with-output)
     * [**Test that manipulates globals variables**](#rules-validated-risky-to-failed-risky-that-manipulates-globals-variable)
     * [**Test that do not test anything**](#rules-validated-risky-to-failed-risky-that-test-nothing)
   * [Real coverage - risky tests  does not count in coverage](#rules-validated-no-coverage-for-risky)
       * [Test that have an output](#rules-validated-no-coverage-for-risky-with-output)
 * [Configuration reference](#configuration-reference)
 * [Advises](#advises)

<a name="rules-validated"></a>
## [Tests strategy rules](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules) validated

All following rules rely on [RiskyToFailedListener](./RiskyToFailedListener.md) and [StrictCoverageListener](./StrictCoverageListener.md) behaviors

<a name="rules-validated-risky-to-failed"></a>
  * [Strict mode - fails if - risky tests](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-strict-mode-fails-if-risky-tests)
<a name="rules-validated-risky-to-failed-risky-with-output"></a>
    * [**Test that have an output**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-output)
      * See [RiskyToFailedListener](./RiskyToFailedListener.md#in-the-box-risky-to-failed-risky-test-test-with-output)
<a name="rules-validated-risky-to-failed-risky-that-manipulates-globals-variable"></a>
    * [**Test that manipulates globals variables**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-manipulate-globals)
      * See [RiskyToFailedListener](./RiskyToFailedListener.md#in-the-box-risky-to-failed-risky-test-test-manipulates-globals-variables)
<a name="rules-validated-risky-to-failed-risky-that-test-nothing"></a>
    * [**Test that do not test anything**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-test-nothing)
      * See [RiskyToFailedListener](./RiskyToFailedListener.md#in-the-box-risky-to-failed-risky-test-test-tests-nothing)
<a name="rules-validated-risky-to-failed"></a>
  * [Real coverage - risky tests  does not count in coverage](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-real-coverage-risky-tests) for some specific kinds of risky test   
<a name="rules-validated-no-coverage-for-risky-with-output"></a>
    * [**Test that have an output**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-output)
      * See [StrictCoverageListener](./StrictCoverageListener.md#in-the-box-remove-coverage-risky-output)

<a name="configuration-reference"></a>
## Configuration reference

```xml
<phpunit
  beStrictAboutOutputDuringTests="true"
  beStrictAboutChangesToGlobalState="true"
  backupGlobals="true"
  beStrictAboutTestsThatDoNotTestAnything="true"
>
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\YoanmTestsStrategyListener"/>
  </listeners>
</phpunit>
```

## Advises

[Tests documentation](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-test-documentation) : Enable ["RiskyToFailed - Test that have unexpected coverage"](.//RiskyToFailedListener.md#in-the-box-risky-to-failed-risky-test-test-with-unexpected-coverage) to convert a test into a failed test when an `@uses` is missing in a test. Useful for strict test documentation.
