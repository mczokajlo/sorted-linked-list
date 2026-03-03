<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Contract;

use IteratorAggregate;

/**
 * @api
 *
 * @template TValue
 *
 * @template-extends IteratorAggregate<int, TValue>
 */
interface SortedLinkedListInterface extends IteratorAggregate
{
    /**
     * @param TValue $value
     *
     * @return self<TValue>
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
