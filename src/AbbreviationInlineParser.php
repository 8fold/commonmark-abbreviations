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
        return InlineParserMatch::regex('\[\..+?\]\(.+?\)');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $previousChar = $cursor->peek(-1);
        if ($previousChar !== null and $previousChar !== ' ') {
            return false;
        }

        $cursor->advanceBy($inlineContext->getFullMatchLength());

        $abbr = $inlineContext->getFullMatch();
        $abbr = substr($abbr, 2);
        $abbr = substr($abbr, 0, -1);

        list($abbr, $title) = explode("](", $abbr, 2);

        $elem = new Abbreviation($abbr, ['attributes' => ['title' => $title]]);

        $inlineContext->getContainer()->appendChild($elem);

        return true;
    }
}
