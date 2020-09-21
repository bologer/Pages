<?php


namespace Bologer\Layout;


use Bologer\Config;
use Bologer\Plugin\PluginFactory;
use Bologer\Toc\TableOfContentsGenerator;

class Layout
{
    private Config $config;

    private ?string $layout = null;

    private ?string $title = null;

    private ?TableOfContentsGenerator $tableOfContents = null;

    private ?string $content = null;

    private array $head = [];

    private array $bodyEnd = [];

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Generates layout with configured content.
     * @return mixed
     * @throws \Exception
     */
    public function generate()
    {
        if (empty($this->layout)) {
            throw new \Exception('Layout is not provided');
        }

        if (empty($this->title)) {
            throw new \Exception('Page title cannot be empty');
        }

        $layoutContent = file_get_contents($this->layout);

        $this->resolvePlugins();

        return str_replace(
            ['{{title}}', '{{tableOfContents}}', '{{head}}', '{{content}}', '{{bodyEnd}}'],
            [$this->title, $this->tableOfContents->generate(), implode($this->head), $this->content, implode($this->bodyEnd)],
            $layoutContent
        );
    }

    public function withLayout(string $layout)
    {
        if (!is_file($layout)) {
            throw new \DomainException("Layout $layout does not exist");
        }

        $this->layout = $layout;
    }

    public function withTitle(string $title)
    {
        $this->title = $title;
    }

    public function withTableOfContents(TableOfContentsGenerator $toc)
    {
        $this->tableOfContents = $toc;
    }

    public function withHead(string $head)
    {
        $this->head[] = $head;
    }

    public function withBodyEnd(string $body)
    {
        $this->bodyEnd[] = $body;
    }

    public function withContent(string $content)
    {
        $this->content = $content;
    }

    /**
     * Resolves plugins to layout.
     */
    protected function resolvePlugins()
    {
        foreach ($this->config->plugins as $plugin) {
            $pluginClass = PluginFactory::create($plugin, $this->config);
            $pluginClass->load($this);
        }
    }
}
