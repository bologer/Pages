<?php


namespace Bologer\Tests\Toc;


use Bologer\Config;
use Bologer\Dto\File;
use Bologer\Toc\TableOfContents;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class TableOfContentsTest extends TestCase
{
    private Prophet $prophet;

    protected function setUp(): void
    {
        $this->prophet = new \Prophecy\Prophet;
    }

    private function getConfig()
    {
        $config = new Config();
        $config->docsFolder = __DIR__ . '/data/table-of-contents';
        $config->docsFolder = __DIR__ . '/runtime/docs';
        return $config;
    }

    public function testItGivesCorrectNumberOfMenuItems()
    {
        $config = $this->getConfig();
        $tableOfContents = new TableOfContents($config);

        $file = $this->prophet->prophesize(File::class);
        $file->getFileContent()->willReturn(
            <<<EOT
# My Title
EOT
        );
        $file->getFileNameWithoutExtension($config->getDocsExtension())->willReturn('1.file');

        $tableOfContents->prepare([$file->reveal()]);

        $items = $tableOfContents->getMenuItems();
        $this->assertEquals(1, count($items));
    }

    public function testItRemovesSingleNumberPrefix()
    {
        $config = $this->getConfig();
        $tableOfContents = new TableOfContents($config);

        $file = $this->prophet->prophesize(File::class);
        $file->getFileContent()->willReturn(
            <<<EOT
# My Title
EOT
        );
        $file->getFileNameWithoutExtension($config->getDocsExtension())->willReturn('1.file');

        $tableOfContents->prepare([$file->reveal()]);

        $items = $tableOfContents->getMenuItems();
        $this->assertEquals('file', $items[0]->fileName);
    }

    public function testItRemovesMultiLevelPrefixes()
    {
        $config = $this->getConfig();
        $tableOfContents = new TableOfContents($config);

        $file = $this->prophet->prophesize(File::class);
        $file->getFileContent()->willReturn(
            <<<EOT
# My Title
EOT
        );
        $file->getFileNameWithoutExtension($config->getDocsExtension())->willReturn('1.1.1.file');

        $tableOfContents->prepare([$file->reveal()]);

        $items = $tableOfContents->getMenuItems();
        $this->assertEquals('file', $items[0]->fileName);
    }

    public function testReadsTitleCorrectly()
    {
        $config = $this->getConfig();
        $tableOfContents = new TableOfContents($config);

        $file = $this->prophet->prophesize(File::class);
        $file->getFileContent()->willReturn(
            <<<EOT
# My Title
EOT
        );
        $file->getFileNameWithoutExtension($config->getDocsExtension())->willReturn('1.file');

        $tableOfContents->prepare([$file->reveal()]);

        $items = $tableOfContents->getMenuItems();
        $this->assertEquals('My Title', $items[0]->title);
    }

    public function testUsesFileNameWhenTitleIsMissing()
    {
        $config = $this->getConfig();
        $tableOfContents = new TableOfContents($config);

        $file = $this->prophet->prophesize(File::class);
        $file->getFileContent()->willReturn(
            <<<EOT
There's is no title for this markdown file
EOT
        );
        $file->getFileNameWithoutExtension($config->getDocsExtension())->willReturn('1.file');

        $tableOfContents->prepare([$file->reveal()]);

        $items = $tableOfContents->getMenuItems();
        $this->assertEquals(1, count($items));
        $this->assertEquals('file', $items[0]->title);
    }

    public function testItCalculatesCorrectDepth()
    {
        $config = $this->getConfig();
        $tableOfContents = new TableOfContents($config);

        $file = $this->prophet->prophesize(File::class);
        $file->getFileContent()->willReturn(
            <<<EOT
# My Title
EOT
        );
        $file->getFileNameWithoutExtension($config->getDocsExtension())->willReturn('1.1.1.file');

        $tableOfContents->prepare([$file->reveal()]);
        $items = $tableOfContents->getMenuItems();
        $this->assertEquals(3, $items[0]->depth);
    }
}