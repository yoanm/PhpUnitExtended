<?php
namespace Yoanm\PhpUnitExtended\Listener;

/**
 * @see https://github.com/yoanm/PhpUnitExtended/doc/listener/YoanmTestsStrategyListener.md
 */
class YoanmTestsStrategyListener extends DelegatingListener
{
    public function __construct()
    {
        $this->addListener(new RiskyToFailedListener());
        $this->addListener(new StrictCoverageListener());
    }
}
