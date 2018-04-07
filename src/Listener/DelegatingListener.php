<?php
namespace Yoanm\PhpUnitExtended\Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;

/**
 * Simple listener delegator
 */
class DelegatingListener implements TestListener
{
    /** TestListener[] */
    private $listenerList = [];

    /**
     * {@inheritdoc}
     */
    public function addListener(TestListener $listener) : void
    {
        $this->listenerList[] = $listener;
    }

    /**
     * @return TestListener[]
     */
    public function getListenerList()
    {
        return $this->listenerList;
    }

    /**
     * {@inheritdoc}
     */
    public function addError(Test $test, \Throwable $e, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->addError($test, $e, $time);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addWarning(Test $test, Warning $e, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->addWarning($test, $e, $time);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addFailure(Test $test, AssertionFailedError $e, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->addFailure($test, $e, $time);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addIncompleteTest(Test $test, \Throwable $e, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->addIncompleteTest($test, $e, $time);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addRiskyTest(Test $test, \Throwable $e, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->addRiskyTest($test, $e, $time);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function addSkippedTest(Test $test, \Throwable $e, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->addSkippedTest($test, $e, $time);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function startTestSuite(TestSuite $suite) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->startTestSuite($suite);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function endTestSuite(TestSuite $suite) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->endTestSuite($suite);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function startTest(Test $test) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->startTest($test);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function endTest(Test $test, float $time) : void
    {
        foreach ($this->listenerList as $listener) {
            $listener->endTest($test, $time);
        }
    }
}
