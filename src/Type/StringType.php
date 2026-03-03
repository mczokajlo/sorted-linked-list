<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Type;

use Mczokajlo\SortedLinkedList\Contract\TypeInterface;

/**
 * @api
 *
 * @implements TypeInterface<string>
 */
final readonly class StringType implements TypeInterface
{
    public function __construct(
        private Direction $direction,
    ) {}

    public function compareValues(mixed $left, mixed $right): int
    {
        $comparison = strcmp($left, $right);

        if ($this->direction === Direction::DESC) {
            return $comparison * -1;
        }

        return $comparison;
    }

    public function supports(mixed $value): bool
    {
        return is_string($value);
    }
}
