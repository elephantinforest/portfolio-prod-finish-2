<?php

declare(strict_types=1);
require_once __DIR__ . '/vendor/autoload.php';

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use RectorRules\UnderscoreToCamelCaseVariableNameRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([
        __DIR__ . '/controller',
        __DIR__ . '/core',
        __DIR__ . '/models',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/web',
    ]);

    // PHP version set (uncomment if needed)
    // $rectorConfig->phpVersion(PhpVersion::PHP_80);

    // Register custom rule
    $rectorConfig->rule(UnderscoreToCamelCaseVariableNameRector::class);

    // Include other rulesets if necessary
    // $rectorConfig->sets([LevelSetList::UP_TO_PHP_80]);
};
