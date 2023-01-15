<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled\Strategy;

use Illuminate\Database\Query\Grammars\Grammar;

abstract class OrderByFieldCompilationStrategy
{
    protected Grammar $grammar;

    public function __construct(Grammar $grammar)
    {
        $this->grammar = $grammar;
    }

    /**
     * @phpstan-param non-empty-string $column
     * @phpstan-param non-empty-array<int, string> $order
     * @phpstan-param string $direction
     */
    abstract public function compile(string $column, array $order, string $direction = 'asc'): string;
}
