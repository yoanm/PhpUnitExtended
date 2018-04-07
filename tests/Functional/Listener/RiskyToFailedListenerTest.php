<?php
namespace Tests\Functional\Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\RiskyTestError;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\UnintentionallyCoveredCodeError;
use PHPUnit\Framework\Warning;
use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener
 */
class RiskyToFailedListenerTest extends TestCase
{
    /** @var RiskyToFailedListener */
    private $listener;

    public function setUp()
    {
        $this->listener = new RiskyToFailedListener();
    }

    public function testShouldHandleBadCoverageTagWarning()
    {
        $time = 0.3;

        /** @var TestCase|ObjectProphecy $test */
        $test = $this->prophesize(TestCase::class);
        /** @var TestResult|ObjectProphecy $testResult */
        $testResult = $this->prophesize(TestResult::class);
        /** @var Warning $warning */
        $warning = new Warning(
            'Trying to @cover or @use not existing method "AppTest\DefaultClass::notExistingMethod".'
        );

        $test->getTestResultObject()
            ->willReturn($testResult->reveal())
            ->shouldBeCalled();

        $testResult->addFailure(
            $test,
            Argument::allOf(
                Argument::type(AssertionFailedError::class),
                Argument::that(function (AssertionFailedError $arg) {
                    return preg_match(
                        '#Only executed code must be defined with @covers and @uses annotations#',
                        $arg->getMessage()
                    );
                })
            ),
            $time
        )
            ->shouldBeCalledTimes(1);

        $this->listener->addWarning($test->reveal(), $warning, $time);
    }

    /**
     * @dataProvider getExceptionMessageProvider
     *
     * @param string $exceptionClass
     * @param string $expectedReason
     */
    public function testShouldHandleRiskyTestWith($exceptionClass, $expectedReason, $called = true, $exceptionMessage = null)
    {
        $time = 0.3;

        /** @var TestCase|ObjectProphecy $test */
        $test = $this->prophesize(TestCase::class);
        /** @var TestResult|ObjectProphecy $testResult */
        $testResult = $this->prophesize(TestResult::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = new $exceptionClass($exceptionMessage);

        if ($exception instanceof AssertionFailedError) {
            $test->getTestResultObject()
                ->willReturn($testResult->reveal())
                ->shouldBeCalled();
        }
        $testResult->addFailure(
            $test,
            Argument::allOf(
                Argument::type(AssertionFailedError::class),
                Argument::that(function (AssertionFailedError $arg) use ($expectedReason) {
                    return preg_match(sprintf('#%s#', preg_quote($expectedReason)), $arg->getMessage());
                })
            ),
            $time
        )
            ->shouldBeCalledTimes($called ? 1 : 0);

        $this->listener->addRiskyTest($test->reveal(), $exception, $time);
    }

    /**
     * @return array
     */
    public function getExceptionMessageProvider()
    {
        return [
            'Output exception' => [
                'exceptionClass' => OutputError::class,
                'expectedMessage' => 'No output during test',
            ],
            'Coverage exception' => [
                'exceptionClass' => UnintentionallyCoveredCodeError::class,
                'expectedMessage' => 'Executed code must be defined with @covers and @uses annotations',
            ],
            'Globals manipulation - globals' => [
                'exceptionClass' => RiskyTestError::class,
                'expectedMessage' => 'No global variable manipulation during test',
                'called' => true,
                'exceptionMessage' => '--- Global variables before the test',
            ],
            'Globals manipulation - static' => [
                'exceptionClass' => RiskyTestError::class,
                'expectedMessage' => 'No static attribute manipulation during test',
                'called' => true,
                'exceptionMessage' => '--- Static attributes before the test',
            ],
            'Test nothing' => [
                'exceptionClass' => RiskyTestError::class,
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
}
