<?php
namespace Tests\Functional\Listener;

use PHPUnit\Framework\InvalidCoversTargetException;
use PHPUnit\Framework\OutputError;
use PHPUnit\Framework\RiskyTestError;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestFailure;
use PHPUnit\Framework\TestResult;
use PHPUnit\Framework\UnintentionallyCoveredCodeError;
use PHPUnit\Framework\Warning;
use Prophecy\PhpUnit\ProphecyTrait;
use Tests\Functional\Mock\TestCaseMock;
use Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener
 */
class RiskyToFailedListenerTest extends TestCase
{
    use ProphecyTrait;

    /** @var RiskyToFailedListener */
    private $listener;

    public function setUp(): void
    {
        $this->listener = new RiskyToFailedListener();
    }

    public function testShouldHandleBadCoverageTagWarning()
    {
        $time = 0.3;
        $test = new TestCaseMock();
        $message = '"@covers AppTest\DefaultClass::notExistingMethod" is invalid';
        $warning = new Warning($message);

        $test->setTestResultObject(new TestResult());

        $this->listener->addWarning($test, $warning, $time);

        $failures = $test->getTestResultObject()->failures();
        $this->assertCount(1, $failures);
        $failure = array_shift($failures);
        $this->assertInstanceOf(TestFailure::class, $failure);
        $this->assertStringContainsString($message, $failure->getExceptionAsString());
    }

    /**
     * @dataProvider getExceptionMessageProvider
     *
     * @param $exceptionClass
     * @param $expectedReason
     * @param null $exceptionMessage
     */
    public function testShouldHandleRiskyTestWith(
        $exceptionClass,
        $expectedReason,
        $exceptionMessage = 'my default exception message'
    ) {
        $time = 0.3;
        $test = new TestCaseMock();
        $exception = new $exceptionClass($exceptionMessage);

        $test->setTestResultObject(new TestResult());

        $this->listener->addRiskyTest($test, $exception, $time);

        $failures = $test->getTestResultObject()->failures();
        $this->assertCount(1, $failures);
        $failure = array_shift($failures);
        $this->assertInstanceOf(TestFailure::class, $failure);
        $this->assertStringContainsString($exceptionMessage, $failure->getExceptionAsString());
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
            'Coverage overflow - UnintentionallyCoveredCodeError' => [
                'exceptionClass' => UnintentionallyCoveredCodeError::class,
                'expectedMessage' => 'Executed code must be defined with @covers and @uses annotations',
            ],
            'Coverage overflow - InvalidCoversTargetException instance' => [
                'exceptionClass' => InvalidCoversTargetException::class,
                'expectedMessage' => 'Executed code must be defined with @covers and @uses annotations',
            ],
            'Globals manipulation - globals' => [
                'exceptionClass' => RiskyTestError::class,
                'expectedMessage' => 'No global variable manipulation during test',
                'exceptionMessage' => '--- Global variables before the test',
            ],
            'Globals manipulation - static' => [
                'exceptionClass' => RiskyTestError::class,
                'expectedMessage' => 'No static attribute manipulation during test',
                'exceptionMessage' => '--- Static attributes before the test',
            ],
            'Test nothing' => [
                'exceptionClass' => RiskyTestError::class,
                'expectedMessage' => 'No test that do not test anything',
                'exceptionMessage' => 'This test did not perform any assertions',
            ],
            'other exceptions' => [
                'exceptionClass' => \Exception::class,
                'expectedMessage' => 'Arghh !',
                'exceptionMessage' => 'Arghh !',
            ],
        ];
    }
}
