<?php

namespace Tests\Feature;

use Tests\TestCase;

class IndexPhpRedirectTest extends TestCase
{
    public function test_index_php_urls_redirect_permanently_to_the_clean_url(): void
    {
        $this->get('/index.php')->assertStatus(301)->assertRedirect('/');
        $this->get('/index.php/merge-pdf')->assertStatus(301)->assertRedirect('/merge-pdf');
        $this->get('/index.php/de/merge-pdf?x=1')->assertStatus(301)->assertRedirect('/de/merge-pdf?x=1');
    }

    public function test_clean_urls_are_not_redirected(): void
    {
        $this->get('/merge-pdf')->assertOk();
        $this->get('/')->assertOk();
    }
}
