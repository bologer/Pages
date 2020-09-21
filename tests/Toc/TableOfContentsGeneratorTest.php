<?php


namespace Bologer\Tests\Toc;


use Bologer\Config;
use Bologer\Dto\File;
use Bologer\Toc\MenuItem;
use Bologer\Toc\TableOfContents;
use Bologer\Toc\TableOfContentsGenerator;
use PHPUnit\Framework\TestCase;
use Prophecy\Prophet;

class TableOfContentsGeneratorTest extends TestCase
{
    private Prophet $prophet;

    protected function setUp(): void
    {
        $this->prophet = new \Prophecy\Prophet;
    }

    public function testGeneratesSingleMenuItemCorrectly()
    {
        $toc = $this->prophet->prophesize(TableOfContents::class);
        $toc->getMenuItems()->willReturn([
            new MenuItem('My title', 'file', new File('/path/to/file.md'), 1)
        ]);
        $generator = new TableOfContentsGenerator($toc->reveal());
        $this->assertEquals(
            '<ul><li data-depth="1"><a href="file.html">My title</a></li></ul>',
            $generator->generate()
        );
    }

    public function testGeneratesManyMenuItemsCorrectly()
    {
        $toc = $this->prophet->prophesize(TableOfContents::class);
        $generator = new TableOfContentsGenerator($toc->reveal());

        $toc->getMenuItems()->willReturn([
            new MenuItem('Intro', 'intro', new File('/path/to/intro.md'), 1),
            new MenuItem('Usage', 'usage', new File('/path/to/usage.md'), 2)
        ]);

        $this->assertEquals(
            '<ul><li data-depth="1"><a href="intro.html">Intro</a></li><li data-depth="2"><a href="usage.html">Usage</a></li></ul>',
            $generator->generate()
        );
    }
}