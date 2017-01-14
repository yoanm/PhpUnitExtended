<?php
namespace Technical\Unit\Yoanm\PhpUnitExtended\Listener;

use Prophecy\Argument;
use Prophecy\Prophecy\ObjectProphecy;
use Yoanm\PhpUnitExtended\Listener\DelegatingListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\DelegatingListener
 */
class DelegatingListenerTest extends \PHPUnit_Framework_TestCase
{
    /** @var DelegatingListener */
    private $listener;

    public function setUp()
    {
        $this->listener = new DelegatingListener();
    }
    
    public function testListenerList()
    {
        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);

        $this->listener->addListener($delegate->reveal());

        $this->assertSame(
            [$delegate->reveal()],
            $this->listener->getListenerList()
        );
    }

    public function testAddError()
    {
        $time = 0.2;

        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addError($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addError($test->reveal(), $exception->reveal(), $time);
    }

    public function testAddFailure()
    {
        $time = 0.2;

        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);
        /** @var \PHPUnit_Framework_AssertionFailedError|ObjectProphecy $exception */
        $exception = $this->prophesize(\PHPUnit_Framework_AssertionFailedError::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addFailure($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addFailure($test->reveal(), $exception->reveal(), $time);
    }

    public function testAddIncompleteTest()
    {
        $time = 0.2;

        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addIncompleteTest($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addIncompleteTest($test->reveal(), $exception->reveal(), $time);
    }

    public function testAddRiskyTest()
    {
        $time = 0.2;

        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addRiskyTest($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addRiskyTest($test->reveal(), $exception->reveal(), $time);
    }

    public function testAddSkippedTest()
    {
        $time = 0.2;

        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);
        /** @var \Exception|ObjectProphecy $exception */
        $exception = $this->prophesize(\Exception::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->addSkippedTest($test->reveal(), $exception->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->addSkippedTest($test->reveal(), $exception->reveal(), $time);
    }

    public function testStartTestSuite()
    {
        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_TestSuite|ObjectProphecy $testSuite */
        $testSuite = $this->prophesize(\PHPUnit_Framework_TestSuite::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->startTestSuite($testSuite->reveal())
            ->shouldBeCalled();

        $this->listener->startTestSuite($testSuite->reveal());
    }

    public function testEndTestSuite()
    {
        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_TestSuite|ObjectProphecy $testSuite */
        $testSuite = $this->prophesize(\PHPUnit_Framework_TestSuite::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->endTestSuite($testSuite->reveal())
            ->shouldBeCalled();

        $this->listener->endTestSuite($testSuite->reveal());
    }

    public function testStartTest()
    {
        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->startTest($test->reveal())
            ->shouldBeCalled();

        $this->listener->startTest($test->reveal());
    }

    public function testEndTest()
    {
        $time = 0.2;

        /** @var \PHPUnit_Framework_TestListener|ObjectProphecy $delegate */
        $delegate = $this->prophesize(\PHPUnit_Framework_TestListener::class);
        /** @var \PHPUnit_Framework_Test|ObjectProphecy $test */
        $test = $this->prophesize(\PHPUnit_Framework_Test::class);

        $this->listener->addListener($delegate->reveal());

        $delegate->endTest($test->reveal(), $time)
            ->shouldBeCalled();

        $this->listener->endTest($test->reveal(), $time);
    }
}
