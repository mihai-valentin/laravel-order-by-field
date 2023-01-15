<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled\Strategy;

final class CommonOrderByFieldCompilationStrategy extends OrderByFieldCompilationStrategy
{
    public function compile(string $column, array $order, string $direction = 'asc'): string
    {
        $whens = [];
        $wrappedColumn = $this->grammar->wrap($column);

        foreach ($order as $index => $value) {
            $whens[] = 'when ' . $wrappedColumn . '=' . $this->grammar->quoteString($value) . ' then ' . ($index + 1);
        }

        return '(case ' . implode(' ', $whens) . ' else 0 end) ' . $direction;
    }
}
