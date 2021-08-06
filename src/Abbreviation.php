<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Node\Inline\AbstractStringContainer;
use League\CommonMark\Util\HtmlElement;

class Abbreviation extends AbstractStringContainer
{

    public function isContainer(): bool
    {
        return true;
    }

    public function element()
    {
        return new HtmlElement('abbr', $this->data->get("attributes"), $this->getLiteral());
    }
}
