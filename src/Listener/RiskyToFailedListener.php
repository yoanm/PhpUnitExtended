<?php
namespace Yoanm\PhpUnitExtended\Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\UnintentionallyCoveredCodeError;
use PHPUnit\Framework\Warning;

/**
 * @see doc/listener/StrictCoverageListener.md
 */
class RiskyToFailedListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * {@inheritdoc}
     */
    public function addWarning(Test $test, Warning $e, float $time) : void
    {
        $this->addErrorIfNeeded($test, $e, $time);
    }

    /**
     * {@inheritdoc}
     */
    public function addRiskyTest(Test $test, \Throwable $e, float $time) : void
    {
        $this->addErrorIfNeeded($test, $e, $time);
    }

    /**
     * @param Test $test
     * @param \Throwable $e
     * @param $time
     */
    protected function addErrorIfNeeded(Test $test, \Throwable $e, $time)
    {
        /* Must be TestCase instance to have access to "getTestResultObject" method */
        if ($test instanceof TestCase && $test->getTestResultObject() !== null) {
            $reason = $this->getErrorReason($e);
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
     * @param \Throwable $e
     *
     * @return null|string
     */
    protected function getErrorReason(\Throwable $e)
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
                } elseif (preg_match('#"@covers [^"]+" is invalid#', $e->getMessage())) {
                    /* forceCoversAnnotation="true" (no specific exception) */
                    $reason = 'Only executed code must be defined with @covers and @uses annotations';
                }
                break;
        }

        return $reason;
    }
}
