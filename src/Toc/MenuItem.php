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
     * @var string File name.
     */
    public string $fileName;

    /**
     * @var int Depth of the menu.
     */
    public int $depth = 1;

    /**
     * @var File
     */
    public File $file;

    public function __construct(string $title, string $fileName, File $file, int $depth = 1)
    {
        $this->title = $title;
        $this->fileName = $fileName;
        $this->file = $file;
        $this->depth = $depth;
    }
}
