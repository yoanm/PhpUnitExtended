# PhpUnitExtended

Php library to extends PhpUnit

> :information_source: **[Yoanm Tests strategy](https://github.com/yoanm/Readme/blob/master/TESTS_STRATEGY.md) compliant**

 * [Configuration reference](#configuration-reference)
 * [Tests strategy rules validated by configuration reference](#rules-validated)
  * [Mandatory](#rules-validated-mandatory)
    * [Listeners](#rules-validated-mandatory-listeners)
      * [TestStrategyListener](#rules-validated-mandatory-listeners-TestsStrategyListener)
        * [**Strict mode - fails if - risky tests**](#rules-validated-mandatory-listeners-TestsStrategyListener-rule-1)
        * [**Real coverage - risky tests  does not count in coverage**](#rules-validated-mandatory-listeners-TestsStrategyListener-rule-1)
  
<a name="rules-validated"></a>
## [Tests strategy rules](https://github.com/yoanm/Readme/blob/master/TESTS_STRATEGY.md#rules) validated by [configuration reference](#configuration-reference)

<a name="rules-validated-mandatory"></a>
### Mandatory

<a name="rules-validated-mandatory-listeners"></a>
#### Listeners
<a name="rules-validated-mandatory-listeners-TestsStrategyListener"></a>
 * [TestsStrategyListener](./src/Yoanm/PhpUnitExtended/Listener/TestsStrategyListener.php)
   
 Listener will validate following mandatory rule
<a name="rules-validated-mandatory-listeners-TestsStrategyListener-rule-1"></a>
  * [Strict mode - fails if - risky tests](https://github.com/yoanm/Readme/blob/master/TESTS_STRATEGY.md#rules-strict-mode-fails-if-risky-tests)
    * Requires
      * `beStrictAboutOutputDuringTests="true"` 
      * `beStrictAboutChangesToGlobalState="true"`
      * `beStrictAboutTestsThatDoNotTestAnything="true"` 
<a name="rules-validated-mandatory-listeners-TestsStrategyListener-rule-1"></a>
  * [Real coverage - risky tests  does not count in coverage](https://github.com/yoanm/Readme/blob/master/TESTS_STRATEGY.md#rules-real-coverage-risky-tests) for some specific kinds of risky test   
     * Requires `beStrictAboutOutputDuringTests="true"`
