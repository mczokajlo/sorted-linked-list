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
final class RemoveTest extends TestCase
{
    public function testRemoveFromEmptyList(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** @When */
        $result = $sortedLinkedList->remove(5);

        /** Then */
        self::assertFalse($result);
    }

    public function testRemoveNoValidType(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** Then */
        $this->expectException(TypeMismatchException::class);

        /** @When */
        $sortedLinkedList->remove('5'); // @phpstan-ignore argument.type (testing runtime type validation)
    }

    public function testRemoveValue(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(7);
        $sortedLinkedList->insert(9);

        /** @When */
        $result = $sortedLinkedList->remove(7);

        /** Then */
        self::assertTrue($result);
        self::assertSame(5, $sortedLinkedList->first());
        self::assertSame([5, 9], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testRemoveFirtsValue(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(7);
        $sortedLinkedList->insert(9);

        /** @When */
        $result = $sortedLinkedList->remove(5);

        /** Then */
        self::assertTrue($result);
        self::assertSame(7, $sortedLinkedList->first());
        self::assertSame([7, 9], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testRemoveLastValue(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(7);
        $sortedLinkedList->insert(9);

        /** @When */
        $result = $sortedLinkedList->remove(9);

        /** Then */
        self::assertTrue($result);
        self::assertSame(5, $sortedLinkedList->first());
        self::assertSame([5, 7], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testRemoveNonExistentValue(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(7);
        $sortedLinkedList->insert(9);

        /** @When */
        $result = $sortedLinkedList->remove(11);

        /** Then */
        self::assertFalse($result);
        self::assertSame([5, 7, 9], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testRemoveNonExistentFromSingleElementList(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(5);

        /** @When */
        $result = $sortedLinkedList->remove(11);

        /** Then */
        self::assertFalse($result);
        self::assertSame([5], iterator_to_array($sortedLinkedList->getIterator(), true));
    }

    public function testRemoveAllValues(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());
        $sortedLinkedList->insert(5);
        $sortedLinkedList->insert(7);
        $sortedLinkedList->insert(9);

        /** @When */
        $sortedLinkedList->remove(5);
        $sortedLinkedList->remove(7);
        $sortedLinkedList->remove(9);

        /** Then */
        self::assertTrue($sortedLinkedList->isEmpty());
        self::assertSame([], iterator_to_array($sortedLinkedList->getIterator(), true));
    }
}
