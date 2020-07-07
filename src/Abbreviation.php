<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Inline\Element\AbstractInline;

class Abbreviation extends AbstractInline
{
    private $abbr = "";
    private $title = "";

    public function __construct(string $abbr, string $title)
    {
        $this->abbr = $abbr;
        $this->title = $title;
    }

    public function isContainer(): bool
    {
        return true;
    }

    public function element()
    {
        return '<abbr title="'. $this->title .'">'. $this->abbr .'</abbr>';
    }
}
