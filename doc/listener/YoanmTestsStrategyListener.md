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


## In the box

<a name="rules-validated"></a>
## [Tests strategy rules](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules) validated

<a name="rules-validated-risky-to-failed"></a>
  * [Strict mode - fails if - risky tests](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-strict-mode-fails-if-risky-tests)
<a name="rules-validated-risky-to-failed-risky-with-output"></a>
    * [**Test that have an output**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-output)
<a name="rules-validated-risky-to-failed-risky-that-manipulates-globals-variable"></a>
    * [**Test that manipulates globals variables**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-manipulate-globals)
<a name="rules-validated-risky-to-failed-risky-that-test-nothing"></a>
    * [**Test that do not test anything**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-test-nothing)
<a name="rules-validated-risky-to-failed"></a>
  * [Real coverage - risky tests  does not count in coverage](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-real-coverage-risky-tests) for some specific kinds of risky test   
<a name="rules-validated-no-coverage-for-risky-with-output"></a>
    * [**Test that have an output**](https://github.com/yoanm/Readme/blob/master/strategy/tests/README.md#rules-risky-tests-output)

<a name="configuration-reference"></a>
## Configuration reference

```xml
<phpunit>
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\TestsStrategyListener"/>
  </listeners>
</phpunit>
```
