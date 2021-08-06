<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\InlineParserContext;
use League\CommonMark\Parser\Inline\InlineParserMatch;

use Eightfold\CommonMarkAbbreviations\Abbreviation;

class AbbreviationInlineParser implements InlineParserInterface
{
    public function getMatchDefinition(): InlineParserMatch
    {
        // Would limiting the character set for attributes make this safer?
        // Would someone want or need characters beyond alnum, _, -, =, and "?
        return InlineParserMatch::regex('\[\..+?\]\(.+?\)(\{.+?\})?');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $base = $inlineContext->getMatches();

        $abbr = $base[0];

        // account for attributes extension
        if (count($base) > 1) {
            $attributes = $base[1];

            $abbr = str_replace($attributes, "", $abbr);

        }

        $inlineContext->getCursor()->advanceBy(strlen($abbr));

        $abbr = substr($abbr, 2);
        $abbr = substr($abbr, 0, -1);

        list($abbr, $title) = explode("](", $abbr, 2);

        $elem = new Abbreviation($abbr, ['attributes' => ['title' => $title]]);

        $inlineContext->getContainer()->appendChild($elem);

        return true;
    }
}
