<?php
namespace Technical\Integration\Yoanm\PhpUnitExtended\Listener;

use Prophecy\Argument;
use Technical\Integration\Yoanm\PhpUnitExtended\Mock\TestCaseMock;
use Yoanm\PhpUnitExtended\Listener\TestsStrategyListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\TestsStrategyListener
 */
class TestsStrategyListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TestsStrategyListener */
    private $listener;

    const TEST_FILENAME = 'file_name';

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
     * @dataProvider getExceptionMessageProvider
     *
     * @param string $exceptionClass
     * @param string $expectedReason
     */
    public function testAddRiskyTest($exceptionClass, $expectedReason, $called = true, $exceptionMessage = null)
    {
        $time = 0.3;

        /** @var \PHPUnit_Framework_TestCase|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_TestCase::class);
        /** @var \PHPUnit_Framework_TestResult|ObjectProphecy $testResult */
        $testResult = $this->prophesize(\PHPUnit_Framework_TestResult::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = new $exceptionClass($exceptionMessage);

        if ($exception instanceof \PHPUnit_Framework_AssertionFailedError) {
            $test->getTestResultObject()
                ->willReturn($testResult->reveal())
                ->shouldBeCalled();
        }
        $testResult->addFailure(
            $test,
            Argument::allOf(
                Argument::type(\PHPUnit_Framework_AssertionFailedError::class),
                Argument::that(function (\PHPUnit_Framework_AssertionFailedError $arg) use ($expectedReason) {
                    return preg_match(sprintf('#%s#', preg_quote($expectedReason)), $arg->getMessage());
                })
            ),
            $time
        )
            ->shouldBeCalledTimes($called ? 1 : 0);

        if (\PHPUnit_Framework_OutputError::class === $exceptionClass) {
            $testResult->getCodeCoverage()
                ->willReturn(null)
                ->shouldBeCalled();
        }

        $this->listener->addRiskyTest($test->reveal(), $exception, $time);
    }

    /**
     * @return array
     */
    public function getExceptionMessageProvider()
    {
        return [
            'Output exception' => [
                'exceptionClass' => \PHPUnit_Framework_OutputError::class,
                'expectedMessage' => 'No output during test',
            ],
            'Coverage exception' => [
                'exceptionClass' => \PHPUnit_Framework_UnintentionallyCoveredCodeError::class,
                'expectedMessage' => 'Executed code must be defined with @covers and @uses annotations',
            ],
            'Globals manipulation - globals' => [
                'exceptionClass' => \PHPUnit_Framework_RiskyTestError::class,
                'expectedMessage' => 'No global variable manipulation during test',
                'called' => true,
                'exceptionMessage' => '--- Global variables before the test',
            ],
            'Globals manipulation - static' => [
                'exceptionClass' => \PHPUnit_Framework_RiskyTestError::class,
                'expectedMessage' => 'No static attribute manipulation during test',
                'called' => true,
                'exceptionMessage' => '--- Static attributes before the test',
            ],
            'Test nothing' => [
                'exceptionClass' => \PHPUnit_Framework_RiskyTestError::class,
                'expectedMessage' => 'No test that do not test anything',
                'called' => true,
                'exceptionMessage' => 'This test did not perform any assertions',
            ],
            'other exceptions' => [
                'exceptionClass' => \Exception::class,
                'expectedMessage' => 'Risky test',
                'called' => false,
            ],
        ];
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
