<?php
declare(strict_types=1);

namespace Eightfold\CommonMarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Event\DocumentParsedEvent;

use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;

use Eightfold\CommonMarkAbbreviations\Abbreviation;
use Eightfold\CommonMarkAbbreviations\AbbreviationExtension;

class DefectTest extends TestCase
{
    /**
     * @test
     * @group defect
     */
    public function deleting_first_letter_of_following_word()
    {
        // getting: <p>From what I understand, the <abbr title="Standards and Poorʼs 500 index">S&P 500</abbr>officially entered bear market status.</p>
        // or (if using prime not apostrophe) <p>From what I understand, the <abbr title="Standards and Poorʼs 500 index">S&P 500</abbr>fficially entered bear market status.</p>
        $expected = <<<html
            <p>From what I understand, the <abbr title="Standards and Poorʼs 500 index">S&P 500</abbr> officially entered bear market status.</p>
            html;

        $markdown = <<<md
            From what I understand, the [.Standards and Poorʼs 500 index](S&P 500) officially entered bear market status.
            md;

        $actual = static::converter()->convertToHtml($markdown)->getContent();

        $this->assertEquals($expected, $actual);
    }

// -> Conveniences
    static private function converter(Environment $environment = null)
    {
        if ($environment === null) {
            $environment = static::basicEnvironment();
        }
        return new MarkdownConverter($environment);
    }

    static private function basicEnvironment()
    {
        $config = [
            "external_link" => ["open_in_new_window" => true]
        ];

        return (new Environment($config))
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new AbbreviationExtension())
            ->addExtension(new ExternalLinkExtension());
    }

    static private function fileContents(string $fileName, string $basePath = "")
    {
        if (strlen($basePath) === 0) {
            $basePath = __DIR__;
        }
        return file_get_contents($basePath ."/". $fileName);
    }

    static private function projectBasePath()
    {
        $dir = __DIR__;
        $parts = explode("/", $dir);
        array_pop($parts);
        return implode("/", $parts);
    }
}
