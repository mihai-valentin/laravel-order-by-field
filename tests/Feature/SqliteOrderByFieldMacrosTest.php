<?php

/**
 * @noinspection SqlNoDataSourceInspection
 * @noinspection SqlResolve
 * @noinspection SqlRedundantOrderingDirection
 */

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Feature;

use Illuminate\Support\Facades\DB;

final class SqliteOrderByFieldMacrosTest extends OrderByFieldMacrosTest
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    /**
     * @dataProvider orderByFieldDataProvider
     */
    public function testWillCallOrderByFieldMacrosSuccessfully(
        string $column,
        array $order,
        ?string $direction,
        string $expectedSql
    ): void {
        $direction ??= 'asc';

        $sql = DB::table('actions_log')
            ->orderByField($column, $order, $direction)
            ->toSql()
        ;

        $this->assertEquals($expectedSql, $sql);
    }

    private function orderByFieldDataProvider(): array
    {
        return [
            [
                'status',
                ['new', 'published', 'rejected'],
                null,
                "select * from \"actions_log\" order by (case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) asc"
            ],
            [
                'status',
                ['new', 'published', 'rejected'],
                'asc',
                "select * from \"actions_log\" order by (case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) asc"
            ],
            [
                'status',
                ['new', 'published', 'rejected'],
                'desc',
                "select * from \"actions_log\" order by (case when \"status\"='new' then 1 when \"status\"='published' then 2 when \"status\"='rejected' then 3 else 0 end) desc"
            ],
        ];
    }
}
