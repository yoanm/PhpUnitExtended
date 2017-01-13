<?php
namespace Yoanm\PhpUnitExtended\Listener;

/**
 * @see https://github.com/yoanm/Readme/blob/master/TESTS_STRATEGY.md#rules-strict-mode-fails-if-risky-tests
 * Will convert a risky test regarding following option to failure
 *  =>phpunit process will return a failed result at end
 *
 * List of managed options :
 * - beStrictAboutOutputDuringTests / --report-useless-tests
 * - checkForUnintentionallyCoveredCode / --strict-coverage
 * - beStrictAboutTestsThatDoNotTestAnything / --disallow-test-output
 * - beStrictAboutChangesToGlobalState / --strict-global-state
 *
 * @see https://github.com/yoanm/Readme/blob/master/TESTS_STRATEGY.md#rules-real-coverage-risky-tests
 * Risky tests will be managed as not executed tests and so, code coverage generated by them will be removed
 *  => Allow failure based on coverage
 */
class TestsStrategyListener extends \PHPUnit_Framework_BaseTestListener
{
    /**
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception              $e
     * @param float                   $time
     */
    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        /* Must be PHPUnit_Framework_TestCase instance to have access tp "getTestResultObject" method */
        if ($test instanceof \PHPUnit_Framework_TestCase) {
            $testResult = $test->getTestResultObject();
            switch (true) {
                /* beStrictAboutOutputDuringTests */
                case $e instanceof \PHPUnit_Framework_OutputError:
                    $reason = 'No output during test';
                    /** Ack - remove coverage */
                    $this->removeCoverageFor($test);
                    /** END Ack */
                    break;
                /* checkForUnintentionallyCoveredCode */
                case $e instanceof \PHPUnit_Framework_UnintentionallyCoveredCodeError:
                    $reason = 'Executed code must be defined with @covers and @uses annotations';
                    break;
                default:
                    /* beStrictAboutTestsThatDoNotTestAnything (no specific exception) */
                    /* beStrictAboutChangesToGlobalState (no specific exception) */
                    $reason = 'Risky test';
                    break;
            }
            $testResult->addFailure(
                $test,
                new \PHPUnit_Framework_AssertionFailedError(
                    sprintf(
                        "Strict mode - %s :\n%s",
                        $reason,
                        $e->getMessage()
                    )
                ),
                $time
            );
        }
    }

    /**
     * @param \PHPUnit_Framework_TestCase $test
     */
    protected function removeCoverageFor(\PHPUnit_Framework_TestCase $test)
    {
        $coverage = $test->getTestResultObject()->getCodeCoverage();
        if (null !== $coverage) {
            $id = sprintf('%s::%s', get_class($test), $test->getName());
            $data = $coverage->getData();
            foreach ($data as $fileName => $lineData) {
                foreach ($lineData as $lineNumber => $testIdList) {
                    if (null !== $testIdList) {
                        foreach ($testIdList as $testIdKey => $testId) {
                            if ($id === $testId) {
                                unset($data[$fileName][$lineNumber][$testIdKey]);
                            }
                        }
                    }
                }
            }
            $coverage->setData($data);
        }
    }
}
