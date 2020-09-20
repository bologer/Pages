<?php


namespace Bologer;

use Parsedown;

class Pages
{
    private Config $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    public function build()
    {
        $parser = new Parser($this->config);
        $parser->parse();
    }
}
