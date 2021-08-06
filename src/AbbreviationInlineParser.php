<?php

namespace Eightfold\CommonMarkAbbreviations;

use Eightfold\Shoop\Shoop;

use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\InlineParserContext;
use League\CommonMark\Parser\Inline\InlineParserMatch;

use Eightfold\CommonMarkAbbreviations\Abbreviation;

class AbbreviationInlineParser implements InlineParserInterface
{
    // public function getCharacters(): array
    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex('\[\..+?\]\(.+?\)');
        // return ["["];
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();
        $previousChar = $cursor->peek(-1);
        if ($previousChar !== null and $previousChar !== ' ') {
            return false;
        }

        $cursor->advanceBy($inlineContext->getFullMatchLength());
        // $nextChar = $cursor->peek();
        // if ($nextChar !== null and $nextChar !== ".") {
        //     return false;
        // }

        // $previousCursor = $cursor->saveState();

        // $regex = '/^\[\..+?\]\(.+?\)/';
        // $abbr = $cursor->match($regex);

        // if (empty($abbr)) {
        //     $cursor->restoreState($previousCursor);
        //     return false;
        // }

        $abbr = $inlineContext->getFullMatch();
        $abbr = substr($abbr, 2);
        $abbr = substr($abbr, 0, -1);

        list($abbr, $title) = explode("](", $abbr, 2);

        $elem = new Abbreviation($abbr, ['attributes' => ['title' => $title]]);
// die(var_dump($elem));
        $inlineContext->getContainer()->appendChild($elem);
        // die(var_dump($inlineContext));
        return true;
    }
}
