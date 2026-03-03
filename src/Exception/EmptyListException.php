<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Exception;

/**
 * @api
 */
final class EmptyListException extends SortedLinkedListException
{
    public static function create(string $method): self
    {
        return new self(\sprintf('Cannot call %s() on an empty list.', $method));
    }
}
