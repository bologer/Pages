<?php


namespace Bologer\Toc;


class TableOfContentsGenerator
{
    private TableOfContents $tableOfContents;

    private $content;

    public function __construct(TableOfContents $tableOfContents)
    {
        $this->tableOfContents = $tableOfContents;
    }

    public function generate()
    {
        if (!empty($this->content)) {
            return $this->content;
        }
        $items = $this->tableOfContents->getMenuItems();
        $this->content = '<ul>';
        foreach ($items as $item) {
            $this->content .= '<li data-depth="' . $item->depth . '">';
            $this->content .= '<a href="' . $item->fileName . '.html">' . $item->title . '</a>';
            $this->content .= '</li>';
        }
        $this->content .= '</ul>';
        return $this->content;
    }

    /**
     * Resets object to default state.
     */
    public function reset()
    {
        $this->content = null;
    }
}