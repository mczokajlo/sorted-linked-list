<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\SortedLinkedList;

use Mczokajlo\SortedLinkedList\Direction;
use Mczokajlo\SortedLinkedList\SortedLinkedList;
use Mczokajlo\SortedLinkedList\Type;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;

#[CoversClass(SortedLinkedList::class)]
final class CreationTest extends TestCase
{
    public function testOfIntegersCreatesIntegersAscList(): void
    {
        /** @When */
        $sortedLinkedList = SortedLinkedList::ofIntegers();

        // @Then
        self::assertSame(Type::INTEGER, $sortedLinkedList->type);
        self::assertSame(Direction::ASC, $sortedLinkedList->direction);
    }

    public function testOfIntegersDescCreatesIntegersDescList(): void
    {
        /** @When */
        $sortedLinkedList = SortedLinkedList::ofStrings(direction: Direction::DESC);

        // @Then
        self::assertSame(Type::STRING, $sortedLinkedList->type);
        self::assertSame(Direction::DESC, $sortedLinkedList->direction);
    }

    public function testOfStringsCreatesStringsAscList(): void
    {
        /** @When */
        $sortedLinkedList = SortedLinkedList::ofIntegers();

        // @Then
        self::assertSame(Type::INTEGER, $sortedLinkedList->type);
        self::assertSame(Direction::ASC, $sortedLinkedList->direction);
    }

    public function testOfStringsDescCreatesStringsDescList(): void
    {
        /** @When */
        $sortedLinkedList = SortedLinkedList::ofStrings(direction: Direction::DESC);

        // @Then
        self::assertSame(Type::STRING, $sortedLinkedList->type);
        self::assertSame(Direction::DESC, $sortedLinkedList->direction);
    }
}
