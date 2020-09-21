<?php

namespace Bologer\Dto;

/**
 * File is a DTO object which holds single file information.
 *
 * @package Bologer\Dto
 */
class File
{
    /**
     * @var string Absolute file path.
     */
    public string $path;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * Get file name with extension or without.
     * @param string|null $extension Provide extension name if no extension is needed.
     * @return string
     */
    public function getFileName(?string $extension = null)
    {
        return basename($this->path, '.' . $extension);
    }

    /**
     * Get file content.
     * @return false|string
     */
    public function getFileContent()
    {
        return file_get_contents($this->path);
    }

    /**
     * @param string $extension
     * @return string
     */
    public function getFileNameWithoutExtension(string $extension)
    {
        return basename($this->path, '.' . trim($extension, '.'));
    }
}
