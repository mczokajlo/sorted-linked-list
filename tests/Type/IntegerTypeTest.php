<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\Type;

use Mczokajlo\SortedLinkedList\Type\Direction;
use Mczokajlo\SortedLinkedList\Type\IntegerType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(IntegerType::class)]
#[CoversClass(Direction::class)]
final class IntegerTypeTest extends TestCase
{
    #[DataProvider('compareDataProvide')]
    public function testCompare(Direction $direction, int $value1, int $value2, int $expected): void
    {
        /** @Given */
        $integerType = new IntegerType(direction: $direction);

        /** @When */
        $result = $integerType->compareValues(left: $value1, right: $value2);

        /** @Then */
        self::assertSame($expected, $result);
    }

    /**
     * @return iterable<non-empty-string, array{direction: Direction, value1: int, value2: int, expected: -1|0|1}>
     */
    public static function compareDataProvide(): iterable
    {
        yield '0 = 0 ASC' => [
            'direction' => Direction::ASC,
            'value1' => 0,
            'value2' => 0,
            'expected' => 0,
        ];

        yield '0 = 0 DESC' => [
            'direction' => Direction::DESC,
            'value1' => 0,
            'value2' => 0,
            'expected' => 0,
        ];

        yield '1 > -1 ASC' => [
            'direction' => Direction::ASC,
            'value1' => 1,
            'value2' => -1,
            'expected' => 1,
        ];

        yield '1 < -1 DESC' => [
            'direction' => Direction::DESC,
            'value1' => 1,
            'value2' => -1,
            'expected' => -1,
        ];

        yield '-1 < 1 ASC' => [
            'direction' => Direction::ASC,
            'value1' => -1,
            'value2' => 1,
            'expected' => -1,
        ];

        yield '-1 > 1 DESC' => [
            'direction' => Direction::DESC,
            'value1' => -1,
            'value2' => 1,
            'expected' => 1,
        ];

        yield 'PHP_INT_MAX > -PHP_INT_MAX ASC' => [
            'direction' => Direction::ASC,
            'value1' => PHP_INT_MAX,
            'value2' => -PHP_INT_MAX,
            'expected' => 1,
        ];

        yield 'PHP_INT_MAX < -PHP_INT_MAX DESC' => [
            'direction' => Direction::DESC,
            'value1' => PHP_INT_MAX,
            'value2' => -PHP_INT_MAX,
            'expected' => -1,
        ];
    }

    public function testSupportedType(): void
    {
        /** @Given */
        $integerType = new IntegerType(direction: Direction::ASC);

        /** @When */
        $result = $integerType->supports(value: 1);

        /** @Then */
        self::assertTrue($result);
    }

    #[DataProvider('unsupportedTypesProvider')]
    public function testUnsuportedTypes(mixed $value): void
    {
        /** @Given */
        $integerType = new IntegerType(direction: Direction::ASC);

        /** @When */
        $result = $integerType->supports(value: $value);

        /** @Then */
        self::assertFalse($result);
    }

    /**
     * @return iterable<non-empty-string, array{value: mixed}>
     */
    public static function unsupportedTypesProvider(): iterable
    {
        yield 'float' => [
            'value' => 1.1,
        ];

        yield 'string' => [
            'value' => '1',
        ];

        yield 'array' => [
            'value' => [],
        ];

        yield 'object' => [
            'value' => new \stdClass(),
        ];

        yield 'null' => [
            'value' => null,
        ];

        yield 'bool' => [
            'value' => true,
        ];
    }
}
