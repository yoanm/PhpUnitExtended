<?php
namespace Yoanm\PhpUnitExtended\Listener;

/**
 * @see doc/listener/YoanmTestsStrategyListener.md
 */
class YoanmTestsStrategyListener extends DelegatingListener
{
    public function __construct()
    {
        $this->addListener(new RiskyToFailedListener());
        $this->addListener(new StrictCoverageListener());
    }
}
