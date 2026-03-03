# mczokajlo/sorted-linked-list

![PHP 8.4+](https://img.shields.io/badge/PHP-8.4%2B-blue)
![License: MIT](https://img.shields.io/badge/License-MIT-green)

A type-safe sorted linked list implementation for PHP 8.4+.

## Features

- Generic type support via PHP templates
- Pluggable type system -- implement `TypeInterface` for custom types
- Built-in `IntegerType` and `StringType` handlers
- Ascending and descending sort order via `Direction` enum
- Iterable -- implements `IteratorAggregate`
- Zero runtime dependencies

## Requirements

- PHP 8.4 or higher

## Installation

```bash
composer require mczokajlo/sorted-linked-list
```

## Usage

### Basic usage with integers

```php
use Mczokajlo\SortedLinkedList\SortedLinkedList;
use Mczokajlo\SortedLinkedList\Type\IntegerType;
use Mczokajlo\SortedLinkedList\Type\Direction;

$list = new SortedLinkedList(new IntegerType(Direction::ASC));

$list->insert(3);
$list->insert(1);
$list->insert(2);

foreach ($list as $value) {
    echo $value . PHP_EOL; // 1, 2, 3
}

$list->first();    // 1
$list->isEmpty();  // false
$list->remove(2);  // true
```

### Descending order with strings

```php
use Mczokajlo\SortedLinkedList\SortedLinkedList;
use Mczokajlo\SortedLinkedList\Type\StringType;
use Mczokajlo\SortedLinkedList\Type\Direction;

$list = new SortedLinkedList(new StringType(Direction::DESC));

$list->insert('banana');
$list->insert('apple');
$list->insert('cherry');

foreach ($list as $value) {
    echo $value . PHP_EOL; // cherry, banana, apple
}
```

### Custom type handler

Implement `TypeInterface` to support any type:

```php
use Mczokajlo\SortedLinkedList\Contract\TypeInterface;
use Mczokajlo\SortedLinkedList\Type\Direction;

/**
 * @implements TypeInterface<float>
 */
final readonly class FloatType implements TypeInterface
{
    public function __construct(
        private Direction $direction,
    ) {}

    public function compareValues(mixed $left, mixed $right): int
    {
        $comparison = $left <=> $right;

        if ($this->direction === Direction::DESC) {
            return $comparison * -1;
        }

        return $comparison;
    }

    public function supports(mixed $value): bool
    {
        return is_float($value);
    }
}
```

## Type Safety

This library provides two layers of type safety: static analysis via PHPStan generics and runtime validation.

### Generics via PHPStan

The `@template TValue` annotations on `TypeInterface` and `SortedLinkedList` enable full generic type checking. When you create a list with `IntegerType`, PHPStan infers it as `SortedLinkedList<int>` and catches type errors at analysis time:

```php
$list = new SortedLinkedList(new IntegerType(Direction::ASC));
$list->insert('not an integer'); // PHPStan error: Parameter #1 $value expects int, string given
```

This project enforces PHPStan level max with 100% type coverage.

### Runtime validation

If PHPStan is not used (or a type error slips through `mixed`), the list throws `TypeMismatchException` at runtime when a value fails the `supports()` check.

### Recommended setup for consumers

Install PHPStan in your project to get full generic type checking:

```bash
composer require --dev phpstan/phpstan
```

## API Reference

### `SortedLinkedList`

| Method | Returns | Description |
|---|---|---|
| `__construct(TypeInterface $type)` | | Create a new list with the given type handler |
| `insert(mixed $value)` | `SortedLinkedListInterface` | Insert a value in sorted position |
| `remove(mixed $value)` | `bool` | Remove the first occurrence of a value |
| `first()` | `mixed` | Get the first (smallest/largest) value |
| `isEmpty()` | `bool` | Check if the list is empty |
| `getIterator()` | `Generator` | Iterate over values in sorted order |

### `TypeInterface`

| Method | Returns | Description |
|---|---|---|
| `compareValues(mixed $left, mixed $right)` | `int` | Compare two values (negative, zero, or positive) |
| `supports(mixed $value)` | `bool` | Check if a value is of the supported type |

### Built-in types

- `IntegerType(Direction $direction)` -- sorted integers
- `StringType(Direction $direction)` -- sorted strings (using `strcmp`)

### `Direction` enum

- `Direction::ASC` -- ascending order (smallest first)
- `Direction::DESC` -- descending order (largest first)

### Exceptions

All exceptions extend `SortedLinkedListException` (which extends `RuntimeException`):

- `EmptyListException` -- thrown when calling `first()` on an empty list
- `TypeMismatchException` -- thrown when inserting a value that doesn't match the list's type

## Docker Setup

Build the container (PHP 8.4-cli with Composer and Xdebug):

```bash
docker compose build
```

Xdebug is enabled with `coverage` and `debug` modes.

## Development

All commands use the `bin/composer` wrapper, which auto-detects the environment: when run outside Docker, it executes inside the container via `docker compose run`; when run inside the container, it calls `composer` directly.

```bash
# Install dependencies
bin/composer install

# Run tests
bin/composer test

# Run all quality checks (linting, static analysis, coding standards, dependency analysis)
bin/composer check

# Auto-fix coding standards and apply Rector refactoring
bin/composer fix
```

## License

MIT
