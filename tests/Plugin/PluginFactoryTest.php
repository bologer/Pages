<?php


namespace Bologer\Tests\Plugin;


use Bologer\Config;
use Bologer\Plugin\CodePlugin;
use Bologer\Plugin\PluginFactory;
use PHPUnit\Framework\TestCase;

class PluginFactoryTest extends TestCase
{
    public function testCanCreateInstances()
    {
        $this->assertInstanceOf(
            CodePlugin::class,
            PluginFactory::create(
                'code',
                new Config()
            )
        );
    }
}
