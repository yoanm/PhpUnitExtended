<?php
namespace Technical\Integration\Yoanm\PhpUnitExtended\Listener;

use Prophecy\Argument;
use Technical\Integration\Yoanm\PhpUnitExtended\Mock\TestCaseMock;
use Yoanm\PhpUnitExtended\Listener\StrictCoverageListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\StrictCoverageListener
 */
class StrictCoverageListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var StrictCoverageListener */
    private $listener;

    const TEST_FILENAME = 'file_name';

    public function setUp()
    {
        $this->listener = new StrictCoverageListener();
    }

    /**
     * @dataProvider getCoverageDataProvider
     *
     * @param array $baseCoverageData
     */
    public function testCoverageRemoval(array $baseCoverageData)
    {
        $time = 0.3;

        /** @var TestCaseMock $test */
        $test = new TestCaseMock('test_name');
        /** @var \PHPUnit_Framework_TestResult $testResult */
        $testResult = new \PHPUnit_Framework_TestResult();
        /** @var \PHP_CodeCoverage_Filter $filter */
        $filter = new \PHP_CodeCoverage_Filter('./plop', 'plop', 'plop');
        /** @var \PHP_CodeCoverage $coverage */
        $coverage = new \PHP_CodeCoverage(null, $filter);
        /** @var \PHPUnit_Framework_OutputError $exception */
        $exception = new \PHPUnit_Framework_OutputError();


        $test->setTestResultObject($testResult);
        $testResult->setCodeCoverage($coverage);

        $testCoverageData = $baseCoverageData;
        $testCoverageData[self::TEST_FILENAME][0][] = $test->toString();
        $coverage->setData($testCoverageData);

        // Mandatory, else $coverage->getData() will return an empty array (see internal behavior)
        $filter->addFileToWhitelist('plop.plop');
        //$coverage->setAddUncoveredFilesFromWhitelist(false);

        $this->listener->addRiskyTest($test, $exception, $time);

        $expectedCoverageData = $baseCoverageData;
        if (!isset($expectedCoverageData[self::TEST_FILENAME][0])) {
            $expectedCoverageData[self::TEST_FILENAME][0] = [];
        }
        $this->assertSame($expectedCoverageData, $coverage->getData(true));
    }

    /**
     * @return array
     */
    public function getCoverageDataProvider()
    {
        return [
            'base' => [
                'coverageData' => []
            ],
            'do not remove other tests coverage' => [
                'coverageData' => [
                    self::TEST_FILENAME => [0 => ['anAnotherId']],
                    'an_another_file_name' => [0 => null],
                ]
            ],
            'handle null testId list' => [
                'coverageData' => ['an_another_file_name' => [0 => null]]
            ]
        ];
    }
}
