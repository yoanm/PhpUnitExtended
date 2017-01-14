<?php

/**
 * @backupStaticAttributes enabled
 */
class RiskyStaticTest extends PHPUnit_Framework_TestCase
{
    public function test()
    {
        \AppTest\DefaultClass::$value = 'a';
        $this->assertTrue(true);
    }
}
