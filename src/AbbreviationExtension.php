<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

use Eightfold\CommonMarkAbbreviations\Abbreviation;
use Eightfold\CommonMarkAbbreviations\AbbreviationRenderer;
use Eightfold\CommonMarkAbbreviations\AbbreviationInlineParser;

class AbbreviationExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new AbbreviationInlineParser(), 100);
        $environment->addInlineRenderer(Abbreviation::class, new AbbreviationRenderer());
    }
}
