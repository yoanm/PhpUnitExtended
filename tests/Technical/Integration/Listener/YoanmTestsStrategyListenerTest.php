<?php
namespace Technical\Integration\Yoanm\PhpUnitExtended\Listener;

use PHPUnit\Framework\TestCase;
use Prophecy\Argument;
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
    /** @var YoanmTestsStrategyListener */
    private $listener;

    const TEST_FILENAME = 'file_name';

    public function setUp()
    {
        $this->listener = new YoanmTestsStrategyListener();
    }

    public function testListenerAppended()
    {
        $expectedListenerClassList = [
            RiskyToFailedListener::class,
            StrictCoverageListener::class,
        ];

        $this->shouldContainsOnlyClassList(
            $expectedListenerClassList,
            $this->listener->getListenerList()
        );
    }

    /**
     * @param array $expectedClassList
     * @param array $classList
     */
    protected function shouldContainsOnlyClassList(array $expectedClassList, array $classList)
    {
        $expectedCount = count($expectedClassList);

        $this->assertCount($expectedCount, $classList);

        $remainingClassList = array_combine(
            $expectedClassList,
            array_fill(0, $expectedCount, true)
        );

        foreach ($classList as $listener) {
            $listenerClass = get_class($listener);
            if (array_key_exists($listenerClass, $remainingClassList)) {
                $remainingClassList[$listenerClass] = false;
            }
        }
        $remainingClassList = array_filter($remainingClassList);

        $this->assertSame([], $remainingClassList);
    }
}
