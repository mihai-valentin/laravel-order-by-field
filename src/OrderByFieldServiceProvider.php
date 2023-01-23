<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;
use MihaiValentin\LaravelOrderByFiled\Compiler\OrderByFieldCompilerFactory;

final class OrderByFieldServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $orderByFieldMacro = function (string $field, array $order, string $direction = 'asc') {
            /** @var Builder|EloquentBuilder $this */

            $grammar = $this->getGrammar();

            $sql = OrderByFieldCompilerFactory::createFromGrammar($grammar)
                ->compile($field, $order, $direction)
            ;

            return $this->orderByRaw($sql);
        };

        $orderByFieldDescMacro = function (string $field, array $order) {
            /** @var Builder|EloquentBuilder $this */

            $grammar = $this->getGrammar();

            $sql = OrderByFieldCompilerFactory::createFromGrammar($grammar)
                ->compile($field, $order, 'desc')
            ;

            return $this->orderByRaw($sql);
        };

        Builder::macro('orderByField', $orderByFieldMacro);
        Builder::macro('orderByFieldDesc', $orderByFieldDescMacro);

        EloquentBuilder::macro('orderByField', $orderByFieldMacro);
        EloquentBuilder::macro('orderByFieldDesc', $orderByFieldDescMacro);
    }
}
