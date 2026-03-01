<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;

return RectorConfig::configure()
    ->withSkip([PreferPHPUnitThisCallRector::class])
    ->withPaths([__DIR__.'/src', __DIR__.'/tests'])
    ->withPhpSets()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        rectorPreset: true,
        phpunitCodeQuality: true,
    )
    ->withRootFiles()
    ->withAttributesSets(phpunit: true)
    ->withImportNames(importShortClasses: false, removeUnusedImports: true)
    ->withComposerBased(phpunit: true)
    ->withFluentCallNewLine()
;
