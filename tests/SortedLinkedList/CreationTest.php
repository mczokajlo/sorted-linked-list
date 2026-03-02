<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Exception\EmptyListException;
use Mczokajlo\SortedLinkedList\Node;
use Mczokajlo\SortedLinkedList\SortedLinkedList;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SortedLinkedList::class)]
#[CoversClass(EmptyListException::class)]
#[CoversClass(Node::class)]
final class CreationTest extends TestCase
{
    public function testNewListIsEmpty(): void
    {
        /** @When */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /* @Then */
        self::assertTrue($sortedLinkedList->isEmpty());
    }

    public function testGetIteratorOnEmptyList(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** @When */
        $result = iterator_to_array($sortedLinkedList->getIterator(), true);

        /* @Then */
        self::assertSame([], $result);
    }

    public function testNewListHaseNoHead(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /* @Then */
        $this->expectException(EmptyListException::class);

        /** @When */
        $sortedLinkedList->first();
    }
}
