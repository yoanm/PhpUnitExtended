<?php
namespace Tests\Functional\Listener;

use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;
use Prophecy\PhpUnit\ProphecyTrait;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Driver\Xdebug3Driver;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\ProcessedCodeCoverageData;
use Tests\Functional\Mock\TestCaseMock;
use Yoanm\PhpUnitExtended\Listener\StrictCoverageListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\StrictCoverageListener
 */
class StrictCoverageListenerTest extends TestCase
{
    use ProphecyTrait;

    /** @var StrictCoverageListener */
    private $listener;

    const TEST_FILENAME = 'file_name';

    public function setUp(): void
    {
        $this->listener = new StrictCoverageListener();
    }

    /**
     * @dataProvider getCoverageDataProvider
     *
     * @param array $baseCoverageData
     */
    public function testShouldCorrectlyHandleCoverageRemovalWith(array $baseCoverageData)
    {
        $time = 0.3;

        $test = new TestCaseMock();
        $testResult = new TestResult();
        $filter = new Filter();
        $coverage = new CodeCoverage(new Xdebug3Driver($filter), $filter);
        $exception = new OutputError();


        $test->setTestResultObject($testResult);
        $testResult->setCodeCoverage($coverage);

        $testCoverageData = $baseCoverageData;
        $testCoverageData[self::TEST_FILENAME][0][] = $test->toString();
        $processed = new ProcessedCodeCoverageData();
        $processed->setLineCoverage($testCoverageData);
        $coverage->setData($processed);

        $this->listener->addRiskyTest($test, $exception, $time);

        $expectedCoverageData = $baseCoverageData;
        if (!isset($expectedCoverageData[self::TEST_FILENAME][0])) {
            $expectedCoverageData[self::TEST_FILENAME][0] = [];
        }
        $this->assertEquals($expectedCoverageData, $coverage->getData(true)->lineCoverage());
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
