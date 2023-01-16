<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Integration\Config;

final class PgSql
{
    public const DRIVER = 'pgsql';
    public const HOST = '127.0.0.1';
    public const PORT = 5432;
    public const USERNAME = 'root';
    public const PASSWORD = '123';
    public const DATABASE = 'test';
}
