<?php


namespace Bologer\Parser;

use Parsedown;

/**
 * MarkdownParser a wrapper around parsing implementation.
 *
 * @package Bologer\Parser
 */
class MarkdownParser implements ParserInterface
{
    /**
     * @inheritDoc
     */
    public function parse($content)
    {
        return (new Parsedown())->text($content);
    }
}
