<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use MihaiValentin\LaravelOrderByFiled\Compiler\OrderByFieldCompilerFactory;

final class OrderByFieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        Builder::macro('orderByField', function (string $field, array $order, string $direction = 'asc') {
            /** @var Builder $this */

            $grammar = $this->getGrammar();

            $sql = OrderByFieldCompilerFactory::createFromGrammar($grammar)->compile($field, $order, $direction);

            return $this->orderByRaw($sql);
        });

        Builder::macro('orderByFieldDesc', function (string $field, array $order) {
            /** @var Builder $this */

            $grammar = $this->getGrammar();

            $sql = OrderByFieldCompilerFactory::createFromGrammar($grammar)->compile($field, $order, 'desc');

            return $this->orderByRaw($sql);
        });
    }
}
