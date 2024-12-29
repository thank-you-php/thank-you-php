#!/usr/bin/env php
<?php

declare(strict_types=1);

// Check requirements.
(static function () {
    if (PHP_VERSION_ID < 80300) {
        fwrite(
            STDERR,
            'Error: This script requires PHP 8.3 or greater. Please update '
            . "your PHP version.\n",
        );

        exit(1);
    }

    // Check required PHP extensions.
    $missingExtensions = [];

    foreach (['intl'] as $extension) {
        if (!extension_loaded($extension)) {
            $missingExtensions[] = $extension;
        }
    }

    if ([] !== $missingExtensions) {
        fwrite(
            STDERR,
            sprintf(
                "Error: Missing PHP extensions: %s.\n",
                implode(', ', $missingExtensions),
            ),
        );

        exit(1);
    }
})();

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

    if ("\n" !== end($header)) {
        echo $options['red'] . "The README.md file needs to be corrected.\n" . $options['default'];

        return 1;
    }

    $collator = new Collator('en_US');

    // Sort the array using PHP Intl Collator.
    $collator->asort($lines, Collator::SORT_STRING);

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
