<?php

class RiskyGlobalsTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @backupGlobals enabled
     * @group risky-globals-var
     */
    public function testGlobalsVar()
    {
        $GLOBALS['a'] = true;
        $this->assertTrue(true);
    }

    /**
     * @backupStaticAttributes enabled
     * @group risky-static-att
     */
    public function testStaticAttribute()
    {
        \AppTest\DefaultClass::$value = 'a';
        $this->assertTrue(true);
    }
}
