#!/usr/bin/env php
<?php

function init(array $argv): int
{
    $options = [
        'red' => "\e[31m",
        'default' => "\e[0m",
    ];

    $contents = file(__DIR__ . '/../README.md');

    $header = array_slice($contents, 0, 15);
    $footer = array_slice($contents, -5);
    $lines = array_slice($contents, 15, -5);

    if(end($header) !== "\n") {
        echo $options['red'] . "The README.md file needs to be corrected.\n" . $options['default'];
        return 1;
    }

    $collator = new \Collator('en_US');

    // Sort the array using PHP Intl Collator.
    $collator->asort($lines, \Collator::SORT_STRING);

    $result = array_merge($header, $lines, $footer);

    $original = implode('', $contents);
    $sorted = implode('', $result);

    file_put_contents(__DIR__ . '/../README.md', $sorted);

    if (0 === strcmp($original, $sorted)) {
        return 0;
    } else {
        echo $options['red'] . "The README.md file needs to be sorted alphabetically.\n" . $options['default'];
        return 1;
    }
}

exit(init($argv));
