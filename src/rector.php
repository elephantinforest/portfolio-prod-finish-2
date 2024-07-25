<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/controller',
        __DIR__ . '/core',
        __DIR__ . '/models',
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/web',
    ])
    // uncomment to reach your current PHP version
    // ->withPhpSets()
    ->withTypeCoverageLevel(0);
