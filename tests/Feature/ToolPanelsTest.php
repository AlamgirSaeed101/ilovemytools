<?php

namespace Tests\Feature;

use App\Support\SiteData;
use Tests\TestCase;

class ToolPanelsTest extends TestCase
{
    /** Without a reserved height the page jumps when the tool loads (CLS): run scripts/measure-panels.mjs. */
    public function test_every_tool_has_a_measured_panel_height(): void
    {
        foreach (array_keys(config('tools')) as $slug) {
            $panel = SiteData::panelHeight($slug);
            $this->assertNotNull($panel, "$slug has no entry in resources/data/tool-panels.json");
            $this->assertGreaterThanOrEqual(200, $panel['sm']);
            $this->assertGreaterThanOrEqual(200, $panel['lg']);
        }
    }

    public function test_the_server_panel_reserves_the_height(): void
    {
        $this->withoutVite();
        $panel = SiteData::panelHeight('word-counter');

        $this->get('/word-counter')
            ->assertOk()
            ->assertSee("--panel-sm: {$panel['sm']}px; --panel-lg: {$panel['lg']}px", false);
    }
}
