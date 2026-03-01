<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Contract\SortedLinkedListInterface;

/**
 * @api
 *
 * @template TKey of int
 * @template TValue of int|string
 *
 * @implements SortedLinkedListInterface<TKey, TValue>
 */
final readonly class SortedLinkedList implements SortedLinkedListInterface
{
    private function __construct(
        public Type $type,
        public Direction $direction = Direction::ASC,
    ) {}

    /**
     * @api
     *
     * @return self<TKey, int>
     */
    public static function ofIntegers(Direction $direction = Direction::ASC): self
    {
        /** @var self<TKey, int> */
        return new self(type: Type::INTEGER, direction: $direction);
    }

    /**
     * @api
     *
     * @return self<TKey, string>
     */
    public static function ofStrings(Direction $direction = Direction::ASC): self
    {
        /** @var self<TKey, string> */
        return new self(type: Type::STRING, direction: $direction);
    }

    public function insert(int|string $value): SortedLinkedListInterface
    {
        return $this;
    }

    public function remove(int|string $value): bool
    {
        return false;
    }

    public function first(): int|string
    {
        throw new \UnderflowException('List is empty');
    }

    public function isEmpty(): bool
    {
        return true;
    }

    public function getIterator(): \Traversable
    {
        return new \EmptyIterator();
    }
}
