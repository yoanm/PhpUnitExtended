<?php
namespace Tests\Functional\Listener;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\TestListener;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use Prophecy\PhpUnit\ProphecyTrait;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\PhpUnitExtended\Listener\DelegatingListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\DelegatingListener
 */
class DelegatingListenerTest extends TestCase
{
    use ProphecyTrait;

    /** @var DelegatingListener */
    private $listener;

    public function setUp(): void
    {
        $this->listener = new DelegatingListener();
    }
    
    public function testShouldManagerAListOfListener()
    {
        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);

        $this->listener->addListener($delegate->reveal());

        $this->assertSame(
            [$delegate->reveal()],
            $this->listener->getListenerList()
        );
    }

    public function testShouldHandleError()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addError($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addError($test->reveal(), $exception->reveal(), $time);
    }

    public function testShouldHandleWarning()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);
        /** @var Warning|ObjectProphecy $exception */
        $warning = new Warning();

        $this->listener->addListener($delegate->reveal());

        $delegate->addWarning($test->reveal(), $warning, $time)
            ->shouldBeCalled();

        $this->listener->addWarning($test->reveal(), $warning, $time);
    }

    public function testShouldHandleFailure()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);
        /** @var AssertionFailedError|ObjectProphecy $exception */
        $exception = $this->prophesize(AssertionFailedError::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addFailure($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addFailure($test->reveal(), $exception->reveal(), $time);
    }

    public function testShouldHandleIncompleteTest()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addIncompleteTest($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addIncompleteTest($test->reveal(), $exception->reveal(), $time);
    }

    public function testShouldHandleRiskyTest()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addRiskyTest($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addRiskyTest($test->reveal(), $exception->reveal(), $time);
    }

    public function testShouldHandleSkippedTest()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addSkippedTest($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addSkippedTest($test->reveal(), $exception->reveal(), $time);
    }

    public function testShouldHandleTestSuiteStart()
    {
        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var TestSuite|ObjectProphecy $testSuite */
        $testSuite = $this->prophesize(TestSuite::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->startTestSuite($testSuite->reveal())
            ->shouldBeCalled();

        $this->listener->startTestSuite($testSuite->reveal());
    }

    public function testShouldHandleTestSuiteEnd()
    {
        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var TestSuite|ObjectProphecy $testSuite */
        $testSuite = $this->prophesize(TestSuite::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->endTestSuite($testSuite->reveal())
            ->shouldBeCalled();

        $this->listener->endTestSuite($testSuite->reveal());
    }

    public function testShouldHandleTestStart()
    {
        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->startTest($test->reveal())
            ->shouldBeCalled();

        $this->listener->startTest($test->reveal());
    }

    public function testShouldHandleTestEnd()
    {
        $time = 0.2;

        /** @var TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(TestListener::class);
        /** @var Test|ObjectProphecy $test */
        $test = $this->prophesize(Test::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->endTest($test->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->endTest($test->reveal(), $time);
    }
}
