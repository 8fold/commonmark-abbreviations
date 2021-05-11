<?php

namespace Eightfold\CommonMarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;
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
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AbbreviationExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $environment->addExtension(new HeadingPermalinkExtension());
        $environment->addExtension(new TableOfContentsExtension());
        $converter = new CommonMarkConverter([
            "external_link" => ["open_in_new_window" => true]
        ], $environment);

        $path = Shoop::this(__DIR__)->append("/short-doc-abstract-string-container.md");
        $markdown = \file_get_contents($path);
        $expected = \file_get_contents("short-doc-abstract-string-container.html");
        $actual = $converter->convertToHtml($markdown);
        $this->assertEquals($expected, $actual);

        $path = Shoop::this(__DIR__)->divide("/")
            ->dropLast()->append(["readme.html"])->asString("/");
        $expected = \file_get_contents($path);

        $path = Shoop::this(__DIR__)->divide("/")
            ->dropLast()->append(["README.md"])->asString("/");
        $markdown = \file_get_contents($path);

        $actual = $converter->convertToHtml($markdown);
        $this->assertEquals($expected, $actual);
    }
}
