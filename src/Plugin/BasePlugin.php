<?php


namespace Bologer\Plugin;


use Bologer\Config;

abstract class BasePlugin implements LoadablePlugin
{
    protected Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }
}
