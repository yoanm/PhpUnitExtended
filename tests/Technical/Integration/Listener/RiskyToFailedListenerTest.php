<?php
namespace Technical\Integration\Yoanm\PhpUnitExtended\Listener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener
 */
class RiskyToFailedListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var RiskyToFailedListener */
    private $listener;

    public function setUp()
    {
        $this->listener = new RiskyToFailedListener();
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
}
