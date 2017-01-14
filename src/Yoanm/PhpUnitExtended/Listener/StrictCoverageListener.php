<?php
namespace Yoanm\PhpUnitExtended\Listener;

/**
 * @see https://github.com/yoanm/PhpUnitExtended/doc/listener/StrictCoverageListener.md
 */
class StrictCoverageListener extends \PHPUnit_Framework_BaseTestListener
{
    /**
     * @param \PHPUnit_Framework_Test $test
     * @param \Exception              $e
     * @param float                   $time
     */
    public function addRiskyTest(\PHPUnit_Framework_Test $test, \Exception $e, $time)
    {
        if (
            /* Must be PHPUnit_Framework_TestCase instance to have access to "getTestResultObject" method */
            $test instanceof \PHPUnit_Framework_TestCase
            && $e instanceof \PHPUnit_Framework_OutputError
        ) {
            $this->removeCoverageFor($test);
        }
    }

    /**
     * @param \PHPUnit_Framework_TestCase $test
     */
    protected function removeCoverageFor(\PHPUnit_Framework_TestCase $test)
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
