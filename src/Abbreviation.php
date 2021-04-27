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

    /**
     * Get the abbreviation, e.g. "HTML".
     *
     * @return string
     */
    public function getAbbreviation(): string
    {
        return $this->abbr;
    }

    /**
     * Set the abbreviation, e.g. "HTML".
     *
     * @param string $abbr
     */
    public function setAbbreviation(string $abbr): void
    {
        $this->abbr = $abbr;
    }

    /**
     * Get the full form of the abbreviation, e.g "HyperText Markup Language".
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the full form of the abbreviation, e.g "HyperText Markup Language".
     *
     * @param string $title
     */
    public function setTitle(string $title): void
    {
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
