<?php


namespace Bologer;


use Bologer\Dto\File;
use Bologer\Toc\MenuItem;
use Bologer\Toc\TableOfContents;
use Bologer\Toc\TableOfContentsGenerator;
use Parsedown;

define('BOOKS_ASSETS_DIR', basename(__DIR__ . '/../assets'));

class Parser
{
    private Config $config;
    private Parsedown $parser;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->parser = new Parsedown();
    }

    public function parse()
    {
        $files = $this->getFilesToParse();

        $toc = new TableOfContents($this->config);
        $toc->prepare($files);

        $tableOfContents = (new TableOfContentsGenerator($toc))->generate();

        foreach ($toc->getPreparedItem() as $menuItem) {
            $this->parseFile($menuItem, $tableOfContents);
        }

        $assetsFolder = $this->config->distFolder . '/assets';

        if (!is_dir($assetsFolder)) {
            mkdir($assetsFolder);
        }
        copy(BOOKS_ASSETS_DIR . '/themes/default/styles.css', $assetsFolder . '/styles.css');
    }

    public function parseFile(MenuItem $menuItem, string $tableOfContents)
    {
        $content = file_get_contents($menuItem->file->path);
        $fileNameWithoutExtension = $menuItem->file->getFileName($this->config->getSrcExtension());
        $dist = rtrim($this->config->distFolder, '/') . '/' . $fileNameWithoutExtension . '.html';


        $head = '';
        $endOfBody = null;

        if (!empty($this->config->codeHighlightLanguages)) {

            $head = <<<HTML
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/styles/darcula.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/highlight.min.js"></script>
HTML;

            foreach ($this->config->codeHighlightLanguages as $language) {
                $head .= <<<HTML
<script charset="UTF-8" src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/10.1.2/languages/$language.min.js"></script>
HTML;
            }

            $endOfBody = <<<HTML
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('pre code').forEach((block) => {
            hljs.highlightBlock(block);
        });
    });
</script>
HTML;
        }

        $parsedContent = $this->getLayout(
            $menuItem->title,
            $tableOfContents,
            $head,
            $this->parser->text($content),
            $endOfBody
        );
        file_put_contents($dist, $parsedContent);
    }

    public function getLayout(string $title, string $tableOfContents, string $head, string $content, string $endBody = null)
    {
        $layoutContent = file_get_contents(BOOKS_ASSETS_DIR . '/themes/default/layout.html');

        return str_replace(
            ['{{title}}', '{{tableOfContents}}', '{{head}}', '{{content}}', '{{endBody}}'],
            [$title, $tableOfContents, $head, $content, $endBody],
            $layoutContent
        );
    }

    /**
     * Get list of files to parse.
     *
     * @return File[]
     */
    public function getFilesToParse(): array
    {
        $foundFiles = glob(rtrim($this->config->srcFolder, '/') . '/' . '*.' . $this->config->getSrcExtension());
        sort($foundFiles);

        foreach ($foundFiles as $key => $path) {
            $foundFiles[$key] = new File($path);
        }
        return $foundFiles;
    }
}
