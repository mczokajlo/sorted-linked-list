<?php

declare(strict_types=1);

use Symplify\EasyCodingStandard\Config\ECSConfig;
use Symplify\EasyCodingStandard\ValueObject\Option;

return ECSConfig::configure()
    ->withPaths([__DIR__ . '/src', __DIR__ . '/tests'])
    ->withRootFiles()
    ->withPreparedSets(psr12: true, common: true, symplify: true, strict: true, cleanCode: true)
    ->withPhpCsFixerSets(perCS30: true, perCS30Risky: true)
    ->withSpacing(indentation: Option::INDENTATION_SPACES, lineEnding: \PHP_EOL)
;
