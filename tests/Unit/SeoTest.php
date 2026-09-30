<?php

namespace Tests\Unit;

use App\Support\Seo;
use App\Support\ToolRegistry;
use Tests\TestCase;

class SeoTest extends TestCase
{
    public function test_limit_trims_on_word_boundary(): void
    {
        $this->assertSame('Short text', Seo::limit('Short   text', 160));
        $this->assertSame('one two…', Seo::limit('one two three four', 10));
    }

    public function test_related_tools_never_include_the_tool_itself(): void
    {
        $registry = new ToolRegistry([
            'a' => ['name' => 'A', 'category' => 'x', 'related' => ['a', 'b', 'missing']],
            'b' => ['name' => 'B', 'category' => 'x'],
            'c' => ['name' => 'C', 'category' => 'y', 'popular' => true],
        ], ['x' => ['name' => 'X'], 'y' => ['name' => 'Y']]);

        $related = $registry->related($registry->find('a'));

        $this->assertSame(['b', 'c'], $related->keys()->all());
    }
}
