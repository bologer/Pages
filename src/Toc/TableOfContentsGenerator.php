<?php


namespace Bologer\Toc;


class TableOfContentsGenerator
{
    private TableOfContents $tableOfContents;

    public function __construct(TableOfContents $tableOfContents)
    {
        $this->tableOfContents = $tableOfContents;
    }

    public function generate()
    {
        $items = $this->tableOfContents->getPreparedItem();

        $result = '<ul>';
        foreach ($items as $item) {
            $result .= '<li><a href="' . $item->url . '">' . $item->title . '</a></li>';
        }
        $result .= '</ul>';
        return $result;
    }
}