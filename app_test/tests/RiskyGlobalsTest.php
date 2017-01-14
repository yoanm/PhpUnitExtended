<?php

/**
 * @backupGlobals enabled
 */
class RiskyGlobalsTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        $GLOBALS['a'] = true;
        $this->assertTrue(true);
    }
}
