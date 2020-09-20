<?php


namespace Bologer\Toc;

use Bologer\Dto\File;

/**
 * MenuItem is a DTO object which holds single menu item for table of contents.
 * @package Bologer\Toc
 */
class MenuItem
{
    /**
     * @var string Human readable menu title.
     */
    public string $title;

    /**
     * @var string URL path.
     */
    public string $url;

    /**
     * @var File
     */
    public File $file;

    public function __construct(string $title, string $url, File $file)
    {
        $this->title = $title;
        $this->url = $url;
        $this->file = $file;
    }
}
