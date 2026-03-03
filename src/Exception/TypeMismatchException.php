<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Exception;

final class TypeMismatchException extends SortedLinkedListException
{
    public static function create(string $expectedType, string $actualType): self
    {
        return new self(\sprintf('Expected value of type %s, got %s', $expectedType, $actualType));
    }
}
