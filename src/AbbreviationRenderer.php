<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;
use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Inline\Renderer\InlineRendererInterface;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAbbreviations\Abbreviation;


class AbbreviationRenderer implements InlineRendererInterface
{
    public function render(AbstractInline $inline, ElementRendererInterface $htmlRenderer)
    {
        if (! ($inline instanceof Abbreviation)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($inline));
        }
        return $inline->element();
    }
}
