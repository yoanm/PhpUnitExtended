<?php
namespace Technical\Integration\Yoanm\PhpUnitExtended\Listener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Technical\Integration\Yoanm\PhpUnitExtended\Mock\TestCaseMock;
use Yoanm\PhpUnitExtended\Listener\TestsStrategyListener;

class TestsStrategyListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TestsStrategyListener */
    private $listener;

    const TEST_NAME = 'test_name';
    const TEST_CLASS = TestCaseMock::class;
    const TEST_FILENAME = 'file_name';

    private static $baseCoverageData = [self::TEST_FILENAME => [0 => []]];

    public function setUp()
    {
        $this->listener = new TestsStrategyListener();
    }

    /**
     * @dataProvider getCoverageDataProvider
     *
     * @param array $baseCoverageData
     */
    public function testCoverageRemoval(array $baseCoverageData)
    {
        $time = 0.3;

        $testClass = self::TEST_CLASS;
        /** @var TestCaseMock $test */
        $test = new $testClass(self::TEST_NAME);
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

        $id = sprintf('%s::%s', get_class($test), $test->getName());

        $testCoverageData = $baseCoverageData;
        $testCoverageData[self::TEST_FILENAME][0][] = $id;
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
                'coverageData' => [self::TEST_FILENAME => [0 => ['anAnotherId']]]
            ],
            'handle null testId list' => [
                'coverageData' => ['a_another_file_name' => [0 => null]]
            ]
        ];
    }
}
