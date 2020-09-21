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
    const DEPTH_REGEX = '/^(\d\.)+/';

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
            $fileName = $file->getFileNameWithoutExtension($this->config->getDocsExtension());
            $depth = $this->calculateNumberingSystemDepth($fileName);
            $fileName = $this->removeNumberingSystem($fileName);
            $title = $this->getTitle($file);
            if ($title === null) {
                $title = $fileName;
            }

            $this->menuItems[] = new MenuItem(
                $title,
                $fileName,
                $file,
                $depth
            );
        }
    }

    /**
     * Get list of prepared menu items.
     *
     * @return MenuItem[]
     */
    public function getMenuItems(): array
    {
        return $this->menuItems;
    }

    /**
     * Generates title
     * @param File $file
     * @return string|null  NULL when no title was found in the file content.
     */
    protected function getTitle(File $file)
    {
        if (preg_match('/^.*?#\s+(.*?)(\n|$)/m', $file->getFileContent(), $matches)) {
            return trim($matches[1]);
        }

        return null;
    }

    /**
     * Cleans up file name from numbering system, so "1.1.file" would be come "file".
     * @param string $fileName
     * @return string|string[]|null
     */
    protected function removeNumberingSystem(string $fileName)
    {
        return preg_replace(self::DEPTH_REGEX, '', $fileName);
    }

    /**
     * @param string $fileName
     * @return int
     */
    protected function calculateNumberingSystemDepth(string $fileName): int
    {
        $depth = 1;
        if (preg_match(self::DEPTH_REGEX, $fileName, $matches)) {
            $depth = substr_count($matches[0], '.');
        }

        return $depth;
    }
}