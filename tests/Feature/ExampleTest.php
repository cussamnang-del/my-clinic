<?php

namespace Tests\Feature;

use Tests\TestCase;

/**
 * Smoke test: the application boots and the root URL redirects an
 * unauthenticated visitor to the login page (post-Phase-0 routing).
 */
class ExampleTest extends TestCase
{
    public function test_root_redirects_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }

    public function test_login_page_renders(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk();
        $response->assertSee('Login', false);
    }
}
