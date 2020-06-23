<?php

namespace Eightfold\CommonmarkAbbreviations;

use Eightfold\Shoop\Shoop;

use League\CommonMark\Inline\Parser\InlineParserInterface;
use League\CommonMark\InlineParserContext;

use Eightfold\CommonmarkAbbreviations\Abbreviation;

class AbbreviationInlineParser implements InlineParserInterface
{
    public function getCharacters(): array
    {
        return ["~"];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $previousChar = $cursor->peek(-1);
        if ($previousChar !== null and $previousChar !== " ") {
            return false;
        }

        $nextChar = $cursor->peek(1);
        if ($nextChar !== null and $nextChar !== "[") {
            return false;
        }

        $previousCursor = $cursor->saveState();
        $regex = '/^~\[.+?\]\(.+?\)/';
        $abbr = $cursor->match($regex);
        if (empty($abbr)) {
            $cursor->restoreState($previousCursor);
            return false;
        }

        list($abbr, $title) = Shoop::string($abbr)->dropFirst(2)->dropLast()
            ->divide("](", false, 2);
        $elem = new Abbreviation($abbr, $title);

        $inlineContext->getContainer()->appendChild($elem);

        return true;
    }
}
