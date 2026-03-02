<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Contract;

use IteratorAggregate;

/**
 * @api
 *
 * @template TKey of int
 * @template TValue
 *
 * @template-extends IteratorAggregate<TKey, TValue>
 */
interface SortedLinkedListInterface extends IteratorAggregate
{
    /**
     * @param TValue $value
     *
     * @return self<TKey, TValue>
     */
    public function insert(mixed $value): self;

    /**
     * @param TValue $value
     */
    public function remove(mixed $value): bool;

    /**
     * @return TValue
     */
    public function first(): mixed;

    public function isEmpty(): bool;
}
