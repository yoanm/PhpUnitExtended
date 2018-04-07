<?php

class RiskyCoverageTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @covers \Exception
     * @group risky-coverage
     */
    public function test()
    {
        $object = new \AppTest\DefaultClass();
        $object->justForTest();
        $this->assertTrue(true);
    }
}
