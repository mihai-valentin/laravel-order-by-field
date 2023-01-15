<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Integration;

use Illuminate\Support\Facades\DB;
use MihaiValentin\LaravelOrderByField\Tests\Config\MySql;
use MihaiValentin\LaravelOrderByField\Tests\Config\PgSql;
use MihaiValentin\LaravelOrderByField\Tests\Config\Sqlite;
use MihaiValentin\LaravelOrderByFiled\OrderByFieldServiceProvider;
use Orchestra\Testbench\TestCase;

final class MultiConnectionOrderByFieldTest extends TestCase
{
    public function testWillGetSameResultUsingDifferentDBMS(): void
    {
        $this->loadData();

        $mysqlOrder = DB::connection('mysql')
            ->table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'])
            ->get()
            ->pluck('status')
            ->toArray()
        ;

        $pgsqlOrder = DB::connection('pgsql')
            ->table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'])
            ->get()
            ->pluck('status')
            ->toArray()
        ;

        $sqliteOrder = DB::connection('sqlite')
            ->table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'])
            ->get()
            ->pluck('status')
            ->toArray()
        ;

        $expectedOrder = ['undefined', 'new', 'published', 'rejected'];

        $this->assertEquals($expectedOrder, $mysqlOrder);
        $this->assertEquals($expectedOrder, $pgsqlOrder);
        $this->assertEquals($expectedOrder, $sqliteOrder);
    }

    protected function getPackageProviders($app): array
    {
        return [
            OrderByFieldServiceProvider::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'mysql');

        $app['config']->set('database.connections.mysql', [
            'driver' => MySql::DRIVER,
            'host' => MySql::HOST,
            'port' => MySql::PORT,
            'username' => MySql::USERNAME,
            'password' => MySql::PASSWORD,
            'database' => MySql::DATABASE,
        ]);

        $app['config']->set('database.connections.pgsql', [
            'driver' => PgSql::DRIVER,
            'host' => PgSql::HOST,
            'port' => PgSql::PORT,
            'username' => PgSql::USERNAME,
            'password' => PgSql::PASSWORD,
            'database' => PgSql::DATABASE,
        ]);

        $app['config']->set('database.connections.sqlite', [
            'driver' => Sqlite::DRIVER,
            'database' => ':memory:',
            'prefix' => '',
        ]);
    }

    private function loadData(): void
    {
        DB::connection('mysql')->statement('drop table if exists `test_log`;');
        DB::connection('mysql')->statement('create table `test_log` (
            `id` int unsigned primary key auto_increment,
            `status` varchar(20),
            `date` date
        );');

        DB::connection('mysql')->table('test_log')->insert([
            ['status' => 'published', 'date' => date('Y-m-d')],
            ['status' => 'new', 'date' => date('Y-m-d')],
            ['status' => 'rejected', 'date' => date('Y-m-d')],
            ['status' => 'undefined', 'date' => date('Y-m-d')],
        ]);

        DB::connection('pgsql')->statement('drop table if exists "test_log";');
        DB::connection('pgsql')->statement('create table "test_log" (
            "id" serial primary key,
            "status" varchar(20),
            "date" date
        );');

        DB::connection('pgsql')->table('test_log')->insert([
            ['status' => 'published', 'date' => date('Y-m-d')],
            ['status' => 'new', 'date' => date('Y-m-d')],
            ['status' => 'rejected', 'date' => date('Y-m-d')],
            ['status' => 'undefined', 'date' => date('Y-m-d')],
        ]);

        DB::connection('sqlite')->statement('drop table if exists "test_log";');
        DB::connection('sqlite')->statement('create table "test_log" (
            "id" integer,
            "status" varchar(20),
            "date" date
        );');

        DB::connection('sqlite')->table('test_log')->insert([
            ['id' => 1, 'status' => 'published', 'date' => date('Y-m-d')],
            ['id' => 2, 'status' => 'new', 'date' => date('Y-m-d')],
            ['id' => 3, 'status' => 'rejected', 'date' => date('Y-m-d')],
            ['id' => 4, 'status' => 'undefined', 'date' => date('Y-m-d')],
        ]);
    }
}
