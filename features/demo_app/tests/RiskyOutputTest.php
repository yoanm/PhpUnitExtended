<?php

/**
 * @coversNothing
 */
class RiskyOutputTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @group risky-output
     */
    public function test()
    {
        var_dump('TEST_OUTPUT_DURING_TEST');
        $this->assertTrue(true);
    }

    /**
     * @group risky-output-with-coverage
     * @covers \AppTest\DefaultClass
     */
    public function testWithCoverage()
    {
        $object = new \AppTest\DefaultClass();
        $object->justForTest();

        $this->test();
    }
}
