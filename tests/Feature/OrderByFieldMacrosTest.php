<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Feature;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use MihaiValentin\LaravelOrderByFiled\OrderByFieldServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class OrderByFieldMacrosTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            OrderByFieldServiceProvider::class,
        ];
    }

    public function testWillCompileOrderByFieldSqlFailWithEmptyColumnName(): void
    {
        $exception = new InvalidArgumentException('The $column argument must be a non-empty string');
        $this->expectExceptionObject($exception);

        DB::table('actions_log')
            ->orderByField('', ['new', 'published', 'rejected'], 'desc')
            ->toSql()
        ;
    }

    public function testWillCompileOrderByFieldSqlFailWithEmptyOrderArray(): void
    {
        $exception = new InvalidArgumentException('The $order argument must be a non-empty list of strings');
        $this->expectExceptionObject($exception);

        DB::table('actions_log')
            ->orderByField('status', [], 'desc')
            ->toSql()
        ;
    }

    public function testWillCompileOrderByFieldSqlFailWithWrongDirection(): void
    {
        $exception = new InvalidArgumentException('The $direction argument must be one of: "asc", "desc"');
        $this->expectExceptionObject($exception);

        DB::table('actions_log')
            ->orderByField('status', ['new', 'published', 'rejected'], 'wrong_direction')
            ->toSql()
        ;
    }
}
