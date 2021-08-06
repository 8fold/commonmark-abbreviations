<?php

namespace Eightfold\CommonMarkAbbreviations;

use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;

use League\CommonMark\Extension\ExtensionInterface;
use League\CommonMark\Environment\EnvironmentBuilderInterface;

use Eightfold\CommonMarkAbbreviations\Abbreviation;
use Eightfold\CommonMarkAbbreviations\AbbreviationRenderer;
use Eightfold\CommonMarkAbbreviations\AbbreviationInlineParser;

class AbbreviationExtension implements ExtensionInterface
{
    public function register(EnvironmentBuilderInterface $environment): void
    {
        $environment
            ->addInlineParser(new AbbreviationInlineParser(), 100)
            ->addRenderer(Abbreviation::class, new AbbreviationRenderer());
    }
}
