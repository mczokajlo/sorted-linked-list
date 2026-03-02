<?php

declare(strict_types=1);

namespace Mczokajlo\SortedLinkedList\Tests\Type;

use Mczokajlo\SortedLinkedList\Type\Direction;
use Mczokajlo\SortedLinkedList\Type\StringType;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(StringType::class)]
#[CoversClass(Direction::class)]
final class StringTypeTest extends TestCase
{
    #[DataProvider('compareDataProvide')]
    public function testCompare(Direction $direction, string $value1, string $value2, int $expected): void
    {
        /** @Given */
        $stringType = new StringType(direction: $direction);

        /** @When */
        $result = $stringType->compareValues(left: $value1, right: $value2);

        /** @Then */
        self::assertSame($expected, $result);
    }

    /**
     * @return iterable<non-empty-string, array{direction: Direction, value1: string, value2: string, expected: -1|0|1}>
     */
    public static function compareDataProvide(): iterable
    {
        yield '"a" = "a" ASC' => [
            'direction' => Direction::ASC,
            'value1' => 'a',
            'value2' => 'a',
            'expected' => 0,
        ];

        yield '"a" = "a" DESC' => [
            'direction' => Direction::DESC,
            'value1' => 'a',
            'value2' => 'a',
            'expected' => 0,
        ];

        yield '"b" > "a" ASC' => [
            'direction' => Direction::ASC,
            'value1' => 'b',
            'value2' => 'a',
            'expected' => 1,
        ];

        yield '"b" < "a" DESC' => [
            'direction' => Direction::DESC,
            'value1' => 'b',
            'value2' => 'a',
            'expected' => -1,
        ];

        yield '"a" < "b" ASC' => [
            'direction' => Direction::ASC,
            'value1' => 'a',
            'value2' => 'b',
            'expected' => -1,
        ];

        yield '"a" > "b" DESC' => [
            'direction' => Direction::DESC,
            'value1' => 'a',
            'value2' => 'b',
            'expected' => 1,
        ];

        yield '"" = "" ASC' => [
            'direction' => Direction::ASC,
            'value1' => '',
            'value2' => '',
            'expected' => 0,
        ];

        yield '"" < "a" ASC' => [
            'direction' => Direction::ASC,
            'value1' => '',
            'value2' => 'a',
            'expected' => -1,
        ];

        yield 'long string comparison ASC' => [
            'direction' => Direction::ASC,
            'value1' => str_repeat('z', 1000),
            'value2' => str_repeat('a', 1000),
            'expected' => 1,
        ];

        yield 'long string comparison DESC' => [
            'direction' => Direction::DESC,
            'value1' => str_repeat('z', 1000),
            'value2' => str_repeat('a', 1000),
            'expected' => -1,
        ];
    }

    public function testSupportedType(): void
    {
        /** @Given */
        $stringType = new StringType(direction: Direction::ASC);

        /** @When */
        $result = $stringType->supports(value: 'hello');

        /** @Then */
        self::assertTrue($result);
    }

    #[DataProvider('unsupportedTypesProvider')]
    public function testUnsuportedTypes(mixed $value): void
    {
        /** @Given */
        $stringType = new StringType(direction: Direction::ASC);

        /** @When */
        $result = $stringType->supports(value: $value);

        /** @Then */
        self::assertFalse($result);
    }

    /**
     * @return iterable<non-empty-string, array{value: mixed}>
     */
    public static function unsupportedTypesProvider(): iterable
    {
        yield 'int' => [
            'value' => 1,
        ];

        yield 'float' => [
            'value' => 1.1,
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
