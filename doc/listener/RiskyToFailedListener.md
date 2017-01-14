# RiskyToFailedListener

 * [In the box](#in-the-box)
   * [Convert risky test into failed test](#in-the-box-risky-to-failed)
     * [Test that output something](#in-the-box-risky-to-failed-risky-test-test-with-output)
     * [Test that do not test anything](#in-the-box-risky-to-failed-risky-test-test-tests-nothing)
     * [Test that manipulates globals](#in-the-box-risky-to-failed-risky-test-test-manipulates-globals)
     * [Test that have coverage overflow](#in-the-box-risky-to-failed-risky-test-test-with-coverage-overflow)
 * [Required configuration](#required-config)

*See [PhpUnit configuration reference](https://phpunit.de/manual/current/en/appendixes.configuration.html) and [PhpUnit Risky tests](https://phpunit.de/manual/current/en/risky-tests.html) for more information about a specific option*

## In the box

<a name="in-the-box-risky-to-failed"></a>
### Convert risky test into failed test

Listener will add a failure for each risky test listed below

<a name="in-the-box-risky-to-failed-risky-test-test-with-output"></a>
#### Test that output something

 * [Listener configuration](#required-config)
 * Add `beStrictAboutOutputDuringTests="true"` in the configuration file or use `--disallow-test-output` command line option

<a name="in-the-box-risky-to-failed-risky-test-test-tests-nothing"></a>
#### Test that do not test anything

 * [Listener configuration](#required-config)
 * Add `beStrictAboutTestsThatDoNotTestAnything="true"` in the configuration file or use `--report-useless-tests` command line option

<a name="in-the-box-risky-to-failed-risky-test-test-manipulates-globals"></a>
#### Test that manipulates globals

 * [Listener configuration](#required-config)
 * Add `beStrictAboutChangesToGlobalState="true"` in the configuration file or use `--strict-global-state` command line option

<a name="in-the-box-risky-to-failed-risky-test-test-manipulates-globals-variables"></a>
##### For globals variables

 * [Requirements described above](#in-the-box-risky-to-failed-risky-test-test-manipulates-globals)
 * Add `backupGlobals="true"` in the configuration file or add `@backupGlobals enabled` in the test

<a name="in-the-box-risky-to-failed-risky-test-test-manipulates-globals-attributes"></a>
##### For static attributes

 * [Requirements described above](#in-the-box-risky-to-failed-risky-test-test-manipulates-globals)
 * Add `backupStaticAttributes="true"` in the configuration file or add `@backupStaticAttributes enabled` in the test

<a name="in-the-box-risky-to-failed-risky-test-test-with-coverage-overflow"></a>
#### Test that have coverage overflow

 * [Listener configuration](#required-config)
 * Add `checkForUnintentionallyCoveredCode="true"` in the configuration file or use `--strict-coverage` command line option
 * Add `forceCoversAnnotation="true"` in the configuration file

<a name="required-config"></a>
## Required configuration

```xml
<phpunit>
  <listeners>
        <listener class="Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener"/>
  </listeners>
</phpunit>
```
