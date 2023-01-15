<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Unit;

use Illuminate\Database\Query\Grammars\PostgresGrammar;
use Illuminate\Database\Query\Grammars\SQLiteGrammar;
use MihaiValentin\LaravelOrderByFiled\Strategy\CommonOrderByFieldCompilationStrategy;
use MihaiValentin\LaravelOrderByFiled\Strategy\OrderByFieldCompilationStrategy;
use PHPUnit\Framework\TestCase;

final class CommonOrderByFieldCompilationStrategyTest extends TestCase
{
    /**
     * @dataProvider orderByFieldCompilationDataProvider
     */
    public function testWillCompileOrderByFieldClause(
        OrderByFieldCompilationStrategy $compilationStrategy,
        string $column,
        array $order,
        ?string $direction,
        string $expectedSql
    ): void {
        if ($direction === null) {
            $sql = $compilationStrategy->compile($column, $order);
        } else {
            $sql = $compilationStrategy->compile($column, $order, $direction);
        }

        $this->assertEquals($expectedSql, $sql);
    }

    private function orderByFieldCompilationDataProvider(): array
    {
        $sqliteGrammar = new SQLiteGrammar();
        $sqliteCompilationStrategy = new CommonOrderByFieldCompilationStrategy($sqliteGrammar);

        $postgresGrammar = new PostgresGrammar();
        $postgresCompilationStrategy = new CommonOrderByFieldCompilationStrategy($postgresGrammar);

        return [
            [
                $sqliteCompilationStrategy,
                'status',
                ['new', 'published', 'rejected'],
                null,
                "(case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) asc",
            ],
            [
                $sqliteCompilationStrategy,
                'status',
                ['new', 'published', 'rejected'],
                'asc',
                "(case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) asc",
            ],
            [
                $sqliteCompilationStrategy,
                'status',
                ['new', 'published', 'rejected'],
                'desc',
                "(case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) desc",
            ],
            [
                $postgresCompilationStrategy,
                'status',
                ['new', 'published', 'rejected'],
                null,
                "(case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) asc",
            ],
            [
                $postgresCompilationStrategy,
                'status',
                ['new', 'published', 'rejected'],
                'asc',
                "(case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) asc",
            ],
            [
                $postgresCompilationStrategy,
                'status',
                ['new', 'published', 'rejected'],
                'desc',
                "(case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) desc",
            ],
        ];
    }
}
