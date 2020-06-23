<?php

namespace Eightfold\CommonmarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment;
use League\CommonMark\CommonMarkConverter;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonmarkAbbreviations\AbbreviationExtension;

class AbbreviationTest extends TestCase
{
    public function testParser()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new AbbreviationExtension());

        $path = Shoop::string(__DIR__)->plus("/readme.html");
        $expected = file_get_contents($path);

        $path = Shoop::string(__DIR__)->divide("/")
            ->dropLast()->plus("README.md")->join("/")->start("/");
        $markdown = file_get_contents($path);
        $converter = new CommonMarkConverter([], $environment);
        $actual = $converter->convertToHtml($markdown);

        $this->assertEquals($expected, $actual);
    }
}