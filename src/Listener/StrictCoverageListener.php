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
     * {@inheritdoc}
     */
    public function addRiskyTest(Test $test, \Throwable $exception, float $time) : void
    {
        /* Must be PHPUnit\Framework\TestCase instance to have access to "getTestResultObject" method */
        if ($test instanceof TestCase && $exception instanceof OutputError) {
            $this->removeCoverageFor($test);
        }
    }

    protected function removeCoverageFor(TestCase $test)
    {
        $coverage = $test->getTestResultObject()->getCodeCoverage();
        if (null !== $coverage) {
            $id = $test->toString();
            $data = $coverage->getData()->lineCoverage();
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
            $coverage->getData()->setLineCoverage($data);
        }
    }
}
