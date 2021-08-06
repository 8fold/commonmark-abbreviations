<?php

namespace Eightfold\CommonMarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

// use League\CommonMark\Environment;
// use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAbbreviations\Abbreviation;
use Eightfold\CommonMarkAbbreviations\AbbreviationExtension;

/**
 * Tests that CommonMark recognizes Abbreviation as AbstractStringContainer.
 *
 * The table of contents extension will automatically convert any instances of
 * AbstractStringContainer to just their text contents, essentially stripping
 * any markup from the headings themselves. This tests that the plain text (in
 * this case the abbreviation) is output correctly.
 */
class AbbreviationAbstractStringContainerTest extends TestCase
{
    public function testParser()
    {
        $config = [
            "external_link" => ["open_in_new_window" => true]
        ];

        $environment = (new Environment($config))
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new AbbreviationExtension())
            ->addExtension(new ExternalLinkExtension())
            ->addExtension(new HeadingPermalinkExtension())
            ->addExtension(new TableOfContentsExtension());

        $converter = new MarkdownConverter($environment);

        $markdownPath = Shoop::this(__DIR__)
            ->append("/short-doc-abstract-string-container.md");
        $markdown = \file_get_contents($markdownPath);

        $htmlPath = Shoop::this(__DIR__)
            ->append("/short-doc-abstract-string-container.html");
        $expected = \file_get_contents($htmlPath);

        $actual = $converter->convertToHtml($markdown)->getContent();

        $this->assertEquals($expected, $actual);

        // $path = Shoop::this(__DIR__)->divide("/")
        //     ->dropLast()->append(["readme.html"])->asString("/");
        // $expected = \file_get_contents($path);

        // $path = Shoop::this(__DIR__)->divide("/")
        //     ->dropLast()->append(["README.md"])->asString("/");
        // $markdown = \file_get_contents($path);

        // $actual = $converter->convertToHtml($markdown);
        // $this->assertEquals($expected, $actual);
    }
}
