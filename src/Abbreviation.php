<?php

namespace Eightfold\CommonmarkAbbreviations;

use League\CommonMark\Inline\Element\AbstractInline;

use Eightfold\Markup\UIKit;

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
        return UIKit::abbr($this->abbr)->attr("title ". $this->title)->unfold();
    }
}
