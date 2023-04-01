<?php
namespace Tests\Functional\Listener;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Yoanm\PhpUnitExtended\Listener\RiskyToFailedListener;
use Yoanm\PhpUnitExtended\Listener\StrictCoverageListener;
use Yoanm\PhpUnitExtended\Listener\YoanmTestsStrategyListener;

/**
 * @covers Yoanm\PhpUnitExtended\Listener\YoanmTestsStrategyListener
 * @uses Yoanm\PhpUnitExtended\Listener\DelegatingListener
 * @uses Yoanm\PhpUnitExtended\Listener\StrictCoverageListener
 */
class YoanmTestsStrategyListenerTest extends TestCase
{
    use ProphecyTrait;

    /** @var YoanmTestsStrategyListener */
    private $listener;

    const TEST_FILENAME = 'file_name';

    public function setUp(): void
    {
        $this->listener = new YoanmTestsStrategyListener();
    }

    public function testShouldHaveRiskyToFailListenerByDefault()
    {
        $this->shouldHaveListenerClass(
            RiskyToFailedListener::class,
            $this->listener->getListenerList()
        );
    }

    public function testShouldHaveStrictCoverageListenerByDefault()
    {
        $this->shouldHaveListenerClass(
            StrictCoverageListener::class,
            $this->listener->getListenerList()
        );
    }

    /**
     * @param array $expectedClassList
     * @param array $classList
     */
    protected function shouldHaveListenerClass($class, array $classList)
    {
        $found = false;

        foreach ($classList as $listener) {
            $listenerClass = get_class($listener);
            if ($listenerClass === $class) {
                $found = true;
                break;
            }
        }

        $this->assertTrue($found);
    }
}
