<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Contract\TypeInterface;

/**
 * @template TValue of int
 * @implements TypeInterface<TValue>
 */
final class TestType implements TypeInterface
{
    public function compareValues(mixed $left, mixed $right): int
    {
        return $left <=> $right;
    }

    public function supports(mixed $value): bool
    {
        return is_int($value);
    }
}
