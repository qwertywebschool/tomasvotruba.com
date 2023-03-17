<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

function fast_markdown(string $markdownContents): string
{
    /** @var Parsedown $parsedown */
    $parsedown = app(Parsedown::class);

    return $parsedown->parse($markdownContents);
}