<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Contract;

use IteratorAggregate;

/**
 * @api
 *
 * @template TKey of int
 * @template TValue of int|string
 *
 * @template-extends IteratorAggregate<TKey, TValue>
 */
interface SortedLinkedListInterface extends \IteratorAggregate
{
    /**
     * @param TValue $value
     *
     * @return self<TKey, TValue>
     */
    public function insert(int|string $value): self;

    /**
     * @param TValue $value
     */
    public function remove(int|string $value): bool;

    /**
     * @return TValue
     */
    public function first(): int|string;

    public function isEmpty(): bool;
}
