<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Exception;

final class TypeMismatchException extends SortedLinkedListException
{
    public static function create(string $type): self
    {
        return new self(\sprintf('Invalid type %s given', $type));
    }
}
