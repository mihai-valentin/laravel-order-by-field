<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Unit;

use Illuminate\Database\Query\Grammars\MySqlGrammar;
use InvalidArgumentException;
use MihaiValentin\LaravelOrderByFiled\Compiler\OrderByFieldCompiler;
use MihaiValentin\LaravelOrderByFiled\Strategy\MySqlOrderByFieldCompilationStrategy;
use PHPUnit\Framework\TestCase;

final class OrderByFieldCompilerTest extends TestCase
{
    private OrderByFieldCompiler $compiler;

    protected function setUp(): void
    {
        parent::setUp();

        $grammar = new MySqlGrammar();
        $compilerStrategy = new MySqlOrderByFieldCompilationStrategy($grammar);

        $this->compiler = new OrderByFieldCompiler($compilerStrategy);
    }

    public function testWillCompileOrderByFieldSqlSuccessfully(): void
    {
        $sql = $this->compiler->compile('status', ['new', 'published', 'rejected'], 'desc');

        $this->assertEquals("field(`status`,'new','published','rejected') desc", $sql);
    }

    public function testWillCompileOrderByFieldSqlFailWithEmptyColumnName(): void
    {
        $exception = new InvalidArgumentException('The $column argument must be a non-empty string');
        $this->expectExceptionObject($exception);

        $this->compiler->compile('', ['new', 'published', 'rejected'], 'desc');
    }

    public function testWillCompileOrderByFieldSqlFailWithEmptyOrderArray(): void
    {
        $exception = new InvalidArgumentException('The $order argument must be a non-empty list of strings');
        $this->expectExceptionObject($exception);

        $this->compiler->compile('status', [], 'desc');
    }

    public function testWillCompileOrderByFieldSqlFailWithWrongDirection(): void
    {
        $exception = new InvalidArgumentException('The $direction argument must be one of: "asc", "desc"');
        $this->expectExceptionObject($exception);

        $this->compiler->compile('status', ['new', 'published', 'rejected'], 'wrong_direction');
    }
}
