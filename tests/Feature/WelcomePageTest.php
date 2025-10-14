<?php

namespace Tests\Feature;

use Tests\TestCase;

class WelcomePageTest extends TestCase
{
    public function test_welcome_page_can_be_rendered(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee("Let's get started", false);
        $response->assertSee('Laravel has an incredibly rich ecosystem');
    }

    public function test_welcome_page_contains_navigation_when_routes_exist(): void
    {
        if (!\Route::has('login')) {
            $this->markTestSkipped('Login route not available');
        }

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Log in');
    }

    public function test_welcome_page_contains_register_link(): void
    {
        if (!\Route::has('register')) {
            $this->markTestSkipped('Register route not available');
        }

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Register');
    }

    public function test_welcome_page_contains_external_links(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('https://laravel.com/docs');
        $response->assertSee('https://laracasts.com');
        $response->assertSee('https://cloud.laravel.com');
    }

    public function test_welcome_page_has_proper_structure(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('<html', false);
        $response->assertSee('Laravel', false);
        $response->assertSee('Documentation');
        $response->assertSee('Laracasts');
        $response->assertSee('Deploy now');
    }
}
