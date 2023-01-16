<?php

/**
 * @noinspection SqlNoDataSourceInspection
 * @noinspection SqlResolve
 * @noinspection SqlRedundantOrderingDirection
 */

declare(strict_types=1);

use Illuminate\Support\Facades\DB;
use MihaiValentin\LaravelOrderByField\Tests\Feature\OrderByFieldMacrosFeatureTest;

final class MySqlOrderByFieldDescMacrosFeatureTest extends OrderByFieldMacrosFeatureTest
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver'   => 'mysql',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    public function testWillCallOrderByFieldDescMacrosSuccessfully(): void {
        $sql = DB::table('actions_log')
            ->orderByFieldDesc('status', ['new', 'published', 'rejected'])
            ->toSql()
        ;

        $this->assertEquals(
            "select * from `actions_log` order by field(`status`,'new','published','rejected') desc",
            $sql,
        );
    }
}
