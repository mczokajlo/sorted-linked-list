<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList;

use Generator;
use Mczokajlo\SortedLinkedList\Contract\SortedLinkedListInterface;
use Mczokajlo\SortedLinkedList\Contract\TypeInterface;
use Mczokajlo\SortedLinkedList\Exception\EmptyListException;
use Mczokajlo\SortedLinkedList\Exception\TypeMismatchException;

/**
 * @api
 *
 * @template TValue
 *
 * @implements SortedLinkedListInterface<TValue>
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

        if (! $this->node instanceof Node) {
            $this->node = $newNode;

            return $this;
        }

        if ($this->comesBefore($value, $this->node->value)) {
            $newNode->next = $this->node;
            $this->node = $newNode;

            return $this;
        }

        $this->insertAfter($this->node, $newNode, $value);

        return $this;
    }

    public function remove(mixed $value): bool
    {
        $this->validateType($value);

        if (! $this->node instanceof Node) {
            return false;
        }

        if ($this->equals($value, $this->node->value)) {
            $this->node = $this->node->next;

            return true;
        }

        return $this->removeAfter($this->node, $value);
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
        return ! $this->node instanceof Node;
    }

    /**
     * @return Generator<int, TValue>
     */
    public function getIterator(): Generator
    {
        $current = $this->node;
        $index = 0;

        while ($current instanceof Node) {
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

    /**
     * @param TValue $newValue
     * @param TValue $existingValue
     */
    private function equals(mixed $newValue, mixed $existingValue): bool
    {
        return $this->type->compareValues($newValue, $existingValue) === 0;
    }

    private function validateType(mixed $value): void
    {
        if (! $this->type->supports($value)) {
            throw TypeMismatchException::create(type: gettype($value));
        }
    }

    /**
     * @param Node<TValue> $node
     * @param TValue $value
     */
    private function removeAfter(Node $node, mixed $value): bool
    {
        $current = $node;
        while ($current->next instanceof Node) {
            if ($this->equals($value, $current->next->value)) {
                $current->next = $current->next->next;

                return true;
            }

            $current = $current->next;
        }

        return false;
    }

    /**
     * @param Node<TValue> $start
     * @param Node<TValue> $newNode
     * @param TValue $value
     */
    private function insertAfter(Node $start, Node $newNode, mixed $value): void
    {
        $current = $start;
        while ($current->next instanceof Node) {
            if ($this->comesBefore($value, $current->next->value)) {
                break;
            }

            $current = $current->next;
        }

        $newNode->next = $current->next;
        $current->next = $newNode;
    }
}
