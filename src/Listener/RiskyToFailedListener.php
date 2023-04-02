<?php
namespace Yoanm\PhpUnitExtended\Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\CoveredCodeNotExecutedException;
use PHPUnit\Framework\InvalidCoversTargetException;
use PHPUnit\Framework\MissingCoversAnnotationException;
use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;
use PHPUnit\Framework\TestResult;
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
     * @param Test       $test
     * @param \Throwable $exception
     * @param $time
     */
    protected function addErrorIfNeeded(Test $test, \Throwable $exception, $time)
    {
        /* Must be TestCase instance to have access to "getTestResultObject" method */
        if ($test instanceof TestCase) {
            if (!$test->getTestResultObject()) {
                $test->setTestResultObject(new TestResult());
            }
            $test->getTestResultObject()->addFailure(
                $test,
                new AssertionFailedError(
                    sprintf(
                        "Strict mode - %s :\n%s",
                        $this->getErrorReason($exception),
                        $exception->getMessage()
                    )
                ),
                $time
            );
        }
    }

    protected function getErrorReason(\Throwable $exception): string
    {
        if ($exception instanceof OutputError) {
            /* beStrictAboutOutputDuringTests="true" */
            return 'No output during test';
        } elseif ($exception instanceof UnintentionallyCoveredCodeError
            || $exception instanceof InvalidCoversTargetException
        ) {
            /* checkForUnintentionallyCoveredCode="true" */
            return 'Executed code must be defined with @covers and @uses annotations';
        } elseif (str_contains($exception->getMessage(), '--- Global variables before the test')) {
            /* beStrictAboutChangesToGlobalState="true" (no specific exception) for globals */
            return 'No global variable manipulation during test';
        } elseif (str_contains($exception->getMessage(), '--- Static attributes before the test')) {
            /* beStrictAboutChangesToGlobalState="true" (no specific exception) for static var */
            /* Only when beStrictAboutChangesToGlobalState="true" */
            return 'No static attribute manipulation during test';
        } elseif (str_contains($exception->getMessage(), 'This test did not perform any assertions')) {
            /* beStrictAboutTestsThatDoNotTestAnything="true" (no specific exception) */
            return 'No test that do not test anything';
        } elseif ($exception instanceof CoveredCodeNotExecutedException
            || preg_match('#"@covers [^"]+" is invalid#', $exception->getMessage())
        ) {
            /* forceCoversAnnotation="true" (no specific exception) */
            return 'Only executed code must be defined with @covers and @uses annotations';
        } elseif ($exception instanceof MissingCoversAnnotationException
            || str_contains(
                $exception->getMessage(),
                'This test does not have a @covers annotation but is expected to have one'
            )
        ) {
            /* forceCoversAnnotation="true" (no specific exception) */
            return 'Missing @covers or @coversNothing annotation';
        }

        // Always return an error even if it's not a known/managed error
        return $exception->getMessage();
    }
}
