<?php

declare(strict_types=1);

namespace MihaiValentin\LaravelOrderByField\Tests\Unit;

use Illuminate\Database\Query\Grammars\MySqlGrammar;
use MihaiValentin\LaravelOrderByFiled\Strategy\MySqlOrderByFieldCompilationStrategy;
use PHPUnit\Framework\TestCase;

final class MySqlOrderByFieldCompilationStrategyTest extends TestCase
{
    private MySqlOrderByFieldCompilationStrategy $compilationStrategy;

    protected function setUp(): void
    {
        parent::setUp();

        $grammar = new MySqlGrammar();
        $this->compilationStrategy = new MySqlOrderByFieldCompilationStrategy($grammar);
    }

    public function testWillCompileOrderByFieldClause(): void
    {
        $sql = $this->compilationStrategy->compile('status', ['new', 'published', 'rejected']);

        $this->assertEquals("field(`status`,'new','published','rejected') asc", $sql);
    }

    public function testWillCompileOrderByFieldAscClause(): void
    {
        $sql = $this->compilationStrategy->compile(
            'status',
            ['new', 'published', 'rejected'],
            'asc',
        );

        $this->assertEquals("field(`status`,'new','published','rejected') asc", $sql);
    }

    public function testWillCompileOrderByFieldDescClause(): void
    {
        $sql = $this->compilationStrategy->compile(
            'status',
            ['new', 'published', 'rejected'],
            'desc',
        );

        $this->assertEquals("field(`status`,'new','published','rejected') desc", $sql);
    }
}
