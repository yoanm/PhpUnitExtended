<?php

/**
 * @covers \Exception
 */
class RiskyCoverageTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $object = new \AppTest\DefaultClass();
        $object->justForTest();
        $this->assertTrue(true);
    }
}
