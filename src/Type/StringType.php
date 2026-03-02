<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Type;

use Mczokajlo\SortedLinkedList\Contract\TypeInterface;

/**
 * @template TValue of string
 * @implements TypeInterface<TValue>
 */
final readonly class StringType implements TypeInterface
{
    public function __construct(
        private Direction $direction,
    ) {}

    public function compareValues(mixed $left, mixed $right): int
    {
        $comparison = strcmp($left, $right);

        return match ($this->direction) {
            Direction::ASC => $comparison,
            Direction::DESC => $comparison * -1,
        };
    }

    public function supports(mixed $value): bool
    {
        return is_string($value);
    }
}
