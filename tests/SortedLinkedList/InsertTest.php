<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Exception\TypeMismatchException;
use Mczokajlo\SortedLinkedList\Node;
use Mczokajlo\SortedLinkedList\SortedLinkedList;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\UsesClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SortedLinkedList::class)]
#[CoversClass(TypeMismatchException::class)]
#[UsesClass(Node::class)]
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

    public function testErrorWhenInsertingWrongType(): void
    {
        /** @Given */
        $sortedLinkedList = new SortedLinkedList(type: new TestType());

        /** @Then */
        $this->expectException(TypeMismatchException::class);

        /** @When */
        $sortedLinkedList->insert('7'); // @phpstan-ignore argument.type (testing runtime type validation)
    }
}
