<?php

declare(strict_types=1);

namespace Illuminate\Contracts\Database\Query {

    use MihaiValentin\LaravelOrderByFiled\OrderByFieldServiceProvider;

    /**
     * @method Builder orderByField(string $column, array $orders, string $direction = 'asc')
     * @see OrderByFieldServiceProvider
     */
    interface Builder {}
}
