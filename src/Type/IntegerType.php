<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Type;

use Mczokajlo\SortedLinkedList\Contract\TypeInterface;

/**
 * @template TValue of int
 * @implements TypeInterface<TValue>
 */
final readonly class IntegerType implements TypeInterface
{
    public function __construct(
        private Direction $direction,
    ) {}

    public function compareValues(mixed $left, mixed $right): int
    {
        $comparison = $left <=> $right;

        return match ($this->direction) {
            Direction::ASC => $comparison,
            Direction::DESC => $comparison * -1,
        };
    }

    public function supports(mixed $value): bool
    {
        return is_int($value);
    }
}
