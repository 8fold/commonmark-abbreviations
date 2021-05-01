<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Inline\Element\AbstractStringContainer;
use League\CommonMark\HtmlElement;

class Abbreviation extends AbstractStringContainer
{

    public function isContainer(): bool
    {
        return true;
    }

    public function element()
    {
        $attributes = $this->getData('attributes', []);

        return new HtmlElement('abbr', $attributes, $this->content);
    }
}
