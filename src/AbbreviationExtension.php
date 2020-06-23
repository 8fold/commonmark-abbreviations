<?php

namespace Eightfold\CommonmarkAbbreviations;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\ConfigurableEnvironmentInterface;

use Eightfold\CommonmarkAbbreviations\Abbreviation;
use Eightfold\CommonmarkAbbreviations\AbbreviationRenderer;
use Eightfold\CommonmarkAbbreviations\AbbreviationInlineParser;

class AbbreviationExtension implements ExtensionInterface
{
    public function register(ConfigurableEnvironmentInterface $environment)
    {
        $environment->addInlineParser(new AbbreviationInlineParser());
        $environment->addInlineRenderer(Abbreviation::class, new AbbreviationRenderer());
    }
}
