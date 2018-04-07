<?php
namespace Yoanm\PhpUnitExtended\Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\UnintentionallyCoveredCodeError;

/**
 * @see doc/listener/StrictCoverageListener.md
 */
class RiskyToFailedListener implements TestListener
{
    use TestListenerDefaultImplementation;
    /**
     * @param Test $test
     * @param \Exception              $e
     * @param float                   $time
     */
    public function addRiskyTest(Test $test, \Exception $e, $time)
    {
        /* Must beTestCase instance to have access to "getTestResultObject" method */
        if ($test instanceof TestCase) {
            $reason = $this->processEvent($test, $e);
            if (null !== $reason) {
                $test->getTestResultObject()->addFailure(
                    $test,
                    new AssertionFailedError(
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
     * @param TestCase $test
     * @param \Exception                  $e
     *
     * @return null|string
     */
    protected function processEvent(TestCase $test, \Exception $e)
    {
        $reason = null;
        switch (true) {
            /* beStrictAboutOutputDuringTests="true" */
            case $e instanceof OutputError:
                $reason = 'No output during test';
                break;
            /* checkForUnintentionallyCoveredCode="true" */
            case $e instanceof UnintentionallyCoveredCodeError:
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
