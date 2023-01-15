<?php

/** @noinspection SqlNoDataSourceInspection */

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Integration;

use Illuminate\Support\Facades\DB;
use MihaiValentin\LaravelOrderByField\Tests\Config\PgSql;

final class PostgresOrderByFieldTest extends OrderByFieldTest
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => PgSql::DRIVER,
            'host' => PgSql::HOST,
            'port' => PgSql::PORT,
            'username' => PgSql::USERNAME,
            'password' => PgSql::PASSWORD,
            'database' => PgSql::DATABASE,
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        DB::statement('drop table if exists "test_log";');
        DB::statement('create table "test_log" (
            "id" serial primary key,
            "status" varchar(20),
            "date" date
        );');

        DB::table('test_log')->insert([
            ['status' => 'published', 'date' => date('Y-m-d')],
            ['status' => 'new', 'date' => date('Y-m-d')],
            ['status' => 'rejected', 'date' => date('Y-m-d')],
            ['status' => 'undefined', 'date' => date('Y-m-d')],
        ]);
    }

    public function testWillRetrieveRowsOrderedByFieldAsc(): void
    {
        $rows = DB::table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'])
            ->get()
        ;

        $statusOrder = $rows->pluck('status')->toArray();

        $this->assertEquals(['undefined', 'new', 'published', 'rejected'], $statusOrder);

        $rows = DB::table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'], 'asc')
            ->get()
        ;

        $statusOrder = $rows->pluck('status')->toArray();

        $this->assertEquals(['undefined', 'new', 'published', 'rejected'], $statusOrder);
    }

    public function testWillRetrieveRowsOrderedByFieldDesc(): void
    {
        $rows = DB::table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'], 'desc')
            ->get()
        ;

        $statusOrder = $rows->pluck('status')->toArray();

        $this->assertEquals(['rejected', 'published', 'new', 'undefined'], $statusOrder);
    }
}
