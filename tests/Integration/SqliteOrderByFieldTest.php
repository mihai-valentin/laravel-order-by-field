<?php

/** @noinspection SqlNoDataSourceInspection */

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Integration;

use Illuminate\Support\Facades\DB;
use MihaiValentin\LaravelOrderByField\Tests\Config\Sqlite;

final class SqliteOrderByFieldTest extends OrderByFieldTest
{
    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'test');
        $app['config']->set('database.connections.test', [
            'driver' => Sqlite::DRIVER,
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    protected function setUp(): void
    {
        parent::setUp();

        DB::statement('drop table if exists "test_log";');
        DB::statement('create table "test_log" (
            "id" integer,
            "status" varchar(20),
            "date" date
        );');

        DB::table('test_log')->insert([
            ['id' => 1, 'status' => 'published', 'date' => date('Y-m-d')],
            ['id' => 2, 'status' => 'new', 'date' => date('Y-m-d')],
            ['id' => 3, 'status' => 'rejected', 'date' => date('Y-m-d')],
            ['id' => 4, 'status' => 'undefined', 'date' => date('Y-m-d')],
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
