<?php
declare(strict_types=1);

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Renderer\NodeRendererInterface;

use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;

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
