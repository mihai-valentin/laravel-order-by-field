<?php

declare(strict_types=1);

namespace Illuminate\Contracts\Database\Query;

use MihaiValentin\LaravelOrderByFiled\OrderByFieldServiceProvider;

/**
 * @method Builder orderByField(string $column, array $order, string $direction = 'asc')
 * @method Builder orderByFieldDesc(string $column, array $order)
 *
 * @see OrderByFieldServiceProvider
 */
interface Builder {}
