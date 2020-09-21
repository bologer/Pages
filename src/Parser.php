<?php


namespace Bologer;

use Bologer\Dto\File;
use Bologer\Toc\MenuItem;
use Bologer\Layout\Layout;
use Bologer\Toc\TableOfContents;
use Bologer\Parser\MarkdownParser;
use Bologer\Parser\ParserInterface;
use Bologer\Toc\TableOfContentsGenerator;

define('BOOKS_ASSETS_DIR', __DIR__ . '/../assets');

class Parser
{
    private Config $config;
    private ParserInterface $parser;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->parser = new MarkdownParser();
    }

    public function parse()
    {
        $files = $this->getFilesToParse();

        $toc = new TableOfContents($this->config);
        $toc->prepare($files);

        if (!is_dir($this->config->distFolder)) {
            mkdir($this->config->distFolder, 0755, true);
        }

        $tableOfContents = new TableOfContentsGenerator($toc);
        $layout = new Layout($this->config);
        $layout->withLayout(BOOKS_ASSETS_DIR . '/themes/default/layout.html');
        $layout->withTableOfContents($tableOfContents);

        foreach ($toc->getMenuItems() as $menuItem) {
            $this->parseFile($menuItem, $layout);
        }

        $assetsFolder = $this->config->distFolder . '/assets';

        if (!is_dir($assetsFolder)) {
            mkdir($assetsFolder, 0755, true);
        }

        copy(BOOKS_ASSETS_DIR . '/themes/default/styles.css', $assetsFolder . '/styles.css');
    }

    public function parseFile(MenuItem $menuItem, Layout $layout)
    {
        $content = file_get_contents($menuItem->file->path);
        $dist = rtrim($this->config->distFolder, '/') . '/' . $menuItem->fileName . '.html';
        $layout->withTitle($menuItem->title);
        $layout->withContent($this->parser->parse($content));
        file_put_contents($dist, $layout->generate());
    }

    /**
     * Get list of files to parse.
     *
     * @return File[]
     */
    public function getFilesToParse(): array
    {
        $foundFiles = glob(rtrim($this->config->docsFolder, '/') . '/' . '*.' . $this->config->getDocsExtension());
        sort($foundFiles);

        foreach ($foundFiles as $key => $path) {
            $foundFiles[$key] = new File($path);
        }
        return $foundFiles;
    }

    /**
     * Set custom parser.
     * @param ParserInterface $parser
     */
    public function withParser(ParserInterface $parser)
    {
        $this->parser = $parser;
    }
}
