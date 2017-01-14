<?php
namespace Yoanm\PhpUnitExtended\Listener;

/**
 * @see https://github.com/yoanm/PhpUnitExtended/doc/listener/StrictCoverageListener.md
 */
class RiskyToFailedListener extends \PHPUnit_Framework_BaseTestListener
{
    /**
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception              $e
     * @param float                   $time
     */
    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        /* Must be PHPUnit_Framework_TestCase instance to have access to "getTestResultObject" method */
        if ($test instanceof \PHPUnit_Framework_TestCase) {
            $reason = $this->processEvent($test, $e);
            if (null !== $reason) {
                $test->getTestResultObject()->addFailure(
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
    }

    /**
     * @param \PHPUnit_Framework_TestCase $test
     * @param \Exception                  $e
     *
     * @return null|string
     */
    protected function processEvent(\PHPUnit_Framework_TestCase $test, \Exception $e)
    {
        $reason = null;
        switch (true) {
            /* beStrictAboutOutputDuringTests="true" */
            case $e instanceof \PHPUnit_Framework_OutputError:
                $reason = 'No output during test';
                break;
            /* checkForUnintentionallyCoveredCode="true" */
            case $e instanceof \PHPUnit_Framework_UnintentionallyCoveredCodeError:
                $reason = 'Executed code must be defined with @covers and @uses annotations';
                break;
            default:
                if (preg_match('#\-\-\- Global variables before the test#', $e->getMessage())) {
                    /* beStrictAboutChangesToGlobalState="true" (no specific exception) for globals */
                    $reason = 'No global variable manipulation during test';
                } elseif (preg_match('#\-\-\- Static attributes before the test#', $e->getMessage())) {
                    /* beStrictAboutChangesToGlobalState="true" (no specific exception) for static var */
                    /* Only when beStrictAboutChangesToGlobalState="true" */
                    $reason = 'No static attribute manipulation during test';
                } elseif (preg_match('#This test did not perform any assertions#', $e->getMessage())) {
                    /* beStrictAboutTestsThatDoNotTestAnything="true" (no specific exception) */
                    $reason = 'No test that do not test anything';
                }
                break;
        }
        return $reason;
    }
}
