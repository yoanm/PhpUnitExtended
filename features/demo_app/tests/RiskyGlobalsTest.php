<?php

class RiskyGlobalsTest extends \PHPUnit\Framework\TestCase
{
    public function __construct($name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);

        // Remove composer container from cache to speed up tests
        foreach (\get_declared_classes() as $className) {
            if (preg_match('/^ComposerAutoloaderInit/', $className)) {
                $this->backupStaticAttributesBlacklist[$className] = ['loader'];
                break;
            }
        }
    }

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
