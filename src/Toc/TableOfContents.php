<?php


namespace Bologer\Toc;

use Bologer\Config;
use Bologer\Dto\File;

/**
 * TableOfContents processed givens files and prepares menu items.
 *
 * @package Bologer\Toc
 */
class TableOfContents
{
    private Config $config;

    /**
     * @var MenuItem[] List of menu items.
     */
    private array $menuItems = [];

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Prepares given list of files.
     *
     * @param File[] $files
     */
    public function prepare(array $files): void
    {
        foreach ($files as $file) {
            $fileContent = file_get_contents($file->path);
            $fileName = basename($file->path, '.' . $this->config->getSrcExtension());

            if (preg_match('/^.*?#\s+(.*?)\n/m', $fileContent, $matches)) {
                $title = trim($matches[1]);
            } else {
                $title = $fileName;
            }
            $this->menuItems[] = new MenuItem(
                $title,
                $fileName . '.html',
                $file
            );
        }
    }

    /**
     * Get list of prepared menu items.
     *
     * @return MenuItem[]
     */
    public function getPreparedItem(): array
    {
        return $this->menuItems;
    }
}