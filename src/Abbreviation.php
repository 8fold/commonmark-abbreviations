<?php
declare(strict_types=1);

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Node\Inline\AbstractStringContainer;

use League\CommonMark\Util\HtmlElement;

class Abbreviation extends AbstractStringContainer
{
    public function isContainer(): bool
    {
        return true;
    }

    public function element(): HtmlElement
    {
        $attributes = [];
        $attrs = $this->data->get("attributes");
        if (is_array($attrs)) {
            foreach ($attrs as $key => $value) {
                if (is_string($key) and is_string($value)) {
                    $attributes[$key] = $value;

                }
            }
        }

        return new HtmlElement(
            'abbr',
            $attributes,
            $this->getLiteral()
        );
    }
}
