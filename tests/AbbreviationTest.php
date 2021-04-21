<?php

namespace Eightfold\CommonMarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAbbreviations\AbbreviationExtension;

class AbbreviationTest extends TestCase
{
    public function testParser()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AbbreviationExtension());
        $environment->addExtension(new ExternalLinkExtension());
        $converter = new CommonMarkConverter([
            "external_link" => ["open_in_new_window" => true]
        ], $environment);

        $path = Shoop::this(__DIR__)->append("/short-doc.md");
        $markdown = file_get_contents($path);
        $expected = '<p><abbr title="United States Web Design System">USWDS</abbr></p>'."\n".'<p><a rel="noopener noreferrer" target="_blank" href="https://8fold.pro">External link check</a></p>'."\n";
        $actual = $converter->convertToHtml($markdown);
        $this->assertEquals($expected, $actual);

        $path = Shoop::this(__DIR__)->divide("/")
            ->dropLast()->append(["readme.html"])->asString("/");
        $expected = file_get_contents($path);

        $path = Shoop::this(__DIR__)->divide("/")
            ->dropLast()->append(["README.md"])->asString("/");
        $markdown = file_get_contents($path);

        $actual = $converter->convertToHtml($markdown);
        $this->assertEquals($expected, $actual);
    }
}
