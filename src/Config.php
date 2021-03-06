<?php


namespace Bologer;

/**
 * Config is a configure class.
 *
 * @package Bologer
 */
class Config
{
    /**
     * @var string Absolute directory to documentation folder to be processed.
     */
    public string $docsFolder;

    /**
     * @var string Absolute directory where to put generated files.
     */
    public string $distFolder;

    /**
     * @var string Source file extension. Script will search for such file extension, build table of contents, etc.
     */
    public string $docsExtension = 'md';

    /**
     * @var string Distributed file extension. This file extension will be used on source files after they are
     * processed.
     */
    public string $distExtension = 'html';

    /**
     * @var array List of languages available for highlight. See highlight.js official documentation for details
     * about available languages.
     * @link https://highlightjs.org/usage/
     */
    public array $codeHighlightLanguages = [];

    /**
     * @var array Plugins to be loaded with documentation. Available options: code.
     */
    public array $plugins = ['code'];

    public function getDocsExtension()
    {
        return trim($this->docsExtension, '.');
    }
}
