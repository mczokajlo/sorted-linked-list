<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList;

/**
 * @internal
 *
 * @template TValue
 */
final class Node
{
    /**
     * @param TValue $value
     * @param self<TValue>|null $next
     */
    public function __construct(
        public readonly mixed $value,
        public ?self $next = null,
    ) {}
}
