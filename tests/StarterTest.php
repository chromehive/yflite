<?php

use PHPUnit\Framework\TestCase;

class StarterTest extends TestCase
{
    public function testInitialization()
    {
        $starter = new Starter();
        $this->assertNotNull($starter);
    }

    public function testConfiguration()
    {
        $starter = new Starter();
        $starter->configure(['setting' => 'value']);
        $this->assertEquals('value', $starter->getSetting('setting'));
    }

    public function testInvalidConfiguration()
    {
        $starter = new Starter();
        $this->expectException(InvalidArgumentException::class);
        $starter->configure(['invalid_setting' => 'value']);
    }
}