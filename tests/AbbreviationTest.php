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

class AbbreviationTest extends TestCase
{
    /**
     * @test
     * @group shortdoc
     */
    public function short_doc()
    {
        $expected = static::fileContents("short-doc.html");

        $markdown = static::fileContents("short-doc.md");

        $actual = static::converter()->convertToHtml($markdown)->getContent();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group readme
     */
    public function read_me()
    {
        $expected = static::fileContents("readme.html", static::projectBasePath());

        $markdown = static::fileContents("README.md", static::projectBasePath());

        $actual = static::converter()->convertToHtml($markdown)->getContent();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group attributes
     */
    public function attributes_extension_integration()
    {
        $markdown = '[.USWDS](United States Web Design System){data-inline-attribute="hello"}';

        $expected = '<p><abbr title="United States Web Design System" data-event-attribute="hello" data-inline-attribute="hello">USWDS</abbr></p>'."\n";

        $environment = static::basicEnvironment()
            ->addExtension(new AttributesExtension())
            ->addEventListener(DocumentParsedEvent::class, function (
                DocumentParsedEvent $event
            ) {
                $document = $event->getDocument();
                $walker = $document->walker();
                while ($event = $walker->next()) {
                    $node = $event->getNode();

                    // Ignore any nodes that aren't Abbreviation nodes, and only act
                    // when we first encounter/enter an Abbreviation node.
                    if (!($node instanceof Abbreviation) || !$event->isEntering()) {
                        continue;
                    }

                    // Add a test attribute. It's also possible to alter the
                    // existing attributes here.
                    $node->data->set("attributes.data-event-attribute", "hello");
                }
            });

        $actual = static::converter($environment)
            ->convertToHtml($markdown)->getContent();

        $this->assertEquals($expected, $actual);
    }

    /**
     * @test
     * @group shortdoc
     * @group stringcontainer
     */
    public function abstract_string_container_integration()
    {
        $expected = static::fileContents("short-doc-abstract-string-container.html");

        $markdown = static::fileContents("short-doc-abstract-string-container.md");

        $environment = static::basicEnvironment()
            ->addExtension(new HeadingPermalinkExtension())
            ->addExtension(new TableOfContentsExtension());

        $actual = static::converter($environment)
            ->convertToHtml($markdown)->getContent();

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
