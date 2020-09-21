<?php

namespace Bologer\Plugin;

use Bologer\Layout\Layout;

/**
 * CodePlugin loads code related assets.
 *
 * @package Bologer\Plugin
 */
class CodePlugin extends BasePlugin
{
    /**
     * @inheritDoc
     */
    public function load(Layout $layout)
    {
        $layout->withHead('<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/github.min.css">');
        $layout->withHead('<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>');


        foreach ($this->config->codeHighlightLanguages as $language) {
            $layout->withHead('<script charset="UTF-8" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/languages/' . $language . '.min.js"></script>');
        }

        $layout->withBodyEnd(<<<HTML
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    });
</script>
HTML
        );
    }
}