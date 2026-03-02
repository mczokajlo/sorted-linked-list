<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Contract\SortedLinkedListInterface;
use Mczokajlo\SortedLinkedList\Contract\TypeInterface;
use Mczokajlo\SortedLinkedList\Exception\EmptyListException;
use Mczokajlo\SortedLinkedList\Exception\TypeMismatchException;

/**
 * @api
 *
 * @template TKey of int
 * @template TValue
 *
 * @implements SortedLinkedListInterface<TKey, TValue>
 */
final class SortedLinkedList implements SortedLinkedListInterface
{
    /**
     * @var Node<TValue>|null
     */
    private ?Node $node = null;

    /**
     * @param TypeInterface<TValue> $type
     */
    public function __construct(
        private readonly TypeInterface $type,
    ) {}

    public function insert(mixed $value): SortedLinkedListInterface
    {
        $this->validateType($value);

        /** @var Node<TValue> $newNode */
        $newNode = new Node($value);

        if (! $this->node instanceof Node || $this->comesBefore($value, $this->node->value)) {
            $newNode->next = $this->node;
            $this->node = $newNode;

            return $this;
        }

        $this->insertAfter($this->node, $newNode, $value);

        return $this;
    }

    private function validateType(mixed $value): void
    {
        if (! $this->type->supports($value)) {
            throw TypeMismatchException::create(type: gettype($value));
        }
    }

    /**
     * @param Node<TValue> $start
     * @param Node<TValue> $newNode
     * @param TValue $value
     */
    private function insertAfter(Node $start, Node $newNode, mixed $value): void
    {
        $current = $start;
        while ($current->next instanceof Node && ! $this->comesBefore($value, $current->next->value)) {
            $current = $current->next;
        }

        $newNode->next = $current->next;
        $current->next = $newNode;
    }

    public function remove(mixed $value): bool
    {
        return false;
    }

    public function first(): mixed
    {
        if ($this->node instanceof Node) {
            return $this->node->value;
        }

        throw EmptyListException::create(method: 'first');
    }

    public function isEmpty(): bool
    {
        return true;
    }

    /**
     * @return \Generator<TKey, TValue>
     */
    public function getIterator(): \Generator
    {
        $current = $this->node;
        $index = 0;

        while ($current instanceof Node) {
            /** @var TKey $index */
            yield $index => $current->value;
            $current = $current->next;
            ++$index;
        }
    }

    /**
     * @param TValue $newValue
     * @param TValue $existingValue
     */
    private function comesBefore(mixed $newValue, mixed $existingValue): bool
    {
        return $this->type->compareValues($newValue, $existingValue) <= 0;
    }
}
