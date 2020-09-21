<?php

namespace Bologer\Parser;

interface ParserInterface
{
    /**
     * Parses given content.
     * @param string $content Content to parsed.
     * @return mixed
     */
    public function parse($content);
}
