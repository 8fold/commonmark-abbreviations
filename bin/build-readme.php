#!/usr/bin/env php
<?php

declare(strict_types=1);

$root = dirname(__DIR__);

if (! file_exists($root . '/vendor/autoload.php')) {
    fwrite(STDERR, "Error: autoload.php not found. Run 'composer install' first.\n");
    exit(1);
}

require_once $root . '/vendor/autoload.php';

use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

use Eightfold\CommonMarkAbbreviations\AbbreviationExtension;

$inputFile  = $root . '/README.md';
$outputFile = $root . '/README.html';

if (! file_exists($inputFile)) {
    fwrite(STDERR, "Error: Source file not found: {$inputFile}\n");
    exit(1);
}

$markdown = file_get_contents($inputFile);
if ($markdown === false) {
    fwrite(STDERR, "Error: Source file not read: {$outputFile}\n");
    exit(1);
}

// Configure CommonMark with GitHub Flavored Markdown + your extension
$config = [
    'html_input' => 'allow',
    'allow_unsafe_links' => false,
];

$environment = new Environment($config);
$environment->addExtension(new CommonMarkCoreExtension());
$environment->addExtension(new GithubFlavoredMarkdownExtension());

$environment->addExtension(new AbbreviationExtension());

$converter = new MarkdownConverter($environment);

$renderedContent = $converter->convert($markdown)->getContent();

// Wrap in HTML template
$htmlDocument = <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>README</title>
</head>
<body>
{$renderedContent}
</body>
</html>
HTML;

if (file_put_contents($outputFile, $htmlDocument) === false) {
    fwrite(STDERR, "Error: Failed to write to {$outputFile}\n");
    exit(1);
}

echo "Successfully converted {$inputFile} -> {$outputFile}\n";
exit(0);
