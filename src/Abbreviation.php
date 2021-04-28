<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Inline\Element\AbstractInline;
use League\CommonMark\HtmlElement;

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
        $attributes = $this->getData('attributes', []);

        $attributes['title'] = $this->title;

        return new HtmlElement('abbr', $attributes, $this->abbr);
    }
}
