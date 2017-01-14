<?php
namespace Yoanm\PhpUnitExtended\Listener;

/**
 * @see https://github.com/yoanm/PhpUnitExtended/doc/listener/YoanmTestsStrategyListener.md
 */
class YoanmTestsStrategyListener implements \PHPUnit_Framework_TestListener
{
    /** \PHPUnit_Framework_TestListener[] */
    private $listenerList = [];

    public function __construct()
    {
        $this->listenerList[] = new RiskyToFailedListener();
        $this->listenerList[] = new StrictCoverageListener();
    }

    public function addError(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        foreach ($this->listenerList as $listener) {
            $listener->addError($test, $e, $time);
        }
    }

    public function addFailure(\PHPUnit_Framework_Test $test, \PHPUnit_Framework_AssertionFailedError $e, $time)
    {
        foreach ($this->listenerList as $listener) {
            $listener->addFailure($test, $e, $time);
        }
    }

    public function addIncompleteTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        foreach ($this->listenerList as $listener) {
            $listener->addIncompleteTest($test, $e, $time);
        }
    }

    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        foreach ($this->listenerList as $listener) {
            $listener->addRiskyTest($test, $e, $time);
        }
    }

    public function addSkippedTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        foreach ($this->listenerList as $listener) {
            $listener->addSkippedTest($test, $e, $time);
        }
    }

    public function startTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        foreach ($this->listenerList as $listener) {
            $listener->startTestSuite($suite);
        }
    }

    public function endTestSuite(\PHPUnit_Framework_TestSuite $suite)
    {
        foreach ($this->listenerList as $listener) {
            $listener->endTestSuite($suite);
        }
    }

    public function startTest(\PHPUnit_Framework_Test $test)
    {
        foreach ($this->listenerList as $listener) {
            $listener->startTest($test);
        }
    }

    public function endTest(\PHPUnit_Framework_Test $test, $time)
    {
        foreach ($this->listenerList as $listener) {
            $listener->endTest($test, $time);
        }
    }
}
