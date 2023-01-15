<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByFiled\Compiler;

use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use MihaiValentin\LaravelOrderByFiled\Strategy\CommonOrderByFieldCompilationStrategy;
use MihaiValentin\LaravelOrderByFiled\Strategy\MySqlOrderByFieldCompilationStrategy;
use MihaiValentin\LaravelOrderByFiled\Strategy\OrderByFieldCompilationStrategy;

final class OrderByFieldCompilerFactory
{
    public static function createFromGrammar(Grammar $grammar): OrderByFieldCompiler
    {
        $strategy = self::resolveStrategyByGrammar($grammar);

        return new OrderByFieldCompiler($strategy);
    }

    private static function resolveStrategyByGrammar(Grammar $grammar): OrderByFieldCompilationStrategy
    {
        if ($grammar instanceof MySqlGrammar) {
            return new MySqlOrderByFieldCompilationStrategy($grammar);
        }

        return new CommonOrderByFieldCompilationStrategy($grammar);
    }
}
