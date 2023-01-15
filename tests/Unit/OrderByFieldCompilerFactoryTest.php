<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Unit;

use Illuminate\Database\Query\Grammars\Grammar;
use Illuminate\Database\Query\Grammars\MySqlGrammar;
use Illuminate\Database\Query\Grammars\PostgresGrammar;
use Illuminate\Database\Query\Grammars\SQLiteGrammar;
use MihaiValentin\LaravelOrderByFiled\Compiler\OrderByFieldCompilerFactory;
use MihaiValentin\LaravelOrderByFiled\Strategy\CommonOrderByFieldCompilationStrategy;
use MihaiValentin\LaravelOrderByFiled\Strategy\MySqlOrderByFieldCompilationStrategy;
use PHPUnit\Framework\TestCase;
use ReflectionObject;

final class OrderByFieldCompilerFactoryTest extends TestCase
{
    public function testWillCreateCompilerWithMySqlStrategyByMySqlGrammar(): void
    {
        $grammar = new MySqlGrammar();
        $compiler = OrderByFieldCompilerFactory::createFromGrammar($grammar);
        $compilerReflection = new ReflectionObject($compiler);
        $compilerStrategy = $compilerReflection->getProperty('orderByFieldGrammarStrategy');
        $compilerStrategy->setAccessible(true);

        $this->assertInstanceOf(
            MySqlOrderByFieldCompilationStrategy::class,
            $compilerStrategy->getValue($compiler)
        );
    }

    public function testWillCreateCompilerWithMySqlStrategyBySqliteGrammar(): void
    {
        $grammar = new SQLiteGrammar();
        $compiler = OrderByFieldCompilerFactory::createFromGrammar($grammar);
        $compilerReflection = new ReflectionObject($compiler);
        $compilerStrategy = $compilerReflection->getProperty('orderByFieldGrammarStrategy');
        $compilerStrategy->setAccessible(true);

        $this->assertInstanceOf(
            CommonOrderByFieldCompilationStrategy::class,
            $compilerStrategy->getValue($compiler)
        );
    }

    public function testWillCreateCompilerWithMySqlStrategyByPostgresGrammar(): void
    {
        $grammar = new PostgresGrammar();
        $compiler = OrderByFieldCompilerFactory::createFromGrammar($grammar);
        $compilerReflection = new ReflectionObject($compiler);
        $compilerStrategy = $compilerReflection->getProperty('orderByFieldGrammarStrategy');
        $compilerStrategy->setAccessible(true);

        $this->assertInstanceOf(
            CommonOrderByFieldCompilationStrategy::class,
            $compilerStrategy->getValue($compiler)
        );
    }

    public function testWillCreateCompilerWithMySqlStrategyByCommonGrammar(): void
    {
        $grammar = new Grammar();
        $compiler = OrderByFieldCompilerFactory::createFromGrammar($grammar);
        $compilerReflection = new ReflectionObject($compiler);
        $compilerStrategy = $compilerReflection->getProperty('orderByFieldGrammarStrategy');
        $compilerStrategy->setAccessible(true);

        $this->assertInstanceOf(
            CommonOrderByFieldCompilationStrategy::class,
            $compilerStrategy->getValue($compiler)
        );
    }
}
