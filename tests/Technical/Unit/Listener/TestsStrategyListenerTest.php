<?php
namespace Technical\Unit\Yoanm\PhpUnitExtended\Listener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\PhpUnitExtended\Listener\TestsStrategyListener;

class TestsStrategyListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var TestsStrategyListener */
    private $listener;

    public function setUp()
    {
        $this->listener = new TestsStrategyListener();
    }

    /**
     * @dataProvider getExceptionMessageProvider
     *
     * @param string $exceptionClass
     * @param string $expectedReason
     */
    public function testAddRiskyTest($exceptionClass, $expectedReason)
    {
        $time = 0.3;
        
        /** @var \PHPUnit_Framework_TestCase|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_TestCase::class);
        /** @var \PHPUnit_Framework_TestResult|ObjectProphecy $testResult */
        $testResult = $this->prophesize(\PHPUnit_Framework_TestResult::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize($exceptionClass);

        $test->getTestResultObject()
            ->willReturn($testResult->reveal())
            ->shouldBeCalled();
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
        ->shouldBeCalled();

        if (\PHPUnit_Framework_OutputError::class === $exceptionClass) {
            $testResult->getCodeCoverage()
                ->willReturn(null)
                ->shouldBeCalled();
        }

        $this->listener->addRiskyTest($test->reveal(), $exception->reveal(), $time);
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
            'other exceptions' => [
                'exceptionClass' => \Exception::class,
                'expectedMessage' => 'Risky test',
            ],
        ];
    }
}
