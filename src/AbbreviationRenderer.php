<?php

namespace Eightfold\CommonMarkAbbreviations;

// use League\CommonMark\ElementRendererInterface;
use League\CommonMark\Node\Node;
// use League\CommonMark\HtmlElement;
// use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

// use League\CommonMark\Inline\Renderer\InlineRendererInterface;

use Eightfold\Shoop\Shoop;

use Eightfold\CommonMarkAbbreviations\Abbreviation;


class AbbreviationRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        if (! ($node instanceof Abbreviation)) {
            throw new \InvalidArgumentException('Incompatible inline type: ' . get_class($node));
        }
        return $node->element();
    }
}
