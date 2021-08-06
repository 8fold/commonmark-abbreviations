<?php

namespace Eightfold\CommonMarkAbbreviations\Tests;

use PHPUnit\Framework\TestCase;

use League\CommonMark\Environment\Environment;
use League\CommonMark\MarkdownConverter;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAbbreviations\Abbreviation;
use Eightfold\CommonMarkAbbreviations\AbbreviationExtension;

class AbbreviationAttributesTest extends TestCase
{
    /**
     * @group attributes
     */
    public function testParser()
    {
        $config = [
            "external_link" => ["open_in_new_window" => true]
        ];

        $environment = (new Environment($config))
            ->addExtension(new CommonMarkCoreExtension())
            ->addExtension(new AbbreviationExtension())
            ->addExtension(new AttributesExtension())
            ->addExtension(new ExternalLinkExtension())
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

        $converter = new MarkdownConverter($environment);

        $path = Shoop::this(__DIR__)->append("/short-doc-attributes.md");

        $markdown = file_get_contents($path);

        $expected = '<p><abbr title="United States Web Design System" data-event-attribute="hello" data-inline-attribute="hello">USWDS</abbr></p>'."\n".'<p><a rel="noopener noreferrer" target="_blank" href="https://8fold.pro">External link check</a></p>'."\n";

        $actual = $converter->convertToHtml($markdown)->getContent();

        $this->assertEquals($expected, $actual);
    }
}
