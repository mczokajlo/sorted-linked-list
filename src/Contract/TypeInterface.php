<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Contract;

/**
 * @api
 *
 * @template TValue
 */
interface TypeInterface
{
    /**
     * @param TValue $left
     * @param TValue $right
     */
    public function compareValues(mixed $left, mixed $right): int;

    public function supports(mixed $value): bool;
}
