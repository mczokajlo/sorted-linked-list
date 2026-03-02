<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Exception\TypeMismatchException;
use Mczokajlo\SortedLinkedList\Node;
use Mczokajlo\SortedLinkedList\SortedLinkedList;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SortedLinkedList::class)]
#[CoversClass(TypeMismatchException::class)]
#[CoversClass(Node::class)]
final class InsertTest extends TestCase
{
    public function testInsert(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** @When */
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(3);
        $sortedLinkedList->insert(7);

        /** Then */
        self::assertSame([3, 5, 7], iterator_to_array($sortedLinkedList->getIterator(), true));
        self::assertSame(3, $sortedLinkedList->first());
    }

    public function testInsertIntoSingleElementList(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(3);

        /** @When */
        $sortedLinkedList->insert(5);

        /** Then */
        self::assertSame([3, 5], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testInsertInMiddleOfList(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(3);
        $sortedLinkedList->insert(9);

        /** @When */
        $sortedLinkedList->insert(5);

        /** Then */
        self::assertSame([3, 5, 9], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testInsertInMiddleAfterTraversal(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(3);
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(9);

        /** @When */
        $sortedLinkedList->insert(7);

        /** Then */
        self::assertSame([3, 5, 7, 9], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testErrorWhenInsertingWrongType(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** @Then */
        $this->expectException(TypeMismatchException::class);

        /** @When */
        $sortedLinkedList->insert('7'); // @phpstan-ignore argument.type (testing runtime type validation)
    }

    public function testIsNotEmptyAfterInsert(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** @When */
        $sortedLinkedList->insert(5);

        /* @Then */
        self::assertFalse($sortedLinkedList->isEmpty());
    }
}
