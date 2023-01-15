<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Integration;

use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use MihaiValentin\LaravelOrderByFiled\OrderByFieldServiceProvider;
use Orchestra\Testbench\TestCase;

abstract class OrderByFieldTest extends TestCase
{
    protected function getPackageProviders($app): array
    {
        return [
            OrderByFieldServiceProvider::class,
        ];
    }

    public function testWillThrowInvalidArgumentExceptionTryingToOrderRowsByEmptyColumnName(): void
    {
        $exception = new InvalidArgumentException('The $column argument must be a non-empty string');
        $this->expectExceptionObject($exception);

        DB::table('test_log')
            ->orderByField('', ['new', 'published', 'rejected'])
            ->get()
        ;
    }

    public function testWillThrowInvalidArgumentExceptionTryingToOrderRowsWithEmptyOrderArray(): void
    {
        $exception = new InvalidArgumentException('The $order argument must be a non-empty list of strings');
        $this->expectExceptionObject($exception);

        DB::table('test_log')
            ->orderByField('status', [])
            ->get()
        ;
    }

    public function testWillThrowInvalidArgumentExceptionTryingToOrderRowsWithWrongDirection(): void
    {
        $exception = new InvalidArgumentException('The $direction argument must be one of: "asc", "desc"');
        $this->expectExceptionObject($exception);

        DB::table('test_log')
            ->orderByField('status', ['new', 'published', 'rejected'], 'wrong_direction')
            ->get()
        ;
    }
}
