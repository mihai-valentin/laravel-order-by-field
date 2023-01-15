<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled\Compiler;

use InvalidArgumentException;
use MihaiValentin\LaravelOrderByFiled\Strategy\OrderByFieldCompilationStrategy;

final class OrderByFieldCompiler
{
    private OrderByFieldCompilationStrategy $orderByFieldGrammarStrategy;

    public function __construct(OrderByFieldCompilationStrategy $orderByFieldGrammarStrategy)
    {
        $this->orderByFieldGrammarStrategy = $orderByFieldGrammarStrategy;
    }

    /**
     * @phpstan-param string $column
     * @phpstan-param array<int, string> $order
     * @phpstan-param string $direction
     *
     * @throws InvalidArgumentException
     */
    public function compile(string $column, array $order, string $direction = 'asc'): string
    {
        if ($column === '') {
            throw new InvalidArgumentException('The $column argument must be a non-empty string');
        }

        if ($order === []) {
            throw new InvalidArgumentException('The $order argument must be a non-empty list of strings');
        }

        $direction = strtolower($direction);

        if (!in_array($direction, ['asc', 'desc'])) {
            throw new InvalidArgumentException('The $direction argument must be one of: "asc", "desc"');
        }

        return $this->orderByFieldGrammarStrategy->compile($column, $order, $direction);
    }
}
