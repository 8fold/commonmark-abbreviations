<?php

namespace Eightfold\CommonMarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAbbreviations\AbbreviationExtension;

class AbbreviationTest extends TestCase
{
    public function testParser()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AbbreviationExtension());
        $converter = new CommonMarkConverter([], $environment);

        $path = Shoop::string(__DIR__)->plus("/short-doc.md");
        $markdown = file_get_contents($path);
        $expected = '<p><abbr title="United States Web Design System">USWDS</abbr></p>'."\n";
        $actual = $converter->convertToHtml($markdown);
        $this->assertEquals($expected, $actual);

        $path = Shoop::string(__DIR__)->divide("/")
            ->dropLast()->plus("readme.html")->join("/")->start("/");
        $expected = file_get_contents($path);

        $path = Shoop::string(__DIR__)->divide("/")
            ->dropLast()->plus("README.md")->join("/")->start("/");
        $markdown = file_get_contents($path);

        $actual = $converter->convertToHtml($markdown);
        $this->assertEquals($expected, $actual);
    }
}
