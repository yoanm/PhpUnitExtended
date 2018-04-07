<?php
namespace Yoanm\PhpUnitExtended\Listener;

use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestListenerDefaultImplementation;

/**
 * @see doc/listener/StrictCoverageListener.md
 */
class StrictCoverageListener implements TestListener
{
    use TestListenerDefaultImplementation;

    /**
     * @param Test $test
     * @param \Exception              $e
     * @param float                   $time
     */
    public function addRiskyTest(Test $test, \Exception $e, $time)
    {
        if (/* Must be PHPUnit_Framework_TestCase instance to have access to "getTestResultObject" method */
            $test instanceof TestCase
            && $e instanceof OutputError
        ) {
            $this->removeCoverageFor($test);
        }
    }

    /**
     * @param TestCase $test
     */
    protected function removeCoverageFor(TestCase $test)
    {
        $coverage = $test->getTestResultObject()->getCodeCoverage();
        if (null !== $coverage) {
            $id = $test->toString();
            $data = $coverage->getData();
            foreach ($data as $fileName => $lineData) {
                foreach ($lineData as $lineNumber => $testIdList) {
                    if (is_array($testIdList)) {
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
