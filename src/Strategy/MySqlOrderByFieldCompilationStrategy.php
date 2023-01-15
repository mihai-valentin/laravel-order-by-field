<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled\Strategy;

final class MySqlOrderByFieldCompilationStrategy extends OrderByFieldCompilationStrategy
{
    public function compile(string $column, array $order, string $direction = 'asc'): string
    {
        $wrappedColumn = $this->grammar->wrap($column);
        $orderString = implode(',', array_map([$this->grammar, 'quoteString'], $order));

        return 'field(' . $wrappedColumn . ',' . $orderString . ') ' . $direction;
    }
}
